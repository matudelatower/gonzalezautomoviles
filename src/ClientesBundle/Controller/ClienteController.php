<?php

namespace ClientesBundle\Controller;

use ClientesBundle\Form\PersonaClienteType;
use ClientesBundle\Form\Filter\ClientesFilterType;
use PersonasBundle\Entity\Persona;
use PersonasBundle\Entity\PersonaTipo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ClientesBundle\Entity\Cliente;
use ClientesBundle\Form\ClienteType;
use UsuariosBundle\Controller\TokenAuthenticatedController;

/**
 * Cliente controller.
 *
 */
class ClienteController extends Controller implements TokenAuthenticatedController {

    /**
     * Lists all Cliente entities.
     *
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ClientesFilterType());

        if ($request->isMethod("post")) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('ClientesBundle:Cliente')->getClientesFilter($data);
            }
        } else {
            $entities = $em->getRepository('ClientesBundle:Cliente')->getClientesFilter();
        }
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );

        return $this->render('ClientesBundle:Cliente:index.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
        ));
    }

    public function nuevoClienteAction(Request $request) {


        $form = $this->get('manager.personas')->formBuscadorPersonas('clientes_new');


        return $this->render('PersonasBundle:Default:buscadorPersona.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new Cliente entity.
     *
     */
    public function createAction(Request $request) {

        $entity = new PersonaTipo();

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                    'success', 'Cliente creado correctamente.'
            );

            return $this->redirect($this->generateUrl('clientes_show', array('id' => $entity->getCliente()->getId())));
        }

        return $this->render('ClientesBundle:Cliente:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Cliente entity.
     *
     * @param Cliente $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PersonaTipo $entity) {
//		$form = $this->createForm( new ClienteType(),
        $form = $this->createForm(new PersonaClienteType(), $entity, array(
            'action' => $this->generateUrl('clientes_create'),
            'method' => 'POST',
            'attr' => array('class' => 'box-body')
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Crear',
            'attr' => array('class' => 'btn btn-primary pull-right')
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Cliente entity.
     *
     */
    public function newAction(Request $request) {


        $em = $this->getDoctrine()->getManager();
        $form = $this->get('manager.personas')->formBuscadorPersonas('clientes_new');
        $form->handleRequest($request);
        $criteria = null;
        if ($request->getMethod() == 'POST') {
            $data = $form->getData();
            $criteria = array(
                'numeroDocumento' => $data['numeroDocumento'],
                'tipoDocumento' => $data['tipoDocumento'],
            );

            $persona = $em->getRepository('PersonasBundle:Persona')->findOneBy($criteria);
        }
        if (!$persona) {
            $persona = new Persona();
            $persona->setNumeroDocumento($criteria['numeroDocumento']);
            $persona->setTipoDocumento($criteria['tipoDocumento']);
        }

        $entity = new PersonaTipo();

        if (!$persona) {
            $persona = new Persona();
            $persona->setNumeroDocumento($criteria['numeroDocumento']);
            $persona->setTipoDocumento($criteria['tipoDocumento']);
        }
        $entity->setPersona($persona);

        $form = $this->createCreateForm($entity);

        return $this->render('ClientesBundle:Cliente:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Cliente entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ClientesBundle:Cliente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cliente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ClientesBundle:Cliente:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Cliente entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ClientesBundle:Cliente')->find($id);

        $personaTipo = $em->getRepository('PersonasBundle:PersonaTipo')->findOneByCliente($entity);

        if (!$entity) {
            throw $this->createNotFoundException('No se encuentra el cliente');
        }

        $editForm = $this->createEditForm($personaTipo);
//		$deleteForm = $this->createDeleteForm( $id );

        return $this->render('ClientesBundle:Cliente:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
//				'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Cliente entity.
     *
     * @param Cliente $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(PersonaTipo $entity) {
        $form = $this->createForm(new PersonaClienteType(), $entity, array(
            'action' => $this->generateUrl('clientes_update', array('id' => $entity->getCliente()->getId())),
            'method' => 'PUT',
            'attr' => array('class' => 'box-body')
        ));

        $form->add(
                'submit', 'submit', array(
            'label' => 'Actualizar',
            'attr' => array('class' => 'btn btn-primary pull-right'),
                )
        );

        return $form;
    }

    /**
     * Edits an existing Cliente entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ClientesBundle:Cliente')->find($id);

        $personaTipo = $em->getRepository('PersonasBundle:PersonaTipo')->findOneByCliente($entity);

        if (!$personaTipo) {
            throw $this->createNotFoundException('Unable to find Cliente entity.');
        }

//		$deleteForm = $this->createDeleteForm( $id );
        $editForm = $this->createEditForm($personaTipo);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
//			foreach ($entity->getPersonaTipo() as $personaTipo){
//				$personaTipo->setCliente($entity);
//			}

            $em->flush();

            $this->get('session')->getFlashBag()->add(
                    'success', 'Cliente actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('clientes_edit', array('id' => $id)));
        }

        return $this->render('ClientesBundle:Cliente:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
//				'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Cliente entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ClientesBundle:Cliente')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cliente entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('clientes'));
    }

    /**
     * Creates a form to delete a Cliente entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('clientes_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm();
    }

    public function pdfListadoClientesAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ClientesFilterType());

        if ($request->isMethod("post")) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('ClientesBundle:Cliente')->getClientesFilter($data);
            }
        } else {
            $entities = $em->getRepository('ClientesBundle:Cliente')->getClientesFilter();
        }
        $title = 'Reporte de Clientes';

        $html = $this->renderView(
                'ClientesBundle:Cliente:listadoClientes.pdf.twig', array(
            'entities' => $entities,
            'title' => $title,
                )
        );

        $reportesManager = $this->get('manager.reportes');

        return new Response(
                $reportesManager->imprimir($html, "H"), 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $title . '.pdf"'
                )
        );
    }

    /**
     *
     * Listado clientes excel
     *
     * @param Request $request
     *
     * @return \UtilBundle\Services\type
     */
    public function excelListadoClientesAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ClientesFilterType());

        if ($request->isMethod("post")) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('ClientesBundle:Cliente')->getClientesFilter($data);
            }
        } else {
            $entities = $em->getRepository('ClientesBundle:Cliente')->getClientesFilter();
        }
        $filename = 'Listado_clientes';
        $descripcion = str_replace('_', ' ', $filename);

        $exportExcel = $this->get('excel.tool');
        $exportExcel->setTitle($descripcion);
        $exportExcel->setDescripcion($descripcion);

        $response = $exportExcel->buildSheetlistadoClientes($entities);

        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $filename . '');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }

}

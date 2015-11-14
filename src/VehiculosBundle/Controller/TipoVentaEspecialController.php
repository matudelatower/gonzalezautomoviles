<?php

namespace VehiculosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VehiculosBundle\Entity\TipoVentaEspecial;
use VehiculosBundle\Form\TipoVentaEspecialType;

/**
 * TipoVentaEspecial controller.
 *
 */
class TipoVentaEspecialController extends Controller
{

    /**
     * Lists all TipoVentaEspecial entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VehiculosBundle:TipoVentaEspecial')->findAll();

        return $this->render('VehiculosBundle:TipoVentaEspecial:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TipoVentaEspecial entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TipoVentaEspecial();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'TipoVentaEspecial creado correctamente.'
            );

            return $this->redirect($this->generateUrl('tipo_venta_especial_show', array('id' => $entity->getId())));
        }

        return $this->render('VehiculosBundle:TipoVentaEspecial:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TipoVentaEspecial entity.
     *
     * @param TipoVentaEspecial $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TipoVentaEspecial $entity)
    {
        $form = $this->createForm(new TipoVentaEspecialType(), $entity, array(
            'action' => $this->generateUrl('tipo_venta_especial_create'),
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
     * Displays a form to create a new TipoVentaEspecial entity.
     *
     */
    public function newAction()
    {
        $entity = new TipoVentaEspecial();
        $form   = $this->createCreateForm($entity);

        return $this->render('VehiculosBundle:TipoVentaEspecial:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoVentaEspecial entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:TipoVentaEspecial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoVentaEspecial entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:TipoVentaEspecial:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoVentaEspecial entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:TipoVentaEspecial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoVentaEspecial entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:TipoVentaEspecial:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TipoVentaEspecial entity.
    *
    * @param TipoVentaEspecial $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TipoVentaEspecial $entity)
    {
        $form = $this->createForm(new TipoVentaEspecialType(), $entity, array(
            'action' => $this->generateUrl('tipo_venta_especial_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'attr' => array('class' => 'box-body')
        ));

        $form->add(
            'submit',
            'submit',
            array(
                'label' => 'Actualizar',
                'attr' => array('class' => 'btn btn-primary pull-right'),
            )
        );

        return $form;
    }
    /**
     * Edits an existing TipoVentaEspecial entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:TipoVentaEspecial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoVentaEspecial entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'TipoVentaEspecial actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('tipo_venta_especial_edit', array('id' => $id)));
        }

        return $this->render('VehiculosBundle:TipoVentaEspecial:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TipoVentaEspecial entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:TipoVentaEspecial')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TipoVentaEspecial entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tipo_venta_especial'));
    }

    /**
     * Creates a form to delete a TipoVentaEspecial entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipo_venta_especial_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

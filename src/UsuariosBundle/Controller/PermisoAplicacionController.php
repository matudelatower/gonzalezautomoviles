<?php

namespace UsuariosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UsuariosBundle\Entity\PermisoAplicacion;
use UsuariosBundle\Form\PermisoAplicacionType;

/**
 * PermisoAplicacion controller.
 *
 */
class PermisoAplicacionController extends Controller
{

    /**
     * Lists all PermisoAplicacion entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UsuariosBundle:PermisoAplicacion')->findAll();

        return $this->render('UsuariosBundle:PermisoAplicacion:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new PermisoAplicacion entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new PermisoAplicacion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'PermisoAplicacion creado correctamente.'
            );

            return $this->redirect($this->generateUrl('permiso_aplicacion_show', array('id' => $entity->getId())));
        }

        return $this->render('UsuariosBundle:PermisoAplicacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a PermisoAplicacion entity.
     *
     * @param PermisoAplicacion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PermisoAplicacion $entity)
    {
        $form = $this->createForm(new PermisoAplicacionType(), $entity, array(
            'action' => $this->generateUrl('permiso_aplicacion_create'),
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
     * Displays a form to create a new PermisoAplicacion entity.
     *
     */
    public function newAction()
    {
        $entity = new PermisoAplicacion();
        $form   = $this->createCreateForm($entity);

        return $this->render('UsuariosBundle:PermisoAplicacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PermisoAplicacion entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UsuariosBundle:PermisoAplicacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PermisoAplicacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UsuariosBundle:PermisoAplicacion:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PermisoAplicacion entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UsuariosBundle:PermisoAplicacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PermisoAplicacion entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UsuariosBundle:PermisoAplicacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a PermisoAplicacion entity.
    *
    * @param PermisoAplicacion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PermisoAplicacion $entity)
    {
        $form = $this->createForm(new PermisoAplicacionType(), $entity, array(
            'action' => $this->generateUrl('permiso_aplicacion_update', array('id' => $entity->getId())),
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
     * Edits an existing PermisoAplicacion entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UsuariosBundle:PermisoAplicacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PermisoAplicacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'PermisoAplicacion actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('permiso_aplicacion_edit', array('id' => $id)));
        }

        return $this->render('UsuariosBundle:PermisoAplicacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a PermisoAplicacion entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UsuariosBundle:PermisoAplicacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PermisoAplicacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('permiso_aplicacion'));
    }

    /**
     * Creates a form to delete a PermisoAplicacion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('permiso_aplicacion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

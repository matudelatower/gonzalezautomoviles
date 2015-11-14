<?php

namespace VehiculosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VehiculosBundle\Entity\CodigoDanioGm;
use VehiculosBundle\Form\CodigoDanioGmType;

/**
 * CodigoDanioGm controller.
 *
 */
class CodigoDanioGmController extends Controller
{

    /**
     * Lists all CodigoDanioGm entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VehiculosBundle:CodigoDanioGm')->findAll();

        return $this->render('VehiculosBundle:CodigoDanioGm:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new CodigoDanioGm entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new CodigoDanioGm();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'CodigoDanioGm creado correctamente.'
            );

            return $this->redirect($this->generateUrl('codigos_danios_gm_show', array('id' => $entity->getId())));
        }

        return $this->render('VehiculosBundle:CodigoDanioGm:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a CodigoDanioGm entity.
     *
     * @param CodigoDanioGm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CodigoDanioGm $entity)
    {
        $form = $this->createForm(new CodigoDanioGmType(), $entity, array(
            'action' => $this->generateUrl('codigos_danios_gm_create'),
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
     * Displays a form to create a new CodigoDanioGm entity.
     *
     */
    public function newAction()
    {
        $entity = new CodigoDanioGm();
        $form   = $this->createCreateForm($entity);

        return $this->render('VehiculosBundle:CodigoDanioGm:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CodigoDanioGm entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:CodigoDanioGm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CodigoDanioGm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:CodigoDanioGm:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CodigoDanioGm entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:CodigoDanioGm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CodigoDanioGm entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:CodigoDanioGm:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a CodigoDanioGm entity.
    *
    * @param CodigoDanioGm $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CodigoDanioGm $entity)
    {
        $form = $this->createForm(new CodigoDanioGmType(), $entity, array(
            'action' => $this->generateUrl('codigos_danios_gm_update', array('id' => $entity->getId())),
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
     * Edits an existing CodigoDanioGm entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:CodigoDanioGm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CodigoDanioGm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'CodigoDanioGm actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('codigos_danios_gm_edit', array('id' => $id)));
        }

        return $this->render('VehiculosBundle:CodigoDanioGm:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a CodigoDanioGm entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:CodigoDanioGm')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CodigoDanioGm entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('codigos_danios_gm'));
    }

    /**
     * Creates a form to delete a CodigoDanioGm entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('codigos_danios_gm_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

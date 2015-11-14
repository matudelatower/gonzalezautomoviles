<?php

namespace VehiculosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VehiculosBundle\Entity\GravedadDanioGm;
use VehiculosBundle\Form\GravedadDanioGmType;

/**
 * GravedadDanioGm controller.
 *
 */
class GravedadDanioGmController extends Controller
{

    /**
     * Lists all GravedadDanioGm entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VehiculosBundle:GravedadDanioGm')->findAll();

        return $this->render('VehiculosBundle:GravedadDanioGm:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new GravedadDanioGm entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new GravedadDanioGm();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'GravedadDanioGm creado correctamente.'
            );

            return $this->redirect($this->generateUrl('gravedad_danios_gm_show', array('id' => $entity->getId())));
        }

        return $this->render('VehiculosBundle:GravedadDanioGm:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a GravedadDanioGm entity.
     *
     * @param GravedadDanioGm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(GravedadDanioGm $entity)
    {
        $form = $this->createForm(new GravedadDanioGmType(), $entity, array(
            'action' => $this->generateUrl('gravedad_danios_gm_create'),
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
     * Displays a form to create a new GravedadDanioGm entity.
     *
     */
    public function newAction()
    {
        $entity = new GravedadDanioGm();
        $form   = $this->createCreateForm($entity);

        return $this->render('VehiculosBundle:GravedadDanioGm:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a GravedadDanioGm entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:GravedadDanioGm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GravedadDanioGm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:GravedadDanioGm:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing GravedadDanioGm entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:GravedadDanioGm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GravedadDanioGm entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:GravedadDanioGm:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a GravedadDanioGm entity.
    *
    * @param GravedadDanioGm $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(GravedadDanioGm $entity)
    {
        $form = $this->createForm(new GravedadDanioGmType(), $entity, array(
            'action' => $this->generateUrl('gravedad_danios_gm_update', array('id' => $entity->getId())),
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
     * Edits an existing GravedadDanioGm entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:GravedadDanioGm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GravedadDanioGm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'GravedadDanioGm actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('gravedad_danios_gm_edit', array('id' => $id)));
        }

        return $this->render('VehiculosBundle:GravedadDanioGm:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a GravedadDanioGm entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:GravedadDanioGm')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find GravedadDanioGm entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('gravedad_danios_gm'));
    }

    /**
     * Creates a form to delete a GravedadDanioGm entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gravedad_danios_gm_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

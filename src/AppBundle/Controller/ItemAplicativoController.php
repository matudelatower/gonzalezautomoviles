<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\ItemAplicativo;
use AppBundle\Form\ItemAplicativoType;

/**
 * ItemAplicativo controller.
 *
 */
class ItemAplicativoController extends Controller
{

    /**
     * Lists all ItemAplicativo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:ItemAplicativo')->findAll();

        return $this->render('AppBundle:ItemAplicativo:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ItemAplicativo entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ItemAplicativo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'ItemAplicativo creado correctamente.'
            );

            return $this->redirect($this->generateUrl('item_aplicativo_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:ItemAplicativo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ItemAplicativo entity.
     *
     * @param ItemAplicativo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ItemAplicativo $entity)
    {
        $form = $this->createForm(new ItemAplicativoType($this->get('manager.app')), $entity, array(
            'action' => $this->generateUrl('item_aplicativo_create'),
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
     * Displays a form to create a new ItemAplicativo entity.
     *
     */
    public function newAction()
    {
        $entity = new ItemAplicativo();
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:ItemAplicativo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ItemAplicativo entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ItemAplicativo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ItemAplicativo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:ItemAplicativo:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ItemAplicativo entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ItemAplicativo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ItemAplicativo entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:ItemAplicativo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ItemAplicativo entity.
    *
    * @param ItemAplicativo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ItemAplicativo $entity)
    {
        $form = $this->createForm(new ItemAplicativoType($this->get('manager.app')), $entity, array(
            'action' => $this->generateUrl('item_aplicativo_update', array('id' => $entity->getId())),
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
     * Edits an existing ItemAplicativo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ItemAplicativo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ItemAplicativo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'ItemAplicativo actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('item_aplicativo_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:ItemAplicativo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ItemAplicativo entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:ItemAplicativo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ItemAplicativo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('item_aplicativo'));
    }

    /**
     * Creates a form to delete a ItemAplicativo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('item_aplicativo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

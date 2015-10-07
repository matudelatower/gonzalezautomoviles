<?php

namespace VehiculosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VehiculosBundle\Entity\TipoCompra;
use VehiculosBundle\Form\TipoCompraType;

/**
 * TipoCompra controller.
 *
 */
class TipoCompraController extends Controller
{

    /**
     * Lists all TipoCompra entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VehiculosBundle:TipoCompra')->findAll();

        return $this->render('VehiculosBundle:TipoCompra:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TipoCompra entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TipoCompra();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tipo_compra_show', array('id' => $entity->getId())));
        }

        return $this->render('VehiculosBundle:TipoCompra:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TipoCompra entity.
     *
     * @param TipoCompra $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TipoCompra $entity)
    {
        $form = $this->createForm(new TipoCompraType(), $entity, array(
            'action' => $this->generateUrl('tipo_compra_create'),
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
     * Displays a form to create a new TipoCompra entity.
     *
     */
    public function newAction()
    {
        $entity = new TipoCompra();
        $form   = $this->createCreateForm($entity);

        return $this->render('VehiculosBundle:TipoCompra:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoCompra entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:TipoCompra')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoCompra entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:TipoCompra:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoCompra entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:TipoCompra')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoCompra entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VehiculosBundle:TipoCompra:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TipoCompra entity.
    *
    * @param TipoCompra $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TipoCompra $entity)
    {
        $form = $this->createForm(new TipoCompraType(), $entity, array(
            'action' => $this->generateUrl('tipo_compra_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TipoCompra entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:TipoCompra')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoCompra entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tipo_compra_edit', array('id' => $id)));
        }

        return $this->render('VehiculosBundle:TipoCompra:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TipoCompra entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:TipoCompra')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TipoCompra entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tipo_compra'));
    }

    /**
     * Creates a form to delete a TipoCompra entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipo_compra_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

<?php

namespace CuestionariosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CuestionariosBundle\Entity\TipoPregunta;
use CuestionariosBundle\Form\TipoPreguntaType;

/**
 * TipoPregunta controller.
 *
 */
class TipoPreguntaController extends Controller
{

    /**
     * Lists all TipoPregunta entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CuestionariosBundle:TipoPregunta')->findAll();

        return $this->render('CuestionariosBundle:TipoPregunta:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TipoPregunta entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TipoPregunta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'TipoPregunta creado correctamente.'
            );

            return $this->redirect($this->generateUrl('tipo_pregunta_show', array('id' => $entity->getId())));
        }

        return $this->render('CuestionariosBundle:TipoPregunta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TipoPregunta entity.
     *
     * @param TipoPregunta $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TipoPregunta $entity)
    {
        $form = $this->createForm(new TipoPreguntaType(), $entity, array(
            'action' => $this->generateUrl('tipo_pregunta_create'),
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
     * Displays a form to create a new TipoPregunta entity.
     *
     */
    public function newAction()
    {
        $entity = new TipoPregunta();
        $form   = $this->createCreateForm($entity);

        return $this->render('CuestionariosBundle:TipoPregunta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoPregunta entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CuestionariosBundle:TipoPregunta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoPregunta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CuestionariosBundle:TipoPregunta:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoPregunta entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CuestionariosBundle:TipoPregunta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoPregunta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CuestionariosBundle:TipoPregunta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TipoPregunta entity.
    *
    * @param TipoPregunta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TipoPregunta $entity)
    {
        $form = $this->createForm(new TipoPreguntaType(), $entity, array(
            'action' => $this->generateUrl('tipo_pregunta_update', array('id' => $entity->getId())),
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
     * Edits an existing TipoPregunta entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CuestionariosBundle:TipoPregunta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoPregunta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'TipoPregunta actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('tipo_pregunta_edit', array('id' => $id)));
        }

        return $this->render('CuestionariosBundle:TipoPregunta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TipoPregunta entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CuestionariosBundle:TipoPregunta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TipoPregunta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tipo_pregunta'));
    }

    /**
     * Creates a form to delete a TipoPregunta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipo_pregunta_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

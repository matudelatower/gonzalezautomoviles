<?php

namespace CuestionariosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CuestionariosBundle\Entity\CuestionarioPregunta;
use CuestionariosBundle\Form\CuestionarioPreguntaType;

/**
 * CuestionarioPregunta controller.
 *
 */
class CuestionarioPreguntaController extends Controller
{

    /**
     * Lists all CuestionarioPregunta entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CuestionariosBundle:CuestionarioPregunta')->findAll();

        return $this->render('CuestionariosBundle:CuestionarioPregunta:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new CuestionarioPregunta entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new CuestionarioPregunta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'CuestionarioPregunta creado correctamente.'
            );

            return $this->redirect($this->generateUrl('preguntas_show', array('id' => $entity->getId())));
        }

        return $this->render('CuestionariosBundle:CuestionarioPregunta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a CuestionarioPregunta entity.
     *
     * @param CuestionarioPregunta $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CuestionarioPregunta $entity)
    {
        $form = $this->createForm(new CuestionarioPreguntaType(), $entity, array(
            'action' => $this->generateUrl('preguntas_create'),
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
     * Displays a form to create a new CuestionarioPregunta entity.
     *
     */
    public function newAction()
    {
        $entity = new CuestionarioPregunta();
        $form   = $this->createCreateForm($entity);

        return $this->render('CuestionariosBundle:CuestionarioPregunta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CuestionarioPregunta entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CuestionariosBundle:CuestionarioPregunta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CuestionarioPregunta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CuestionariosBundle:CuestionarioPregunta:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CuestionarioPregunta entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CuestionariosBundle:CuestionarioPregunta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CuestionarioPregunta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CuestionariosBundle:CuestionarioPregunta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a CuestionarioPregunta entity.
    *
    * @param CuestionarioPregunta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CuestionarioPregunta $entity)
    {
        $form = $this->createForm(new CuestionarioPreguntaType(), $entity, array(
            'action' => $this->generateUrl('preguntas_update', array('id' => $entity->getId())),
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
     * Edits an existing CuestionarioPregunta entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CuestionariosBundle:CuestionarioPregunta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CuestionarioPregunta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success', 'CuestionarioPregunta actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('preguntas_edit', array('id' => $id)));
        }

        return $this->render('CuestionariosBundle:CuestionarioPregunta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a CuestionarioPregunta entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CuestionariosBundle:CuestionarioPregunta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CuestionarioPregunta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('preguntas'));
    }

    /**
     * Creates a form to delete a CuestionarioPregunta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('preguntas_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

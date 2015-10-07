<?php

namespace CuestionariosBundle\Controller;

use CuestionariosBundle\Form\AddPreguntasCategoriasType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CuestionariosBundle\Entity\CuestionarioCategoria;
use CuestionariosBundle\Form\CuestionarioCategoriaType;

/**
 * CuestionarioCategoria controller.
 *
 */
class CuestionarioCategoriaController extends Controller
{

    /**
     * Lists all CuestionarioCategoria entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CuestionariosBundle:CuestionarioCategoria')->findAll();

        return $this->render(
            'CuestionariosBundle:CuestionarioCategoria:index.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }

    /**
     * Creates a new CuestionarioCategoria entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new CuestionarioCategoria();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Categoria creada correctamente.'
            );

            return $this->redirect($this->generateUrl('categorias_cuestionario_show', array('id' => $entity->getId())));
        }

        return $this->render(
            'CuestionariosBundle:CuestionarioCategoria:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a CuestionarioCategoria entity.
     *
     * @param CuestionarioCategoria $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CuestionarioCategoria $entity)
    {
        $form = $this->createForm(
            new CuestionarioCategoriaType(),
            $entity,
            array(
                'action' => $this->generateUrl('categorias_cuestionario_create'),
                'method' => 'POST',
                'attr' => array('class' => 'box-body')
            )
        );

        $form->add(
            'submit',
            'submit',
            array(
                'label' => 'Crear',
                'attr' => array('class' => 'btn btn-primary pull-right')
            )
        );

        return $form;
    }

    /**
     * Displays a form to create a new CuestionarioCategoria entity.
     *
     */
    public function newAction()
    {
        $entity = new CuestionarioCategoria();
        $form = $this->createCreateForm($entity);

        return $this->render(
            'CuestionariosBundle:CuestionarioCategoria:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a CuestionarioCategoria entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CuestionariosBundle:CuestionarioCategoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CuestionarioCategoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'CuestionariosBundle:CuestionarioCategoria:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing CuestionarioCategoria entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CuestionariosBundle:CuestionarioCategoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CuestionarioCategoria entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'CuestionariosBundle:CuestionarioCategoria:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a CuestionarioCategoria entity.
     *
     * @param CuestionarioCategoria $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(CuestionarioCategoria $entity)
    {
        $form = $this->createForm(
            new CuestionarioCategoriaType(),
            $entity,
            array(
                'action' => $this->generateUrl('categorias_cuestionario_update', array('id' => $entity->getId())),
                'method' => 'PUT',
                'attr' => array('class' => 'box-body')
            )
        );

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
     * Edits an existing CuestionarioCategoria entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CuestionariosBundle:CuestionarioCategoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CuestionarioCategoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'CuestionarioCategoria actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('categorias_cuestionario_edit', array('id' => $id)));
        }

        return $this->render(
            'CuestionariosBundle:CuestionarioCategoria:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a CuestionarioCategoria entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CuestionariosBundle:CuestionarioCategoria')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CuestionarioCategoria entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('categorias_cuestionario'));
    }

    /**
     * Creates a form to delete a CuestionarioCategoria entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categorias_cuestionario_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }


    public function agregarPreguntasCategoriasAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CuestionariosBundle:CuestionarioCategoria')->find($id);

        $form = $this->createForm(
            new AddPreguntasCategoriasType(),
            $entity,
            array(
                'action' => $this->generateUrl('agregar_preguntas_categorias_crear', array('id' => $id)),
                'method' => 'POST',
                'attr' => array('class' => 'box-body')
            )
        );

        $form->add(
            'submit',
            'submit',
            array(
                'label' => 'Crear',
                'attr' => array('class' => 'btn btn-primary pull-right')
            )
        );

        return $this->render(
            'CuestionariosBundle:CuestionarioCategoria:agregarPreguntasCategorias.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    public function agregarPreguntasCategoriasCrearAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CuestionariosBundle:CuestionarioCategoria')->find($id);

        $preguntasOriginales = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($entity->getPreguntas() as $pregunta) {
            $preguntasOriginales->add($pregunta);
        }

        $form = $this->createForm(
            new AddPreguntasCategoriasType(),
            $entity,
            array(
                'action' => $this->generateUrl(
                    'agregar_preguntas_categorias_actualizar',
                    array('id' => $entity->getId())
                ),
                'method' => 'POST',
                'attr' => array('class' => 'box-body')
            )
        );

        $form->add(
            'submit',
            'submit',
            array(
                'label' => 'Actualizar',
                'attr' => array('class' => 'btn btn-primary pull-right'),
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
//            seteo la categoria a las preguntas
            foreach ($entity->getPreguntas() as $pregunta) {
                $pregunta->setCategoria($entity);
            }

            // remove the relationship between the tag and the Task
            foreach ($preguntasOriginales as $pregunta) {
                if (false === $entity->getPreguntas()->contains($pregunta)) {
                    // remove the Task from the Tag
                    $entity->getPreguntas()->removeElement($pregunta);

                    // if it was a many-to-one relationship, remove the relationship like this
                    // $tag->setTask(null);

                    $em->persist($pregunta);

                    // if you wanted to delete the Tag entirely, you can also do that
                    // $em->remove($tag);
                }
            }
            $em = $this->getDoctrine()->getManager();
//            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Preguntas agregadas correctamente correctamente.'
            );

            return $this->redirect($this->generateUrl('agregar_preguntas_categorias', array('id' => $entity->getId())));
        }

        return $this->render(
            'CuestionariosBundle:CuestionarioCategoria:agregarPreguntasCategorias.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }
}

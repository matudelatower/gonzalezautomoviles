<?php

namespace CuestionariosBundle\Controller;

use CuestionariosBundle\Form\CheckListParameterType;
use CuestionariosBundle\Form\Model\CheckListParameter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CuestionariosBundle\Entity\Cuestionario;
use CuestionariosBundle\Form\CuestionarioType;

/**
 * Cuestionario controller.
 *
 */
class CuestionarioController extends Controller
{

    /**
     * Lists all Cuestionario entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CuestionariosBundle:Cuestionario')->findAll();

        return $this->render(
            'CuestionariosBundle:Cuestionario:index.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }

    /**
     * Creates a new Cuestionario entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Cuestionario();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Cuestionario creado correctamente.'
            );

            return $this->redirect($this->generateUrl('cuestionarios_show', array('id' => $entity->getId())));
        }

        return $this->render(
            'CuestionariosBundle:Cuestionario:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a Cuestionario entity.
     *
     * @param Cuestionario $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Cuestionario $entity)
    {
        $form = $this->createForm(
            new CuestionarioType(),
            $entity,
            array(
                'action' => $this->generateUrl('cuestionarios_create'),
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
     * Displays a form to create a new Cuestionario entity.
     *
     */
    public function newAction()
    {
        $entity = new Cuestionario();
        $form = $this->createCreateForm($entity);

        return $this->render(
            'CuestionariosBundle:Cuestionario:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Cuestionario entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CuestionariosBundle:Cuestionario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cuestionario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'CuestionariosBundle:Cuestionario:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing Cuestionario entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CuestionariosBundle:Cuestionario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cuestionario entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'CuestionariosBundle:Cuestionario:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a Cuestionario entity.
     *
     * @param Cuestionario $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Cuestionario $entity)
    {
        $form = $this->createForm(
            new CuestionarioType(),
            $entity,
            array(
                'action' => $this->generateUrl('cuestionarios_update', array('id' => $entity->getId())),
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
     * Edits an existing Cuestionario entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CuestionariosBundle:Cuestionario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cuestionario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Cuestionario actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('cuestionarios_edit', array('id' => $id)));
        }

        return $this->render(
            'CuestionariosBundle:Cuestionario:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a Cuestionario entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CuestionariosBundle:Cuestionario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cuestionario entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cuestionarios'));
    }

    /**
     * Creates a form to delete a Cuestionario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cuestionarios_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    public function getCamposPorCategoriaAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $categoria = $em->getRepository('CuestionariosBundle:CuestionarioCategoria')->find($id);

        $campos = $em->getRepository('CuestionariosBundle:CuestionarioPregunta')->findByCategoria($categoria);

        if (!$campos) {
            throw $this->createNotFoundException('No se encuentra el Campo');
        }

        $checkListParameter = new CheckListParameter($campos, $em);
        $form = $this->createForm(new CheckListParameterType(), $checkListParameter);


        return $this->render(
            'CuestionariosBundle:Cuestionario:campos.html.twig',
            array(
                'campos' => $campos,
                'form' => $form->createView(),
            )
        );

    }

    public function verChecklistAction($id)
    {
        $em = $this->getDoctrine()->getManager();


        $cuestionario = $em->getRepository('CuestionariosBundle:Cuestionario')->find($id);


        $categorias = $em->getRepository('CuestionariosBundle:CuestionarioCategoria')->getCategoriasConCampos(
            $cuestionario
        );


        if (!$categorias) {
            throw $this->createNotFoundException('No se encuentra el Campo');
        }

        return $this->render(
            'CuestionariosBundle:Cuestionario:formChecklist.html.twig',
            array(
                'categorias' => $categorias,
                'cuestionario' => $cuestionario,
            )
        );


    }

    public function crearResultadoRespuestaAction(Request $request, $cuestionarioId)
    {

        return $this->redirectToRoute('categorias_cuestionario');
    }

    public function getCamposPorCategoriaEditAction($id, $vehiculoId)
    {
        $em = $this->getDoctrine()->getManager();

        $categoria = $em->getRepository('CuestionariosBundle:CuestionarioCategoria')->find($id);

        $campos = $em->getRepository('CuestionariosBundle:CuestionarioPregunta')->findByCategoria($categoria);

        $vehiculo = $em->getRepository('VehiculosBundle:Vehiculo')->find($vehiculoId);

        if (!$campos) {
            throw $this->createNotFoundException('No se encuentra el Campo');
        }

        $arrayParam = array('vehiculo'=>$vehiculo);

        $checkListParameter = new CheckListParameter($campos, $em, true, $arrayParam);
        $form = $this->createForm(new CheckListParameterType(), $checkListParameter);


        return $this->render(
            'CuestionariosBundle:Cuestionario:campos.html.twig',
            array(
                'campos' => $campos,
                'form' => $form->createView(),
            )
        );

    }
}

<?php

namespace VehiculosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VehiculosBundle\Entity\EstadoVehiculo;
use VehiculosBundle\Entity\Vehiculo;
use VehiculosBundle\Form\AltaVehiculoType;
use VehiculosBundle\Form\CheckListPreEntregaType;
use VehiculosBundle\Form\EditarVehiculoType;
use VehiculosBundle\Form\VehiculoType;
use VehiculosBundle\Form\VehiculoFilterType;

/**
 * Vehiculo controller.
 *
 */
class VehiculoController extends Controller {

    /**
     * Lists all Vehiculo entities.
     *
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VehiculoFilterType());

        if ($request->isMethod("post")) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEstado(false, $data);
            }
        } else {
            $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEstado(false);
        }
        $formMovimientoDeposito = $this->createForm(new \VehiculosBundle\Form\MovimientoDepositoType());
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );
        return $this->render(
                        'VehiculosBundle:Vehiculo:index.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
                    'form_movimiento_deposito' => $formMovimientoDeposito->createView()
                        )
        );
    }

    /**
     * listado de vehiculos que se encuentren pendientes por recibir.
     *
     */
    public function vehiculosPendientesIndexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $estado = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findBySlug('pendiente-por-recibir');
        $form = $this->createForm(new VehiculoFilterType());

        if ($request->isMethod("post")) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEstado($estado, $data);
            }
        } else {
            $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEstado($estado);
        }

        $formMovimientoDeposito = $this->createForm(new \VehiculosBundle\Form\MovimientoDepositoType());

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );
        return $this->render(
                        'VehiculosBundle:Vehiculo:pendientesIndex.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
                    'form_movimiento_deposito' => $formMovimientoDeposito->createView()
                        )
        );
    }

    /**
     * listado de vehiculos que se recibieron ya sea conforme o con daños.
     *
     */
    public function vehiculosRecibidosIndexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $estadoId1 = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findOneBySlug('recibido-con-problemas');
        $estadoId2 = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findOneBySlug('recibido-conforme');
        $estados = array($estadoId1, $estadoId2);

        if ($request->isMethod("post")) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEstado($estados, $data);
            }
        } else {
            $entities = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosEstado($estados);
        }

        $formMovimientoDeposito = $this->createForm(new \VehiculosBundle\Form\MovimientoDepositoType());
        $form = $this->createForm(new VehiculoFilterType());

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );
        return $this->render(
                        'VehiculosBundle:Vehiculo:recibidosIndex.html.twig', array(
                    'entities' => $entities,
                    'form' => $form->createView(),
                    'form_movimiento_deposito' => $formMovimientoDeposito->createView()
                        )
        );
    }

    /**
     * Creates a new Vehiculo entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Vehiculo();
        $form = $this->createCreateForm($entity, new AltaVehiculoType());
        $form->handleRequest($request);

        if ($form->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $tipoEstadoVehiculo = $em->getRepository('VehiculosBundle:TipoEstadoVehiculo')->findOneBySlug(
                    'pendiente-por-recibir'
            );

            $estadoVehiculo = new EstadoVehiculo();
            $estadoVehiculo->setTipoEstadoVehiculo($tipoEstadoVehiculo);
            $estadoVehiculo->setVehiculo($entity);
            $estadoVehiculo->setActual('true');

            $entity->addEstadoVehiculo($estadoVehiculo);

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                    'success', 'Vehiculo creado correctamente.'
            );

            return $this->redirect($this->generateUrl('vehiculos_show', array('id' => $entity->getId())));
        }

        return $this->render(
                        'VehiculosBundle:Vehiculo:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                        )
        );
    }

    /**
     * Creates a form to create a Vehiculo entity.
     *
     * @param Vehiculo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Vehiculo $entity, $type = null, $route = null, $submitLabel = 'Crear') {

        if (!$type) {
            $type = new VehiculoType();
        }

        if (!$route) {
            $route = $this->generateUrl('vehiculos_create');
        }

        $form = $this->createForm(
                $type, $entity, array(
            'action' => $route,
            'method' => 'POST',
            'attr' => array('class' => 'box-body')
                )
        );

        $form->add(
                'submit', 'submit', array(
            'label' => $submitLabel,
            'attr' => array('class' => 'btn btn-primary pull-right')
                )
        );

        return $form;
    }

    /**
     * Displays a form to create a new Vehiculo entity.
     *
     */
    public function newAction() {
        $entity = new Vehiculo();
        $form = $this->createCreateForm($entity);

        return $this->render(
                        'VehiculosBundle:Vehiculo:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                        )
        );
    }

    /**
     * Finds and displays a Vehiculo entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:Vehiculo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vehiculo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

		return $this->render(
			'VehiculosBundle:Vehiculo:show.html.twig',
			array(
				'entity'      => $entity,
				'delete_form' => $deleteForm->createView(),
			)
		);
	}

	/**
	 * Finds and displays a Vehiculo Recibido entity.
	 *
	 */
	public function showRecibidosAction( $id ) {
		$em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:Vehiculo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vehiculo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
                        'VehiculosBundle:Vehiculo:showRecibidos.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
                        )
        );
    }

    /**
     * Displays a form to edit an existing Vehiculo entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:Vehiculo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vehiculo entity.');
        }

        $editForm = $this->createEditForm($entity);

//		$deleteForm = $this->createDeleteForm( $id );

        return $this->render(
                        'VehiculosBundle:Vehiculo:editarVehiculoPendiente.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
//				'delete_form' => $deleteForm->createView(),
                        )
        );
    }

    /**
     * Creates a form to edit a Vehiculo entity.
     *
     * @param Vehiculo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Vehiculo $entity) {
        $form = $this->createForm(
                new AltaVehiculoType(), $entity, array(
            'action' => $this->generateUrl('vehiculos_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'attr' => array('class' => 'box-body')
                )
        );

        $form->add(
                'submit', 'submit', array(
            'label' => 'Actualizar',
            'attr' => array('class' => 'btn btn-primary pull-right'),
                )
        );

        return $form;
    }

    /**
     * Edits an existing Vehiculo entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VehiculosBundle:Vehiculo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vehiculo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                    'success', 'Vehiculo actualizado correctamente.'
            );

            return $this->redirect($this->generateUrl('vehiculos_edit', array('id' => $id)));
        }

        return $this->render(
                        'VehiculosBundle:Vehiculo:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                        )
        );
    }

    /**
     * Deletes a Vehiculo entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VehiculosBundle:Vehiculo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Vehiculo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('vehiculos'));
    }

    /**
     * Creates a form to delete a Vehiculo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('vehiculos_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm();
    }

    public function altaAction() {
        $entity = new Vehiculo();
        $form = $this->createCreateForm($entity, new AltaVehiculoType());

        return $this->render(
                        'VehiculosBundle:Vehiculo:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                        )
        );
    }

    public function actualizarVehiculoRemitoAction(Request $request, $vehiculoId) {
        $em = $this->getDoctrine()->getManager();
        $vehiculo = $em->getRepository('VehiculosBundle:Vehiculo')->find($vehiculoId);
        $ruta = $this->generateUrl('vehiculos_actualizar_remito', array('vehiculoId' => $vehiculoId));


        $form = $this->createCreateForm($vehiculo, new EditarVehiculoType(), $ruta, 'Actualizar');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $vehiculosManager = $this->get('manager.vehiculos');

                $tipoEstadoDanioGm = $em->getRepository('VehiculosBundle:TipoEstadoDanioGm')->findOneBySlug(
                        'tipo-danio-gm-registrado'
                );

                if ($vehiculosManager->guardarVehiculo($vehiculo, $tipoEstadoDanioGm)) {

                    $this->get('session')->getFlashBag()->add(
                            'success', 'Datos del Vehiculo actualizados correctamente.'
                    );
                }
            }
        }

        return $this->render('VehiculosBundle:Vehiculo:edit.html.twig', array(
                    'edit_form' => $form->createView(),
        ));
    }

    public function editarVehiculoRecibidoAction(Request $request, $vehiculoId) {
        $em = $this->getDoctrine()->getManager();
        $vehiculo = $em->getRepository('VehiculosBundle:Vehiculo')->find($vehiculoId);
        $ruta = $this->generateUrl('vehiculos_editar_recibido', array('vehiculoId' => $vehiculoId));


        $form = $this->createCreateForm($vehiculo, new EditarVehiculoType(), $ruta, 'Actualizar');


        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

				$vehiculosManager = $this->get( 'manager.vehiculos' );

				if ( $vehiculosManager->guardarVehiculo( $vehiculo ) ) {

                    $this->get('session')->getFlashBag()->add(
                            'success', 'Datos del Vehiculo actualizados correctamente.'
                    );
                }
            }
        }

        return $this->render('VehiculosBundle:Vehiculo:editarVehiculoRecibido.html.twig', array(
                    'edit_form' => $form->createView(),
        ));
    }

	public function checklistPreEntregaAction( Request $request, $vehiculoId ) {
		$em = $this->getDoctrine()->getManager();

		$vehiculo = $em->getRepository( 'VehiculosBundle:Vehiculo' )->find( $vehiculoId );

		$cuestionario = $em->getRepository( 'CuestionariosBundle:Cuestionario' )->find( 1 );


		$categorias = $em->getRepository( 'CuestionariosBundle:CuestionarioCategoria' )->getCategoriasConCampos(
			$cuestionario
		);

		$formDaniosInternos = $this->createForm( new CheckListPreEntregaType(), $vehiculo );


		if ( ! $categorias ) {
			throw $this->createNotFoundException( 'No se encuentra el Campo' );
		}

		return $this->render(
			'VehiculosBundle:Vehiculo:checkListPreEntrega.html.twig',
			array(
				'categorias'       => $categorias,
				'cuestionario'     => $cuestionario,
				'formDanioInterno' => $formDaniosInternos->createView(),
			)
		);
	}

}

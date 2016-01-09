<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 9/1/16
 * Time: 10:12 AM
 */

namespace VehiculosBundle\Form\EventListener;



use Doctrine\ORM\EntityRepository;
use FlowerMaster\LocationBundle\Entity\Country;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use VehiculosBundle\Entity\CategoriaDanioInterno;


class AddTipoDanioInternoFieldSuscriber implements EventSubscriberInterface {

	private $factory;

	public function __construct(FormFactoryInterface $factory) {
		$this->factory = $factory;
	}

	public static function getSubscribedEvents() {
		return array(
			FormEvents::PRE_SET_DATA => 'preSetData',
			FormEvents::PRE_BIND => 'preBind'
		);
	}

	private function addTipoDanioForm($form, $categoria, $tipoDanioInterno) {

		$form->add($this->factory->createNamed('tipoDanioInterno', 'entity', $tipoDanioInterno, array(
			'class' => 'VehiculosBundle:TipoDanioInterno',
			'auto_initialize' => false,
			'empty_value' => 'Seleccionar',
			'attr' => array(
				'class' => 'tipo_danio_interno_select',
			),
			'query_builder' => function (EntityRepository $repository) use ($categoria) {
				$qb = $repository->createQueryBuilder('tdi')
				                 ->innerJoin('tdi.categoriaDanioInterno', 'cat');
				if ($categoria instanceof CategoriaDanioInterno) {
					$qb->where('tdi.categoriaDanioInterno = :categoria')
					   ->setParameter('categoria', $categoria);
				} elseif (is_numeric($categoria)) {
					$qb->where('cat.id = :categoria')
					   ->setParameter('categoria', $categoria->getId());
				} else {
					$qb->where('cat.nombre = :categoria')
					   ->setParameter('categoria', null);
				}

				return $qb;
			}
		)));
	}

	public function preSetData(FormEvent $event) {
		$data = $event->getData();
		$form = $event->getForm();

		if (null === $data) {
			$this->addTipoDanioForm($form, null, null);
			return;
		}

		$accessor = PropertyAccess::getPropertyAccessor();
		$danioInterno = $accessor->getValue($data, 'tipoDanioInterno');
		$categoria = ($danioInterno) ? $danioInterno->getCategoria() : null;

		$this->addTipoDanioForm($form, $categoria, $danioInterno);
	}

	public function preBind(FormEvent $event) {
		$data = $event->getData();
		$form = $event->getForm();

		if (null === $data) {
			return;
		}

		$danioInterno = array_key_exists('tipoDanioInterno', $data) ? $data['tipoDanioInterno'] : null;
		$categoria = array_key_exists('categoriaDanioInterno', $data) ? $data['categoriaDanioInterno'] : null;
		$this->addTipoDanioForm($form, $categoria, $danioInterno);
	}

}
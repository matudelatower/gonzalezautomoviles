<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 6/4/17
 * Time: 16:53
 */

namespace CRMBundle\Repository;


use Doctrine\ORM\EntityRepository;

class EncuestaResultadoCabeceraRepository extends EntityRepository
{

    public function findByEncuestaFiltrada($encuesta, $filtros = null)
    {

        $qb = $this->createQueryBuilder('erc');

        $qb->join('erc.encuesta', 'e')
            ->where("e = :encuesta")
            ->setParameter('encuesta', $encuesta)
            ->andWhere($qb->expr()->andx(
                $qb->expr()->isNull('erc.cancelada')
            ));

        if ($filtros) {
            if ($filtros['vendedor']) {
                $qb->join('erc.vehiculo', 'v')
                    ->andWhere('v.vendedor = :vendedor')
                    ->setParameter('vendedor', $filtros['vendedor']);
            }
            if ($filtros['vin']) {
                $qb->join('erc.vehiculo', 'v')
                    ->andWhere('v.vin like :vin')
                    ->setParameter('vin', "%".$filtros['vin']."%");
            }
            if ($filtros['rango']) {
                $qb
                    ->andWhere('erc.fechaCreacion between :fecha_desde and :fecha_hasta')
                    ->setParameter('fecha_desde', $filtros['fechaDesde'])
                    ->setParameter('fecha_hasta', $filtros['fechaHasta']);
            }
            if ($filtros['cliente']) {
                $qb->join('erc.vehiculo', 'v')
                    ->andWhere('v.cliente = :cliente')
                    ->setParameter('cliente', $filtros['cliente']);
            }

            if ($filtros['tipoVenta']) {
                $qb->join('erc.vehiculo', 'v')
                    ->andWhere('v.tipoVentaEspecial = :tipoVentaEspecial')
                    ->setParameter('tipoVentaEspecial', $filtros['tipoVenta']);
            }

        }

        return $qb->getQuery()->getResult();

    }

    public function findByEncuestaNoCancelada($encuesta, $filtros = null)
    {

        $qb = $this->createQueryBuilder('erc');


        $qb->join('erc.encuesta', 'e')
            ->where("e = :encuesta")
            ->setParameter('encuesta', $encuesta)
            ->andWhere($qb->expr()->andx(
                $qb->expr()->isNull('erc.cancelada')
            ));

        return $qb->getQuery()->getResult();

    }
}
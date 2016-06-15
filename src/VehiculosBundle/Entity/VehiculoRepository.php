<?php

namespace VehiculosBundle\Entity;

/**
 * VehiculoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VehiculoRepository extends \Doctrine\ORM\EntityRepository {

    public function getVehiculosEstado($estado, $filters = null, $order = false) {
        $ids = array();
        if ($estado) {
            foreach ($estado as $item) {
                $ids[] = $item->getId();
                if ($item->getSlug() == 'recibido') {
                    $recibido = true;
                } elseif ($item->getSlug() == 'transito') {
                    $transito = true;
                }
            }
            $idsEstado = implode(',', $ids);
            $where = "tipo_estado_vehiculo.id in ($idsEstado)";
        } else {
            $where = "0=0";
        }


        $db = $this->getEntityManager()->getConnection();


        if ($filters['vin']) {

            $where.=" AND upper(v.vin) LIKE upper('%" . $filters['vin'] . "%')";
        }
        if ($filters['colorVehiculo']) {
            $where.=" AND v.color_vehiculo_id=" . $filters['colorVehiculo']->getId();
        }
        if ($filters['tipoVentaEspecial']) {
            $where.=" AND v.tipo_venta_especial_id=" . $filters['tipoVentaEspecial']->getId();
        }
        if ($filters['deposito']) {
            $where.=" AND d.id=" . $filters['deposito']->getId();
        }
        if ($filters['modelo']) {
            $where.=" AND nm.id=" . $filters['modelo']->getId();
        }
        if ($filters['anio']) {
            $where.=" AND cm.anio=" . $filters['anio'];
        }
        if ($filters['cliente']) {
            $where.=" AND v.cliente_id=" . $filters['cliente']->getId();
        }
        if ($filters['estadoVehiculo']) {
            $where.=" AND estados_vehiculos.tipo_estado_vehiculo_id=" . $filters['estadoVehiculo']->getId();
        }
        if ($filters['numeroGrupo']) {
            $where.=" AND v.numero_grupo='" . $filters['numeroGrupo']."'";
        }
         if ($filters['numeroOrden']) {
            $where.=" AND v.numero_orden='" . $filters['numeroOrden']."'";
        }
        
        if ($filters['rango']) {
            if (isset($recibido)) {
                $where.=" AND r.fecha_recibido BETWEEN '" . $filters['fechaDesde'] . "' AND '" . $filters['fechaHasta'] . "'";
            } elseif (isset($transito)) {
                $where.=" AND r.fecha BETWEEN '" . $filters['fechaDesde'] . "' AND '" . $filters['fechaHasta'] . "'";
            } else {
                $where.=" AND estados_vehiculos.creado BETWEEN '" . $filters['fechaDesde'] . "' AND '" . $filters['fechaHasta'] . "'";
            }
        }

        if (!$order) {
            $order = " modelo_nombre asc,modelo_anio asc,color_vehiculo asc";
        }

        $query = "SELECT   distinct(v.*),
                                        cm.codigo as modelo_codigo,cm.anio as modelo_anio,nm.nombre as modelo_nombre,cm.version as modelo_version,
                                        tipo_estado_vehiculo.estado as vehiculo_estado,tipo_estado_vehiculo.slug as vehiculo_estado_slug,r.fecha as remito_fecha,
                                        r.numero as remito_numero,r.fecha_recibido,v.numero_pedido,tv.nombre as tipo_venta_especial,tv.slug as venta_especial_slug,d.nombre as deposito_actual,
                                        ch_ci.id as check_control_interno_resultado_cabecera_id,ch_ci.firmado,cv.color as color_vehiculo,epat.slug as estado_patentamiento,
                                        pat.dominio,current_date-fecha_emision_documento::date as dias_en_stock,age.fecha as fecha_entrega,age.hora as hora_entrega,encuesta.id as encuesta_alerta_temprana,
                                        (select id from danios_vehiculos_interno where vehiculo_id=v.id and solucionado=false limit 1) as danio_interno_sin_solucionar,
                                        (select id from danios_vehiculo_gm where vehiculo_id=v.id and tipo_estado_danio_gm_id!=3 limit 1) as danio_gm_sin_solucionar,
                                        cli.reventa,estados_vehiculos.creado as fecha_estado
					FROM     estados_vehiculos
					INNER JOIN (SELECT max(id) as lastId, vehiculo_id from estados_vehiculos group by vehiculo_id) eevv on estados_vehiculos.id =  eevv.lastId
					INNER JOIN vehiculos v ON estados_vehiculos.vehiculo_id = v.id
					INNER JOIN tipo_estado_vehiculo  ON estados_vehiculos.tipo_estado_vehiculo_id = tipo_estado_vehiculo.id
                                        INNER JOIN colores_vehiculos cv ON v.color_vehiculo_id=cv.id
                                        LEFT JOIN codigos_modelo cm ON v.codigo_modelo_id=cm.id
                                        LEFT JOIN nombres_modelo nm ON cm.nombre_modelo_id=nm.id
                                        LEFT JOIN remitos r ON v.remito_id=r.id
                                        LEFT JOIN tipos_venta_especial tv ON v.tipo_venta_especial_id=tv.id
                                        
                                        LEFT JOIN (SELECT max(id) as lastIdMd, vehiculo_id from movimientos_depositos group by vehiculo_id) mmdd on v.id =  mmdd.vehiculo_id
                                        LEFT JOIN  movimientos_depositos md ON  mmdd.lastIdMd=md.id
                                        LEFT JOIN depositos d ON md.deposito_destino_id=d.id
                                        LEFT JOIN check_control_interno_resultado_cabeceras ch_ci ON v.id=ch_ci.vehiculo_id
                                        LEFT JOIN patentamientos pat ON v.patentamiento_id=pat.id
                                        LEFT JOIN estados_patentamiento epat ON pat.estado_patentamiento_id=epat.id
                                        LEFT JOIN agenda_entregas age ON v.id=age.vehiculo_id
                                        LEFT JOIN encuesta_resultados_cabeceras encuesta ON v.id=encuesta.vehiculo_id
                                        LEFT JOIN clientes cli ON v.cliente_id=cli.id
                                        WHERE " . $where .
                " ORDER BY " . $order;

        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getVendidosPorVendedor($vendedor, $fechaDesde, $fechaHasta) {
        $db = $this->getEntityManager()->getConnection();
        $vendedorId = $vendedor->getId();
        $where = " vehiculos.vendedor_id =$vendedorId";

        if ($fechaDesde and $fechaHasta) {
            $fechaDesde = $fechaDesde->format('Y-m-d') . ' 00:00:00';
            $fechaHasta = $fechaHasta->format('Y-m-d') . ' 23:59:59';
            $where.= " AND facturas.fecha BETWEEN '$fechaDesde' and '$fechaHasta'";
        }
        $query = "SELECT
                vehiculos.id AS id,
                 vehiculos.codigo_modelo_id AS codigo_modelo_id,
                 vehiculos.creado_por AS creado_por,
                 vehiculos.actualizado_por AS actualizado_por,
                 vehiculos.remito_id AS remito_id,
                 vehiculos.cliente_id AS cliente_id,
                 vehiculos.tipo_venta_especial_id AS tipo_venta_especial_id,
                 vehiculos.factura_id AS factura_id,
                 vehiculos.patentamiento_id AS patentamiento_id,
                 vehiculos.transportista_id AS transportista_id,
                 vehiculos.vin AS vin,
                 vehiculos.motor AS motor,
                 vehiculos.codigo_llave AS codigo_llave,
                 vehiculos.codigo_radio AS codigo_radio,
                 vehiculos.codigo_seguridad AS codigo_seguridad,
                 vehiculos.codigo_inmovilizador AS codigo_inmovilizador,
                 vehiculos.km_ingreso AS km_ingreso,
                 vehiculos.observacion AS observacion,
                 vehiculos.creado AS creado,
                 vehiculos.actualizado AS actualizado,
                 vehiculos.chasis AS chasis,
                 vehiculos.documento AS documento,
                 vehiculos.importe AS importe,
                 vehiculos.impuestos AS impuestos,
                 vehiculos.numero_pedido AS numero_pedido,
                 vehiculos.numero_orden AS numero_orden,
                 vehiculos.numero_grupo AS numero_grupo,
                 vehiculos.numero_solicitud AS numero_solicitud,
                 vehiculos.fecha_emision_documento AS fecha_emision_documento,
                 vehiculos.vendedor_id AS vendedor_id,
                 vehiculos.color_vehiculo_id AS color_vehiculo_id,
                 vehiculos.pagado AS pagado,
                 colores_vehiculos.color AS colores_vehiculos_color,
                 nombres_modelo.nombre||'|'||codigos_modelo.anio||'|'||codigos_modelo.version as modelo,
                 facturas.fecha AS facturas_fecha
                FROM
                facturas facturas INNER JOIN vehiculos vehiculos ON facturas.id = vehiculos.factura_id
                INNER JOIN colores_vehiculos colores_vehiculos ON vehiculos.color_vehiculo_id = colores_vehiculos.id
                INNER JOIN codigos_modelo codigos_modelo ON vehiculos.codigo_modelo_id = codigos_modelo.id
                INNER JOIN nombres_modelo nombres_modelo ON codigos_modelo.nombre_modelo_id = nombres_modelo.id
                WHERE " . $where;


        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /*
     * devulve las entregas programadas en un rango de fechas
     */

    public function getAgendaEntregas($fechaDesde, $fechaHasta) {
        $db = $this->getEntityManager()->getConnection();
        $fechaDesde = $fechaDesde->format('Y-m-d') . ' 00:00:00';
        $fechaHasta = $fechaHasta->format('Y-m-d') . ' 23:59:59';
        $query = "SELECT v.*,
                         nombres_modelo.nombre||'|'||codigos_modelo.anio||'|'||codigos_modelo.version as modelo,
                         colores_vehiculos.color, a.fecha as fecha_entrega, a.hora as hora_entrega, a.hora, a.descripcion as descripcion_entrega, d.nombre as deposito_actual,
                         personas.apellido ||', '||personas.nombre as cliente,
                         (select personas.apellido||', '||personas.nombre
                        from empleados
                        LEFT JOIN persona_tipos ON empleados.id = persona_tipos.empleado_id
                        LEFT JOIN personas ON persona_tipos.persona_id = personas.id
                        where empleados.id = v.vendedor_id
                        ) as vendedor

                        FROM estados_vehiculos
                        INNER JOIN (SELECT max(id) as lastId, vehiculo_id from estados_vehiculos group by vehiculo_id) eevv on estados_vehiculos.id = eevv.lastId
                        INNER JOIN vehiculos v ON estados_vehiculos.vehiculo_id = v.id
                        INNER JOIN tipo_estado_vehiculo ON estados_vehiculos.tipo_estado_vehiculo_id = tipo_estado_vehiculo.id

                        INNER JOIN agenda_entregas a ON a.vehiculo_id = v.id
                        INNER JOIN colores_vehiculos colores_vehiculos ON v.color_vehiculo_id = colores_vehiculos.id
                        INNER JOIN codigos_modelo codigos_modelo ON v.codigo_modelo_id = codigos_modelo.id
                        INNER JOIN nombres_modelo nombres_modelo ON codigos_modelo.nombre_modelo_id = nombres_modelo.id
                        LEFT JOIN (SELECT max(id) as lastIdMd, vehiculo_id from movimientos_depositos group by vehiculo_id) mmdd ON v.id = mmdd.vehiculo_id
                        LEFT JOIN movimientos_depositos md ON mmdd.lastIdMd = md.id
                        LEFT JOIN depositos d ON md.deposito_destino_id = d.id
                        LEFT JOIN clientes ON v.cliente_id = clientes.id
                        LEFT JOIN persona_tipos ON clientes.id = persona_tipos.cliente_id
                        LEFT JOIN personas ON persona_tipos.persona_id = personas.id
                        WHERE
                        tipo_estado_vehiculo.slug <> 'entregado' AND
                        a.fecha BETWEEN '$fechaDesde' and '$fechaHasta'";

        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getVehiculosEnStock($filters = null) {

        $where = "tev.slug in ('transito', 'recibido', 'stock') and (v.cliente_id is null or clientes.reventa = false)";
        $where.=" AND tv.slug in ('convencional','plan-de-ahorro-propio') ";
        $db = $this->getEntityManager()->getConnection();

        if ($filters['colorVehiculo']) {
            $where.=" AND v.color_vehiculo_id = " . $filters['colorVehiculo']->getId();
        }
        if ($filters['deposito']) {
            $where.=" AND d.id = " . $filters['deposito']->getId();
        }
        if ($filters['modelo']) {
            $where.=" AND nm.id = " . $filters['modelo']->getId();
        }
        if ($filters['anio']) {
            $where .= " AND cm.anio = '" . $filters['anio'] . "'";
        }
        if ($filters['codigo']) {
            $where .= " AND cm.codigo = '" . $filters['codigo'] . "'";
        }
        if ($filters['version']) {
            $where .= " AND cm.version = '" . $filters['version'] . "'";
        }
        if ($filters['tipoVenta']) {
            $where.=" AND v.tipo_venta_especial_id=" . $filters['tipoVenta']->getId();
        }
        if ($filters['patentado']) {
            if ($filters['patentado'] == 'si') {
                $where .= " AND pat.dominio is not null ";
            } else {
                $where .= " AND pat.dominio is null ";
            }
        }

        if ($filters['diaInicio']) {
            $where.=" AND (current_date-fecha_emision_documento::date >= " . $filters['diaInicio'] . ")";
        }

        if ($filters['diaFin']) {
            $where.=" AND (current_date-fecha_emision_documento::date <= " . $filters['diaFin'] . ")";
        }
        if ($filters['rango']) {
            $aFecha = explode(' - ', $filters['rango']);
            $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
            $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);
            $where.=" AND v.fecha_emision_documento between '" . $fechaDesde->format("Y-m-d") . "' and '" . $fechaHasta->format("Y-m-d") . "' ";
        }

        $query = "SELECT distinct(v.*),
                    nm.nombre||'|'||cm.anio||'|'||cm.version as modelo, nm.nombre as nombre_modelo,
                    tev.estado as vehiculo_estado, tev.slug as vehiculo_estado_slug, remitos.fecha as remito_fecha,
                    remitos.numero as remito_numero, v.numero_pedido, tv.nombre as tipo_venta_especial, tv.slug as venta_especial_slug, d.nombre as deposito_actual,
                    cv.color as color_vehiculo,epat.slug as estado_patentamiento_slug,
                    pat.dominio, current_date-fecha_emision_documento::date as dias_en_stock, age.fecha as fecha_entrega
                   FROM estados_vehiculos
                   INNER JOIN (SELECT max(id) as lastId, vehiculo_id from estados_vehiculos group by vehiculo_id) eevv on estados_vehiculos.id = eevv.lastId
                   INNER JOIN vehiculos v ON estados_vehiculos.vehiculo_id = v.id
                   INNER JOIN tipo_estado_vehiculo tev ON estados_vehiculos.tipo_estado_vehiculo_id = tev.id
                   INNER JOIN colores_vehiculos cv ON v.color_vehiculo_id = cv.id
                   LEFT JOIN codigos_modelo cm ON v.codigo_modelo_id = cm.id
                   LEFT JOIN nombres_modelo nm ON cm.nombre_modelo_id = nm.id
                   LEFT JOIN remitos ON v.remito_id = remitos.id
                   LEFT JOIN tipos_venta_especial tv ON v.tipo_venta_especial_id = tv.id

                   LEFT JOIN (SELECT max(id) as lastIdMd, vehiculo_id from movimientos_depositos group by vehiculo_id) mmdd on v.id = mmdd.vehiculo_id
                   LEFT JOIN movimientos_depositos md ON mmdd.lastIdMd = md.id
                   LEFT JOIN depositos d ON md.deposito_destino_id = d.id
                   LEFT JOIN patentamientos pat ON v.patentamiento_id = pat.id
                   LEFT JOIN estados_patentamiento epat ON pat.estado_patentamiento_id=epat.id
                   LEFT JOIN agenda_entregas age ON v.id = age.vehiculo_id
                   LEFT JOIN clientes ON v.cliente_id = clientes.id
                   WHERE " . $where .
                " ORDER BY modelo, color_vehiculo asc, dias_en_stock desc";

        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getVehiculosCuponGarantia($filters = null) {

        $where = " v.factura_id is not null ";
        $db = $this->getEntityManager()->getConnection();

        if ($filters['conCupon'] == 'SI') {
            $where.=" AND v.cupon_garantia is not null";
        } else {
            $where.=" AND v.cupon_garantia is null";
        }


        $query = "SELECT distinct(v.*),
 nm.nombre||'|'||cm.anio||'|'||cm.version as modelo,
 tv.nombre as tipo_venta_especial, tv.slug as venta_especial_slug,
 cv.color as color_vehiculo
FROM vehiculos v
INNER JOIN colores_vehiculos cv ON v.color_vehiculo_id = cv.id
LEFT JOIN codigos_modelo cm ON v.codigo_modelo_id = cm.id
LEFT JOIN nombres_modelo nm ON cm.nombre_modelo_id = nm.id
LEFT JOIN tipos_venta_especial tv ON v.tipo_venta_especial_id = tv.id
WHERE " . $where .
                " ORDER BY modelo, color_vehiculo asc";

        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getTotalVehiculosPorFecha($fechaDesde, $fechaHasta) {

        $fechaDesde = $fechaDesde->format('Y-m-d') . ' 00:00:00';
        $fechaHasta = $fechaHasta->format('Y-m-d') . ' 23:59:59';

        $db = $this->getEntityManager()->getConnection();



        $query = "SELECT
count(vehiculos.id) as total
FROM
vehiculos vehiculos
WHERE vehiculos.creado BETWEEN '$fechaDesde' AND '$fechaHasta'";

        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll()[0]['total'];
    }

    public function getVehiculosPorEstado($fechaDesde, $fechaHasta, $estado = null) {

        $fechaDesde = $fechaDesde->format('Y-m-d') . ' 00:00:00';
        $fechaHasta = $fechaHasta->format('Y-m-d') . ' 23:59:59';

        $db = $this->getEntityManager()->getConnection();

        $where = '';

        if ($estado) {
            $where = " tipo_estado_vehiculo.slug = '$estado'
AND ";
        }

        $query = "SELECT
COUNT (DISTINCT (vehiculos.id)) AS total
FROM
tipo_estado_vehiculo tipo_estado_vehiculo INNER JOIN estados_vehiculos estados_vehiculos ON tipo_estado_vehiculo.id = estados_vehiculos.tipo_estado_vehiculo_id
INNER JOIN vehiculos vehiculos ON estados_vehiculos.vehiculo_id = vehiculos.id
WHERE
$where
estados_vehiculos.creado BETWEEN '$fechaDesde' AND '$fechaHasta'
";

        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll()[0]['total'];
    }

    public function getVehiculosRecibidos($fechaDesde, $fechaHasta) {

        return $this->getVehiculosPorEstado($fechaDesde, $fechaHasta, 'recibido');
    }

    public function getVehiculosRecibidosConDanios($fechaDesde, $fechaHasta) {

        $fechaDesde = $fechaDesde->format('Y-m-d') . ' 00:00:00';
        $fechaHasta = $fechaHasta->format('Y-m-d') . ' 23:59:59';

        $db = $this->getEntityManager()->getConnection();


        $query = "SELECT
count(danios_vehiculo_gm.id) as cantidad
FROM
danios_vehiculo_gm danios_vehiculo_gm
WHERE
danios_vehiculo_gm.vehiculo_id IN (SELECT
vehiculos.id AS vehiculos_id
FROM
tipo_estado_vehiculo tipo_estado_vehiculo INNER JOIN estados_vehiculos estados_vehiculos ON tipo_estado_vehiculo.id = estados_vehiculos.tipo_estado_vehiculo_id
INNER JOIN vehiculos vehiculos ON estados_vehiculos.vehiculo_id = vehiculos.id
WHERE
tipo_estado_vehiculo.slug = 'recibido'
AND estados_vehiculos.id in (
SELECT max(id) from estados_vehiculos estados_vehiculos_sq
WHERE estados_vehiculos_sq.creado BETWEEN '$fechaDesde' AND '$fechaHasta'
Group by estados_vehiculos_sq.vehiculo_id
)
)";

        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll()[0]['cantidad'];
    }

    public function getVehiculosConDaniosGm($fechaDesde, $fechaHasta) {

        $fechaDesde = $fechaDesde->format('Y-m-d') . ' 00:00:00';
        $fechaHasta = $fechaHasta->format('Y-m-d') . ' 23:59:59';

        $db = $this->getEntityManager()->getConnection();


        $query = "SELECT
count(distinct(vehiculos.id)) as cantidad
FROM
tipos_danio_gm tipos_danio_gm INNER JOIN danios_vehiculo_gm danios_vehiculo_gm ON tipos_danio_gm.id = danios_vehiculo_gm.tipo_danio_id
INNER JOIN vehiculos vehiculos ON danios_vehiculo_gm.vehiculo_id = vehiculos.id
WHERE
danios_vehiculo_gm.creado BETWEEN '$fechaDesde' AND '$fechaHasta'";

        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll()[0]['cantidad'];
    }

    public function getVehiculosConDaniosInternos($fechaDesde, $fechaHasta) {

        $fechaDesde = $fechaDesde->format('Y-m-d') . ' 00:00:00';
        $fechaHasta = $fechaHasta->format('Y-m-d') . ' 23:59:59';

        $db = $this->getEntityManager()->getConnection();


        $query = "SELECT
count(DISTINCT (vehiculos.id)) as cantidad
FROM
vehiculos vehiculos INNER JOIN danios_vehiculos_interno danios_vehiculos_interno ON vehiculos.id = danios_vehiculos_interno.vehiculo_id
WHERE
danios_vehiculos_interno.creado BETWEEN '$fechaDesde' AND '$fechaHasta'";

        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll()[0]['cantidad'];
    }

    public function getVehiculosPorDeposito($filters = null) {


        $db = $this->getEntityManager()->getConnection();


        $where = "tipo_estado_vehiculo.slug!='entregado' AND d.id = " . $filters['deposito']->getId();

        if ($filters['colorVehiculo']) {
            $where.=" AND v.color_vehiculo_id = " . $filters['colorVehiculo']->getId();
        }
        if ($filters['tipoVentaEspecial']) {
            $where.=" AND tv.id = " . $filters['tipoVentaEspecial']->getId();
        }
        if ($filters['modelo']) {
            $where.=" AND nm.id = " . $filters['modelo']->getId();
        }


        $query = "SELECT distinct(v.*),
 nm.nombre||'|'||cm.anio||'|'||cm.version as modelo, nm.nombre as nombre_modelo,
 v.numero_pedido, tv.nombre as tipo_venta_especial, tv.slug as venta_especial_slug, d.nombre as deposito_actual,
 cv.color as color_vehiculo

FROM estados_vehiculos
INNER JOIN (SELECT max(id) as lastId, vehiculo_id from estados_vehiculos group by vehiculo_id) eevv on estados_vehiculos.id = eevv.lastId
INNER JOIN vehiculos v ON estados_vehiculos.vehiculo_id = v.id
INNER JOIN tipo_estado_vehiculo ON estados_vehiculos.tipo_estado_vehiculo_id = tipo_estado_vehiculo.id

INNER JOIN colores_vehiculos cv ON v.color_vehiculo_id = cv.id
LEFT JOIN codigos_modelo cm ON v.codigo_modelo_id = cm.id
LEFT JOIN nombres_modelo nm ON cm.nombre_modelo_id = nm.id
LEFT JOIN tipos_venta_especial tv ON v.tipo_venta_especial_id = tv.id

LEFT JOIN (SELECT max(id) as lastIdMd, vehiculo_id from movimientos_depositos group by vehiculo_id) mmdd on v.id = mmdd.vehiculo_id
LEFT JOIN movimientos_depositos md ON mmdd.lastIdMd = md.id
LEFT JOIN depositos d ON md.deposito_destino_id = d.id
WHERE " . $where .
                " ORDER BY modelo, color_vehiculo asc";

        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getVehiculosAsignadosAReventa($filters) {
        $db = $this->getEntityManager()->getConnection();

        $where = '1=1';

        if ($filters['facturado'] == 1) {
            $where .= " AND vehiculos.factura_id IS NOT NULL";
        } else if ($filters['facturado'] == 2) {
            $where .= " AND vehiculos.factura_id IS NULL";
        }

        if ($filters['reventa']) {
            $where .= " AND vehiculos.cliente_id = " . $filters['reventa']->getId();
            $where .= " AND clientes.reventa = true";
        }

        if ($filters['diaInicio']) {
            $where .= " AND (current_date-vehiculos.fecha_emision_documento::date >= " . $filters['diaInicio'] . ")";
        }

        if ($filters['diaFin']) {
            $where .= " AND (current_date-vehiculos.fecha_emision_documento::date <= " . $filters['diaFin'] . ")";
        }


        $query = "
                    SELECT
                    vehiculos.*,
                     current_date-vehiculos.fecha_emision_documento::date as dias_de_recibido,
                     nombres_modelo.nombre||'|'||codigos_modelo.anio||'|'||codigos_modelo.version as modelo,
                     colores_vehiculos.color AS color_vehiculo,
                     personas.nombre AS personas_nombre,
                     personas.apellido AS personas_apellido,
                     estados_patentamiento.estado AS estado_patentamiento
                    FROM
                    colores_vehiculos colores_vehiculos INNER JOIN vehiculos vehiculos ON colores_vehiculos.id = vehiculos.color_vehiculo_id
                    INNER JOIN codigos_modelo codigos_modelo ON vehiculos.codigo_modelo_id = codigos_modelo.id
                    LEFT OUTER JOIN clientes clientes ON vehiculos.cliente_id = clientes.id
                    LEFT OUTER JOIN patentamientos patentamientos ON vehiculos.patentamiento_id = patentamientos.id
                    LEFT OUTER JOIN estados_patentamiento estados_patentamiento ON patentamientos.estado_patentamiento_id = estados_patentamiento.id
                    LEFT OUTER JOIN persona_tipos persona_tipos ON clientes.id = persona_tipos.cliente_id
                    LEFT OUTER JOIN personas personas ON persona_tipos.persona_id = personas.id
                    INNER JOIN nombres_modelo nombres_modelo ON codigos_modelo.nombre_modelo_id = nombres_modelo.id
                    WHERE
                    $where
                    ";

        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getVehiculosPatentamientos($filters = null) {

        $db = $this->getEntityManager()->getConnection();
        $where = "tipo_estado_vehiculo.slug in ('pendiente-por-entregar', 'entregado') ";

        if ($filters['rango']) {
            $aFecha = explode(' - ', $filters['rango']);
            $fechaDesde = \DateTime::createFromFormat('d/m/Y', $aFecha[0]);
            $fechaHasta = \DateTime::createFromFormat('d/m/Y', $aFecha[1]);
            $fechaDesde = $fechaDesde->format('Y-m-d') . ' 00:00:00';
            $fechaHasta = $fechaHasta->format('Y-m-d') . ' 23:59:59';
        }

        if ($filters['estado'] == 'pendiente') {
            $where.= " AND pat.id is null ";
        } else if ($filters['estado'] == 'iniciado') {
            $where.= " AND epat.slug = 'iniciado' ";
            if ($filters['rango']) {
                $where.=" AND pat.fecha_inicio BETWEEN '$fechaDesde' AND '$fechaHasta'";
            }
        } else if ($filters['estado'] == 'patentado') {
            $where.= " AND epat.slug = 'patentado' ";
            if ($filters['rango']) {
                $where.=" AND pat.fecha_patentamiento BETWEEN '$fechaDesde' AND '$fechaHasta'";
            }
        }
        if ($filters['tipoVentaEspecial']) {
            $where.=" AND tv.id = " . $filters['tipoVentaEspecial']->getId();
        }


        $query = "SELECT distinct(v.*),
                         nm.nombre||'|'||cm.anio||'|'||cm.version as modelo, nm.nombre as nombre_modelo,
                         tipo_estado_vehiculo.estado as vehiculo_estado, tipo_estado_vehiculo.slug as vehiculo_estado_slug,
                         tv.nombre as tipo_venta_especial, cv.color as color_vehiculo, epat.slug as estado_patentamiento,
                         pat.dominio, cli.reventa, personas.apellido ||', '||personas.nombre as cliente, ainicio.nombre as agente_patentamiento,
                         pat.fecha_inicio, pat.fecha_patentamiento, pat.registro, personas.celular
                        FROM estados_vehiculos
                        INNER JOIN (SELECT max(id) as lastId, vehiculo_id from estados_vehiculos group by vehiculo_id) eevv on estados_vehiculos.id = eevv.lastId
                        INNER JOIN vehiculos v ON estados_vehiculos.vehiculo_id = v.id
                        INNER JOIN tipo_estado_vehiculo ON estados_vehiculos.tipo_estado_vehiculo_id = tipo_estado_vehiculo.id
                        INNER JOIN colores_vehiculos cv ON v.color_vehiculo_id = cv.id
                        LEFT JOIN codigos_modelo cm ON v.codigo_modelo_id = cm.id
                        LEFT JOIN nombres_modelo nm ON cm.nombre_modelo_id = nm.id
                        LEFT JOIN tipos_venta_especial tv ON v.tipo_venta_especial_id = tv.id
                        LEFT JOIN patentamientos pat ON v.patentamiento_id = pat.id
                        LEFT JOIN agentes_inicio_patentes ainicio ON pat.agente_inicio_patente_id = ainicio.id
                        LEFT JOIN estados_patentamiento epat ON pat.estado_patentamiento_id = epat.id
                        LEFT JOIN clientes cli ON v.cliente_id = cli.id
                        LEFT JOIN persona_tipos ON cli.id = persona_tipos.cliente_id
                        LEFT JOIN personas ON persona_tipos.persona_id = personas.id
                        WHERE " . $where .
                " ORDER BY modelo, color_vehiculo asc";

        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

}

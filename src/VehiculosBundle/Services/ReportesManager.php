<?php

/**
 * Created by PhpStorm.
 * User: matias
 * Date: 15/2/16
 * Time: 3:49 PM
 */

namespace VehiculosBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAware;

class ReportesManager {

    /** @var $container Container */
    private $container;
    /* @var $em EntityManager */
    private $em;

    public function __construct($container) {
        $this->container = $container;
        $this->em = $container->get('doctrine')->getManager();
    }

    public function getAutosVendidosPorVendedor($vendedor, $fechaDesde = null, $fechaHasta = null) {

        $em = $this->em;

        $aRegistros = $em->getRepository('VehiculosBundle:Vehiculo')->getVendidosPorVendedor($vendedor, $fechaDesde, $fechaHasta);

        return $aRegistros;
    }

    /*
     * devuelve listado de entregas en un rago de fechas
     */

    public function getAgendaEntregas($fechaDesde = null, $fechaHasta = null) {

        $em = $this->em;

        $aRegistros = $em->getRepository('VehiculosBundle:Vehiculo')->getAgendaEntregas($fechaDesde, $fechaHasta);

        return $aRegistros;
    }

    public function getHeader() {

        $usuario = $this->container->get('security.token_storage')->getToken()->getUser();

        $rutaLogo = $this->container->get('router')->getContext()->getScheme() . '://' . $this->container->get('router')->getContext()->getHost() .
                $this->container->get('templating.helper.assets')->getUrl('bundles/theme/images/gonzalez_automoviles.jpg');

        $fechaHoraActual = new \DateTime('now');

        $headerHtml = '<!DOCTYPE html>
                                <html>
                                <body style="margin:0; position: absolute;width: 100%;">
                                <div style="margin:0;">
                                <div style="float: left;width: 45%;" >
                                    <img style="max-width:100%; " src="' . $rutaLogo . '" />
                                </div>
                                <div style="float:left; width:33%;text-align:center; height:100% " >

                                </div>
                                <div style="float:right;width:33%; font-size:12pt">
									<span>' . $usuario . ' - ' . $fechaHoraActual->format('d-m-Y H:i:s') . '</span>
                                </div>
                               </div>

                               </body>
                               </html>';

        return $headerHtml;
    }

    public function getFooterHtml($piePrimeraLinea, $pieSegundaLinea = null) {


        $footerHtml = '<html><head><script>' . "
            function subst() {
              var vars={};
              var x=document.location.search.substring(1).split('&');
              for (var i in x) {var z=x[i].split('=',2);vars[z[0]] = unescape(z[1]);}
              var x=['frompage','topage','page','webpage','section','subsection','subsubsection'];
              for (var i in x) {
                var y = document.getElementsByClassName(x[i]);
                for (var j=0; j<y.length; ++j) y[j].textContent = vars[x[i]];
              }
            }" . '
            </script></head><body style="border:0; margin: 0;" onload="subst()">
            <table style="width: 100%">
              <tr>
                <td style="text-align:left;">
                    <div>
                        <p style="font-size: 8pt;"><b><i>' . $piePrimeraLinea . '</i></b><br> ' . $pieSegundaLinea . '
                        </p>
                    </div>
                </td>
                <td style="text-align:right;font-size: 8pt;">
                  Página <span class="page"></span> de <span class="topage"></span>
                </td>
              </tr>
            </table>
            </body></html>';

        return $footerHtml;
    }

    /*
     * $orientation V=vertical H=horizontal
     * $margin array con margenes
     */

    public function imprimir($html, $orientation = "V", $margin = null, $pageSize = 'A4') {
        $orientation = ($orientation == 'V') ? 'Portrait' : 'Landscape';

        if ($margin == null) {
            $margin = array(
                'right' => '1cm',
                'bottom' => '1cm',
            );
            if ($orientation == 'portrait') {
                $margin['top'] = '2cm';
                $margin['left'] = '2cm';
            } else {
                $margin['top'] = '4cm';
                $margin['left'] = '1cm';
            }
        }

        return $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                    'margin-left' => $margin['left'],
                    'margin-right' => $margin['right'],
                    'margin-top' => $margin['top'],
                    'margin-bottom' => $margin['bottom'],
                    'footer-right' => 'Pag [page] de [topage]',
                    'header-html' => $this->getHeader(),
                    'header-spacing' => '5',
                    'page-size' => $pageSize,
                    'orientation' => "$orientation",
        ));
    }

    public function imprimirCheckControlInterno($html) {
        return $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                    'margin-left' => '1cm',
                    'margin-right' => '1cm',
                    'margin-top' => '1cm',
                    'margin-bottom' => '1cm',
                    'footer-right' => 'Pag [page] de [topage]',
                    'page-size' => 'A4',
                    'orientation' => 'portrait',
        ));
    }

    public function reporteVehiculosRecibidosConDanios($fechaDesde, $fechaHasta) {
        $em = $this->em;

        $autosRecibidos = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosPorEstado($fechaDesde, $fechaHasta, 'recibido');

        $autosRecibidosConDanos = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosConDaniosGm($fechaDesde, $fechaHasta);

        $autosRecibidosSinDanos = $autosRecibidos - $autosRecibidosConDanos;


        return array(
            'autosRecibidos' => $autosRecibidos,
            'autosRecibidosConDanos' => $autosRecibidosConDanos,
            'autosRecibidosSinDanos' => $autosRecibidosSinDanos,
        );
    }
    public function reporteVehiculosConDanios($fechaDesde, $fechaHasta) {
        $em = $this->em;

        $autosRecibidos = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosPorEstado($fechaDesde, $fechaHasta, 'recibido');

        $autosRecibidosConDanos = $em->getRepository('VehiculosBundle:Vehiculo')->getVehiculosConDaniosInternos($fechaDesde, $fechaHasta);

        $autosRecibidosSinDanos = $autosRecibidos - $autosRecibidosConDanos;


        return array(
            'autosRecibidos' => $autosRecibidos,
            'autosRecibidosConDanos' => $autosRecibidosConDanos,
            'autosRecibidosSinDanos' => $autosRecibidosSinDanos,
        );
    }

    public function getVehiculosAsignadosAReventa( $filters ) {

        $em = $this->em;

        $vehiculos = $em->getRepository( 'VehiculosBundle:Vehiculo' )->getVehiculosAsignadosAReventa( $filters );

        return $vehiculos;

    }

}

<?php

namespace UtilBundle\Services;


use Doctrine\ORM\EntityManager;
use Liuggio\ExcelBundle\Factory;


class ExcelTool
{


    private $container;
    private $filename;
    private $title;
    private $descripcion;
    private $createby = 'BigD';
    private $doctrine;
    private $phpexcel;

    /**
     * @return mixed
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param mixed $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return string
     */
    public function getCreateby()
    {
        return $this->createby;
    }

    /**
     * @param string $createby
     */
    public function setCreateby($createby)
    {
        $this->createby = $createby;
    }

    /**
     * @return mixed
     */
    public function getDoctrine()
    {
        return $this->doctrine;
    }

    /**
     * @param mixed $doctrine
     */
    public function setDoctrine($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return mixed
     */
    public function getPhpexcel()
    {
        return $this->phpexcel;
    }

    /**
     * @param mixed $phpexcel
     */
    public function setPhpexcel($phpexcel)
    {
        $this->phpexcel = $phpexcel;
    }


    public function __construct(Factory $phpExcel, EntityManager $doctrine)
    {
        $this->phpexcel = $phpExcel;
        $this->doctrine = $doctrine;
    }



    /**
     * Arma la hoja para el listado de personas en la carga rapida de usuario, url: http://localhost/rismi/web/app_dev.php/rismi/persona/persona/list
     *
     * @param type $resultados
     * @return type
     */
    public function buildSheetListUsers($resultados)
    {
        $phpExcelObject = $this->container->get('phpexcel')->createPHPExcelObject();
        $phpExcelObject->getProperties()->setLastModifiedBy($this->createby);
        $phpExcelObject->getProperties()->setTitle($this->title);
        $phpExcelObject->getProperties()->setDescription($this->descripcion);
        $phpExcelObject->getProperties()->setCreator($this->createby);

        $phpExcelObject->setActiveSheetIndex(0);
        $phpExcelObject->getActiveSheet()
            ->setCellValue('A1', 'Id. Pers. Fed.')
            ->setCellValue('B1', 'Id. Pers. Inst.')
            ->setCellValue('C1', 'Id. Usuario')
            ->setCellValue('D1', 'Nombre y Apellido')
            ->setCellValue('E1', 'Usuario')
            ->setCellValue('F1', 'Aplicativo')
            ->setCellValue('G1', 'Grupos');


        $i = 2;
        $j = 2;
        if (is_array($resultados) && !empty ($resultados) || !is_null($resultados)) {
            foreach ($resultados as $usuario) {

                $phpExcelObject->getActiveSheet()->setCellValue('A'.$i, $usuario->getIdentificadorFederacion());
                if ($usuario->getPersonaInstitucional() != null) {
                    $phpExcelObject->getActiveSheet()->setCellValue(
                        'B'.$i,
                        $usuario->getPersonaInstitucional()->getId()
                    );
                } else {
                    $phpExcelObject->getActiveSheet()->setCellValue('B'.$i, null);
                }
                if ($usuario->getUsuario() != null) {
                    $phpExcelObject->getActiveSheet()->setCellValue('C'.$i, $usuario->getUsuario()->getId());
                } else {
                    $phpExcelObject->getActiveSheet()->setCellValue('C'.$i, null);
                }

                $phpExcelObject->getActiveSheet()->setCellValue('D'.$i, $usuario->getNombreCompleto());

                if ($usuario->getUsuario() != null) {
                    $phpExcelObject->getActiveSheet()->setCellValue('E'.$i, $usuario->getUsuario()->getUsername());
                } else {
                    $phpExcelObject->getActiveSheet()->setCellValue('E'.$i, null);
                }

                if ($usuario->getUsuario() != null) {
                    if ($usuario->getUsuario()->getPermisos() != null) {
                        foreach ($usuario->getUsuario()->getPermisos() as $permiso) {
                            $phpExcelObject->getActiveSheet()
                                ->setCellValue('F'.$i, $permiso->getAplicativo()->getNombre());

                            $phpExcelObject->getActiveSheet()
                                ->setCellValue('G'.$i, $permiso->getGrupo()->getName());

                        }
                    }


                }
                $j++;
                $i++;
            }
        }

        $phpExcelObject->getActiveSheet()->setTitle($this->title);//Configura el titulo del archivo

        $writer = $this->container->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->container->get('phpexcel')->createStreamedResponse($writer);

        return $response;

    }

    /**
     *
     * * Arma la hoja para el listado de personas que pertenecen al area
     *
     * @param type $resultSet
     * @param type $areaStr
     * @return type
     */
    public function buildSheetListArea($resultSet, $areaStr)
    {
        $phpExcelObject = $this->container->get('phpexcel')->createPHPExcelObject();
        $phpExcelObject->getProperties()->setLastModifiedBy($this->createby);
        $phpExcelObject->getProperties()->setTitle($this->title);
        $phpExcelObject->getProperties()->setDescription($this->descripcion);
        $phpExcelObject->getProperties()->setCreator($this->createby);

        $phpExcelObject->setActiveSheetIndex(0);
        $phpExcelObject->getActiveSheet()->setCellValue('A1', $areaStr);
        $phpExcelObject->getActiveSheet()
            ->setCellValue('A2', 'Id.')
            ->setCellValue('B2', 'Nombre y Apellido')
            ->setCellValue('C2', 'Tipo de Documento')
            ->setCellValue('D2', 'Numero');


        $i = 3;
        if (is_array($resultSet) && !empty ($resultSet) || !is_null($resultSet)) {
            foreach ($resultSet as $usuario) {
                $phpExcelObject->getActiveSheet()->setCellValue('A'.$i, $usuario['identificador']);
                $phpExcelObject->getActiveSheet()->setCellValue('B'.$i, $usuario['nombre_completo']);
                $phpExcelObject->getActiveSheet()->setCellValue('C'.$i, $usuario['tipo']);
                $phpExcelObject->getActiveSheet()->setCellValue('D'.$i, $usuario['documento']);
                $i++;
            }

        }

        $phpExcelObject->getActiveSheet()->setTitle($this->title);

        $writer = $this->container->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->container->get('phpexcel')->createStreamedResponse($writer);

        return $response;

    }



}


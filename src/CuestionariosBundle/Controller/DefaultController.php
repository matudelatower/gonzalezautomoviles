<?php

namespace CuestionariosBundle\Controller;

use CuestionariosBundle\Form\CheckListParameterType;
use CuestionariosBundle\Form\Model\CheckListParameter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CuestionariosBundle:Default:index.html.twig', array('name' => $name));
    }


}

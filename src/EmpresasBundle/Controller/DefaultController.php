<?php

namespace EmpresasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('EmpresasBundle:Default:index.html.twig', array('name' => $name));
    }
}

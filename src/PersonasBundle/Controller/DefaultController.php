<?php

namespace PersonasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PersonasBundle:Default:index.html.twig', array('name' => $name));
    }
}

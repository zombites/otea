<?php

namespace Zombit\OteaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ZombitOteaBundle:Default:index.html.twig', array('active' => 0));
    }

    public function dashboardAction()
    {
    	return $this->render('ZombitOteaBundle:Default:dashboard.html.twig', array('active' => 0));
    }

    public function searchAction()
    {
        return $this->render('ZombitOteaBundle:Default:search.html.twig', array('active' => 1));
    }

}

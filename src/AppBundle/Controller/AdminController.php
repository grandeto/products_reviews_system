<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function viewAction(){
        return $this->render('AppBundle:Admin:dashboard.html.twig');
    }
}

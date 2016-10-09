<?php

namespace NNP\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('NNPAdminBundle:Admin:index.html.twig');
    }
}
<?php

namespace NNP\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomepageController extends Controller
{
    public function indexAction()
    {
    	$content = $this->get('templating')->render('NNPPlatformBundle:Homepage:index.html.twig');
    	return new Response($content);
    }
}
<?php

namespace NNP\PlatformBundle\Controller;

use NNP\PlatformBundle\Entity\User ;
use NNP\PlatformBundle\Entity\Ndem ;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NNP\PlatformBundle\Form\UserType ;
use NNP\PlatformBundle\Form\NdemType ;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends Controller
{
    public function indexAction()
    {
    	$content = $this->get('templating')->render('NNPPlatformBundle:Homepage:index.html.twig');
    	return new Response($content);
    }

    public function presentationAction()
    {
    	$content = $this->get('templating')->render('NNPPlatformBundle:Homepage:presentation.html.twig');
    	return new Response($content);
    }

    public function profilAction($id)
    {
        $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('NNPPlatformBundle:User');

        $user = $repository->find($id); //var_dump($user); exit();

        $content = $this->get('templating')->render('NNPPlatformBundle:Homepage:profil.html.twig', array('idUser'=>$id, 'user'=>$user));
        return new Response($content);
    }

    public function editerProfilAction($id, Request $request)
    {
        $user = $this->getDoctrine()
                ->getManager()
                ->getRepository('NNPPlatformBundle:User')
                ->find($id);

        $form = $this->get('form.factory')->create(UserType::class,$user);
            //->add('lastname', 'text', array('label' => 'Identifiant','data' => $user->getLastname()));

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

          $photo = $form['photo']->getData(); 
          if (isset($photo)){
              $photo = $user->getPhoto();
              $photoname = md5(uniqid()).'.'.$photo->guessExtension();
              $photo->move(
                    $this->getParameter('photoprofil_directory'),
                    $photoname
                );

              $user->setPhoto($photoname); 
          }
          

          $em = $this->getDoctrine()->getManager();
          $em->persist($user);
          $em->flush();

          $request->getSession()->getFlashBag()->add('notice', 'Infos bien enregistrées.');

          return $this->redirectToRoute('nnp_platform_profil', array('id' => $user->getId()));
        }

        $content = $this->get('templating')->render('NNPPlatformBundle:Homepage:editerProfil.html.twig', array('id'=>$id, 'form' => $form->createView()));
        return new Response($content);
    }

    public function creerNdemAction(Request $request)
    {
        $ndem = new Ndem();
        $form = $this->get('form.factory')->create(NdemType::class, $ndem);

        $content = $this->get('templating')->render('NNPPlatformBundle:Homepage:creerNdem.html.twig', array('form'=>$form->createView()));
        return new Response($content);
    }
}
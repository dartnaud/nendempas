<?php

namespace NNP\AdminBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use NNP\PlatformBundle\Entity\User ;
use NNP\PlatformBundle\Entity\Ndem ;
use NNP\PlatformBundle\Entity\Categorie ;
use NNP\PlatformBundle\Entity\Commentaire ;
use NNP\PlatformBundle\Entity\Follower ;
use NNP\PlatformBundle\Entity\Profil ;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NNP\PlatformBundle\Form\UserType ;
use NNP\PlatformBundle\Form\NdemType ;
use NNP\PlatformBundle\Form\CategorieType ;
use NNP\PlatformBundle\Form\ProfilType ;
use NNP\PlatformBundle\Form\CommentaireType ;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('NNPAdminBundle:Admin:index.html.twig');
    }

    public function gestionCommentAction(Request $request)
    {
    	

    	$em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('NNPPlatformBundle:Commentaire');

        $supprimeId = $request->query->get('supprimeid');
        if (isset($supprimeId)){
    		$commentASupprimer = $repository->find($supprimeId);
    		$em->remove($commentASupprimer);
    		$em->flush();

    		return $this->redirectToRoute('nnp_admin_gestionComment');
    	}

        $comments = $repository->findAll(); 
        return $this->render('NNPAdminBundle:Admin:gestionComment.html.twig', array('comments'=>$comments));
    }

    public function editerCommentAction(Request $request)
    {
    	$id = $request->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('NNPPlatformBundle:Commentaire');

        $comment = $repository->find($id); 

        $form = $this->get('form.factory')->create(CommentaireType::class, $comment);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
	      $em = $this->getDoctrine()->getManager();
	      $em->persist($comment);
	      $em->flush();

	      //$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

	      return $this->redirectToRoute('nnp_admin_gestionComment');
	    }
        return $this->render('NNPAdminBundle:Admin:editerComment.html.twig', array('form'=>$form->createView()));
    }


    public function gestionNdemAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('NNPPlatformBundle:Ndem');

        $supprimeId = $request->query->get('supprimeid');
        if (isset($supprimeId)){
    		$ndemASupprimer = $repository->find($supprimeId);
    		$em->remove($ndemASupprimer);
    		$em->flush();

    		return $this->redirectToRoute('nnp_admin_gestionNdem');
    	}

        $ndems = $repository->findAll(); 
        return $this->render('NNPAdminBundle:Admin:gestionNdem.html.twig', array('ndems'=>$ndems));
    }

    public function editerNdemAction(Request $request)
    {
    	$id = $request->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('NNPPlatformBundle:Ndem');

        $ndem = $repository->find($id); 

        $form = $this->get('form.factory')->create(NdemType::class, $ndem);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
	      $em = $this->getDoctrine()->getManager();
	      $em->persist($ndem);
	      $em->flush();

	      //$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

	      return $this->redirectToRoute('nnp_admin_gestionNdem');
	    }
        return $this->render('NNPAdminBundle:Admin:editerNdem.html.twig', array('form'=>$form->createView()));
    }

    public function gestionProfilAction()
    {
    	$em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('NNPPlatformBundle:Profil');

        $profils = $repository->findAll(); 
        return $this->render('NNPAdminBundle:Admin:gestionProfil.html.twig', array('profils'=>$profils));
    }

    public function creerProfilAction(Request $request)
    {
        $profil = new Profil();
        $form = $this->get('form.factory')->create(ProfilType::class, $profil);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
	      $em = $this->getDoctrine()->getManager();
	      $em->persist($profil);
	      $em->flush();

	      //$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

	      return $this->redirectToRoute('nnp_admin_gestionProfil');
	    }
        return $this->render('NNPAdminBundle:Admin:creerProfil.html.twig', array('form'=>$form->createView()));
    }

    public function editerProfilAction(Request $request)
    {
    	$id = $request->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('NNPPlatformBundle:Profil');

        $profil = $repository->find($id); 

        $form = $this->get('form.factory')->create(ProfilType::class, $profil);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
	      $em = $this->getDoctrine()->getManager();
	      $em->persist($profil);
	      $em->flush();

	      //$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

	      return $this->redirectToRoute('nnp_admin_gestionProfil');
	    }
        return $this->render('NNPAdminBundle:Admin:editerProfil.html.twig', array('form'=>$form->createView()));
    }

    public function gestionUserAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('NNPPlatformBundle:User');

        $supprimeId = $request->query->get('supprimeid');
        if (isset($supprimeId)){
    		$userASupprimer = $repository->find($supprimeId);
    		$em->remove($userASupprimer);
    		$em->flush();

    		return $this->redirectToRoute('nnp_admin_gestionUser');
    	}

        $users = $repository->findAll(); 
        return $this->render('NNPAdminBundle:Admin:gestionUser.html.twig', array('users'=>$users));
    }



    public function editerUserAction(Request $request)
    {
    	$id = $request->query->get('id');
    	$em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('NNPPlatformBundle:User');

        $user = $repository->find($id);

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user)
            ->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('pseudo', ChoiceType::class, array(
                'choices' => array(
                    'Non' => '0',
                    'Oui' => '1'
                ),
                'required'    => false,
                'label' => 'Masquer votre identité (nom et prénom)',
                'empty_data'  => null
            ))
            ->add('sexe', ChoiceType::class, array(
                'choices' => array(
                    'Masculin' => 'm',
                    'Feminin' => 'f'
                ),
                'required'    => false,
                'empty_data'  => null
            ))
            ->add('photo', FileType::class, array('label' => 'Photo de profil','required'=>false, 'data_class'=>null))
            ->add('texte', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',
                    //...
                ),))
            ->add('profil')
            ->add('save', SubmitType::class, array('label'=>'Enregistrer'));
        ;

        $form = $formBuilder->getForm();

        //$form = $this->get('form.factory')->create(UserType::class,$user);
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

          //$request->getSession()->getFlashBag()->add('notice', 'Infos bien enregistrées.');

          return $this->redirectToRoute('nnp_admin_gestionUser');
        }

        $content = $this->get('templating')->render('NNPAdminBundle:Admin:editerUser.html.twig', array('form' => $form->createView()));
        return new Response($content);
    }

    public function editerUserLoginAction(Request $request)
    {
    	$id = $request->query->get('id');
    	$em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('NNPPlatformBundle:User');

        $user = $repository->find($id);

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user)


	          ->add('email',     TextType::class)
	          ->add('username',     TextType::class, array('label'=>'Username(Pseudo)'))
	          ->add('password',     PasswordType::class)

	      //$form = $this->get('form.factory')->create(UserType::class,$user)
	             // ->add('username', TextType::class, array('label'=>'Identifiant'))
	              ->add('save', SubmitType::class, array('label'=>'Enregistrer'));

	      $form = $formBuilder->getForm();

	      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

	        
	        $password = $form['password']->getData(); 
	        $user->setPlainPassword($password);

	        $em = $this->getDoctrine()->getManager();
	        $em->persist($user);
	        $em->flush();

	        //$request->getSession()->getFlashBag()->add('notice', 'Infos bien enregistrées.');

	        return $this->redirectToRoute('nnp_admin_gestionUser');
	      }

        $content = $this->get('templating')->render('NNPAdminBundle:Admin:editerUserLogin.html.twig', array('form' => $form->createView()));
        return new Response($content);
    }
}
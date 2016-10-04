<?php

namespace NNP\PlatformBundle\Controller;

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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NNP\PlatformBundle\Form\UserType ;
use NNP\PlatformBundle\Form\NdemType ;
use NNP\PlatformBundle\Form\CategorieType ;
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

    public function mesNdemsAction(Request $request)
    {
        $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('NNPPlatformBundle:Ndem')
        ;

        $listeNdem = $repository->findByUser($this->getUser());

        $content = $this->get('templating')->render('NNPPlatformBundle:Homepage:mesNdems.html.twig', array('ndems'=> $listeNdem));
        return new Response($content);
    }

    public function leNdemAction($id, Request $request)
    {
        

        $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('NNPPlatformBundle:Ndem')
        ;
        $ndem = $repository->find($id);

        $comment = new Commentaire();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $comment)
            ->add('commentaire', TextareaType::class, array('label'=>'Laissez un commentaire'))
            ->add('save', SubmitType::class, array('label'=>'Envoyer'));

        $form = $formBuilder->getForm();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

          $comment->setUser($this->getUser());
          $comment->setNdem($ndem);

          $em = $this->getDoctrine()->getManager();
          $em->persist($comment);
          $em->flush();

          $request->getSession()->getFlashBag()->add('notice', 'Merci pour votre commentaire.');

          return $this->redirectToRoute('nnp_platform_leNdem', array('id'=>$id));
        }

        $repoComment = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('NNPPlatformBundle:Commentaire')
        ;
        $listeComments = $repoComment->findByNdem($ndem->getId());

        $content = $this->get('templating')->render('NNPPlatformBundle:Homepage:leNdem.html.twig', array('ndem'=> $ndem,'comments'=>$listeComments,'form' => $form->createView()));
        return new Response($content);
    }

    public function profilAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager(); 
        $listeNdem = $em->getRepository('NNPPlatformBundle:Ndem')->findByUser($this->getUser());
        $nbrNdem = sizeof($listeNdem);

        $user = $em->getRepository('NNPPlatformBundle:User')
                   ->find($this->getUser()->getId()); 

        $content = $this->get('templating')->render('NNPPlatformBundle:Homepage:profil.html.twig', array('nbrNdem'=>$nbrNdem));
        return new Response($content);
    }

    public function editerProfilAction( Request $request)
    {
        $user = $this->getDoctrine()
                ->getManager()
                ->getRepository('NNPPlatformBundle:User')
                ->find($this->getUser()->getId());

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user)
            ->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('pseudo', TextType::class, array('label'=>'Pseudo (Votre nom sur \'NeNdemPlus\' )'))
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

          $request->getSession()->getFlashBag()->add('notice', 'Infos bien enregistrées.');

          return $this->redirectToRoute('nnp_platform_profil');
        }

        $content = $this->get('templating')->render('NNPPlatformBundle:Homepage:editerProfil.html.twig', array('form' => $form->createView()));
        return new Response($content);
    }

    public function creerNdemAction(Request $request)
    {
        $ndem = new Ndem();
        //$form = $this->get('form.factory')->create(NdemType::class, $ndem);

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $ndem)
          ->add('categories', null ,array('label' => 'Choisir la catégorie'))
          ->add('titre',     TextType::class)
          ->add('texte',   CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',
                    //...
                ),))
          ->add('statut', ChoiceType::class, array(
                'choices'  => array(
                    'activer' => '1',
                    'desactiver' => '0',
                ),
            ))
          
          ->add('save', SubmitType::class, array('label'=>'Enregistrer'))
        ;

        $form = $formBuilder->getForm();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) { 
          //var_dump($form->getData());

          $ndem->setUser($this->getUser());

          $em = $this->getDoctrine()->getManager();
          $em->persist($ndem);
          $em->flush();

          $request->getSession()->getFlashBag()->add('notice', 'Ndem bien enregistrée.');

          return $this->redirectToRoute('nnp_platform_profil', array('id' => $this->getUser()->getId()));
        }


        $content = $this->get('templating')->render('NNPPlatformBundle:Homepage:creerNdem.html.twig', array('form'=>$form->createView()));
        return new Response($content);
    }

    public function modifierPasswordAction(Request $request)
    {
      $user = $this->getDoctrine()
                ->getManager()
                ->getRepository('NNPPlatformBundle:User')
                ->find($this->getUser()->getId());

      $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user)


          ->add('email',     TextType::class)
          ->add('username',     TextType::class)
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

        $request->getSession()->getFlashBag()->add('notice', 'Infos bien enregistrées.');

        return $this->redirectToRoute('nnp_platform_profil');
      }

      $content = $this->get('templating')->render('NNPPlatformBundle:Homepage:modifierPassword.html.twig', array('form' => $form->createView()));
      return new Response($content);

    }

    public function listeAction(Request $request)
    { 
        $categorie = $request->query->get('nom');
        $repoCat = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('NNPPlatformBundle:Categorie')
        ;
        $idcat = $repoCat->findOneBy(array('nom'=>$categorie)); 
        $repo = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('NNPPlatformBundle:Ndem')
        ;
        $ndems= $repo->findAll();

        if($ndems){
          $listeNdems = array();
          foreach ($ndems as $key => $value) {
              $categories = $value->getCategories();
              foreach ($categories as $value2) {
                if ($value2 == $idcat){
                    $listeNdems[] = $value;
                }
              }
          }
        }else {
            $listeNdems = null ;
        }

        $content = $this->get('templating')->render('NNPPlatformBundle:Homepage:liste.html.twig', array('listeNdems' => $listeNdems,'categorie'=> $categorie ));
        return new Response($content);

    }
}
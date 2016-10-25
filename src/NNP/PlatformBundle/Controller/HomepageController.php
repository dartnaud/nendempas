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
use NNP\PlatformBundle\Entity\Follower ;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NNP\PlatformBundle\Form\UserType ;
use NNP\PlatformBundle\Form\NdemType ;
use NNP\PlatformBundle\Form\CategorieType ;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class HomepageController extends Controller
{

    /*public function menuAction(){
      $em = $this->getDoctrine()->getManager();
      $repository = $em->getRepository('NNPPlatformBundle:Ndem');
    }*/
    

    public function indexAction()
    {
      $em = $this->getDoctrine()->getManager();

      

      $repoCat = $em->getRepository('NNPPlatformBundle:Categorie');
      $idCarriere = $repoCat->findOneBy(array('nom'=>'CARRIERE'));
      $idNjoka = $repoCat->findOneBy(array('nom'=>'NJOKA'));
      $idReligion = $repoCat->findOneBy(array('nom'=>'RELIGION'));
      $idMode = $repoCat->findOneBy(array('nom'=>'MODE'));
      $idAmour = $repoCat->findOneBy(array('nom'=>'AMOUR'));
      $idKwatt = $repoCat->findOneBy(array('nom'=>'KWATT'));

      $repo = $em->getRepository('NNPPlatformBundle:Ndem');
      $ndems= $repo->findAll();

      if($ndems){
        $listeNdemsCarriere = array();
        $listeNdemsNjoka = array();
        $listeNdemsReligion = array();
        $listeNdemsMode = array();
        $listeNdemsAmour = array();
        $listeNdemsKwatt = array();
        foreach ($ndems as $key => $value) {
            $categories = $value->getCategories();
            foreach ($categories as $value2) {
              if ($value2 == $idCarriere){
                  $listeNdemsCarriere[] = $value;
                  $ndemeurCarriere[] = $value->getUser();
              }
              else if ($value2 == $idNjoka){
                  $listeNdemsNjoka[] = $value;
                  $ndemeurNjoka[] = $value->getUser();
              }
              else if ($value2 == $idReligion){
                  $listeNdemsReligion[] = $value;
                  $ndemeurReligion[] = $value->getUser();
              }
              else if ($value2 == $idMode){
                  $listeNdemsMode[] = $value;
                  $ndemeurMode[] = $value->getUser();
              }
              else if ($value2 == $idAmour){
                  $listeNdemsAmour[] = $value;
                  $ndemeurAmour[] = $value->getUser();
              }
              else if ($value2 == $idKwatt){
                  $listeNdemsKwatt[] = $value;
                  $ndemeurKwatt[] = $value->getUser();
              }
            }
        }
      }else {
          $listeNdemsCarriere = null ;
          $listeNdemsNjoka = null ;
          $listeNdemsReligion = null ;
          $listeNdemsMode = null ;
          $listeNdemsAmour = null ;
          $listeNdemsKwatt = null ;
      }

      $ndemeurCarriere = array_unique($ndemeurCarriere); 
      $ndemeurNjoka = array_unique($ndemeurNjoka);
      $ndemeurReligion = array_unique($ndemeurReligion);
      $ndemeurMode = array_unique($ndemeurMode);
      $ndemeurAmour = array_unique($ndemeurAmour);
      $ndemeurKwatt = array_unique($ndemeurKwatt);
 
      $listeComCarriere = 0;
      if (isset ($listeNdemsCarriere) ){
        foreach ($listeNdemsCarriere as $key => $value) {
           $listeComCarriere = $listeComCarriere + sizeof($em->getRepository('NNPPlatformBundle:Commentaire')
                     ->findByNdem($value->getId()));
        }
      }

      $listeComNjoka = 0;
      if (isset ($listeNdemsNjoka) ){
        foreach ($listeNdemsNjoka as $key => $value) {
           $listeComNjoka = $listeComNjoka + sizeof($em->getRepository('NNPPlatformBundle:Commentaire')
                     ->findByNdem($value->getId()));
        }
      }

      $listeComReligion = 0;
      if (isset ($listeNdemsReligion) ){
        foreach ($listeNdemsReligion as $key => $value) {
           $listeComReligion = $listeComReligion + sizeof($em->getRepository('NNPPlatformBundle:Commentaire')
                     ->findByNdem($value->getId()));
        }
      }

      $listeComMode = 0;
      if (isset ($listeNdemsMode) ){
        foreach ($listeNdemsMode as $key => $value) {
           $listeComMode = $listeComMode + sizeof($em->getRepository('NNPPlatformBundle:Commentaire')
                     ->findByNdem($value->getId()));
        }
      }

      $listeComAmour = 0;
      if (isset ($listeNdemsAmour) ){
        foreach ($listeNdemsAmour as $key => $value) {
           $listeComAmour = $listeComAmour + sizeof($em->getRepository('NNPPlatformBundle:Commentaire')
                     ->findByNdem($value->getId()));
        }
      }

      $listeComKwatt = 0;
      if (isset ($listeNdemsKwatt) ){
        foreach ($listeNdemsKwatt as $key => $value) {
           $listeComKwatt = $listeComKwatt + sizeof($em->getRepository('NNPPlatformBundle:Commentaire')
                     ->findByNdem($value->getId()));
        }
      }

      $maxCom = max(sizeof($listeNdemsCarriere).'-carriere', sizeof($listeNdemsNjoka).'-njoka', sizeof($listeNdemsReligion).'-religion', sizeof($listeNdemsMode).'-mode', sizeof($listeNdemsAmour).'-amour', sizeof($listeNdemsKwatt).'-kwatt' ); 

      $tabMaxCom = explode('-', $maxCom);
      $categorieMax = $tabMaxCom[1];

    	$content = $this->get('templating')->render('NNPPlatformBundle:Homepage:index.html.twig', 
        array(
          'listeNdemsCarriere' => $listeNdemsCarriere,
          'listeNdemsNjoka' => $listeNdemsNjoka,
          'listeNdemsReligion' => $listeNdemsReligion,
          'listeNdemsMode' => $listeNdemsMode,
          'listeNdemsAmour' => $listeNdemsAmour,
          'listeNdemsKwatt' => $listeNdemsKwatt,
          'listeComCarriere'=>$listeComCarriere,
          'listeComNjoka'=>$listeComNjoka,
          'listeComReligion'=>$listeComReligion,
          'listeComMode'=>$listeComMode,
          'listeComAmour'=>$listeComAmour,
          'listeComKwatt'=>$listeComKwatt,
          'maxNdem' => $categorieMax,
          'ndemeurCarriere'=> $ndemeurCarriere,
          'ndemeurNjoka'=> $ndemeurNjoka,
          'ndemeurReligion'=> $ndemeurReligion,
          'ndemeurMode'=> $ndemeurMode,
          'ndemeurAmour'=> $ndemeurAmour,
          'ndemeurKwatt'=> $ndemeurKwatt
          ));
    	return new Response($content);
    }

    public function presentationAction()
    {
    	$content = $this->get('templating')->render('NNPPlatformBundle:Homepage:presentation.html.twig');
    	return new Response($content);
    }

    public function ndemVisiteAction(Request $request)
    {
        $idVisite = $request->query->get('idVisite');
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('NNPPlatformBundle:Ndem');

        $listeNdem = $repository->findByUser($idVisite);

        $userVisite = $em->getRepository('NNPPlatformBundle:User')
                   ->findOneById($idVisite); 

        $content = $this->get('templating')->render('NNPPlatformBundle:Homepage:ndemVisite.html.twig', array('ndems'=> $listeNdem, 'userVisite'=> $userVisite));
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
        $em = $this->getDoctrine()->getManager();
        $idfollower = $request->query->get('idAFollow');

        if ($idfollower){
          $newfollower = new Follower();
          $newfollower->setIdFollower($idfollower);
          $newfollower->setUser($this->getUser());
          $em->persist($newfollower);
          $em->flush();
        }

        $repository = $em->getRepository('NNPPlatformBundle:Ndem');
        $ndem = $repository->find($id);

        $repoFollow = $em->getRepository('NNPPlatformBundle:Follower');
        $followersUser = $repoFollow->findByUser($this->getUser());
        $statutFollow = 0;
        foreach ($followersUser as $key => $value) {
          if ($value->getIdFollower() == $ndem->getUser()->getId()) {
            $statutFollow = 1;
          }
        }

        $followersAuteur = sizeof($repoFollow->findByIdFollower($ndem->getUser()->getId()));


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

          //$request->getSession()->getFlashBag()->add('notice', 'Merci pour votre commentaire.');

          return $this->redirectToRoute('nnp_platform_leNdem', array('id'=>$id));
        }

        $repoComment = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('NNPPlatformBundle:Commentaire')
        ;
        $listeComments = $repoComment->findByNdem($ndem->getId());

        $nbrCoach = 0;
        foreach ($listeComments as $key => $value) {
          if ($value->getUser()->getProfil() == 'COACH') {
            $nbrCoach++ ;
          }
        }

        $content = $this->get('templating')->render('NNPPlatformBundle:Homepage:leNdem.html.twig', array('nbrCoach'=>$nbrCoach,'ndem'=> $ndem,'comments'=>$listeComments,'form' => $form->createView(),'statutFollow'=> $statutFollow, 'followersAuteur' => $followersAuteur));
        return new Response($content);
    }

    public function profilVisiteAction(Request $request)
    {
        $idVisiteur = $request->query->get('idVisiteur');
        $em = $this->getDoctrine()->getManager(); 
        $listeNdem = $em->getRepository('NNPPlatformBundle:Ndem')->findByUser($idVisiteur);
        $nbrNdem = sizeof($listeNdem);

        $listeCom = $em->getRepository('NNPPlatformBundle:Commentaire')->findByUser($idVisiteur);
        $nbrCom = sizeof($listeCom);

        $user = $em->getRepository('NNPPlatformBundle:User')
                   ->findOneBy(array('id'=>$idVisiteur)); 

        $repoFollow = $em->getRepository('NNPPlatformBundle:Follower');
        $followersUserRepo = $em->getRepository('NNPPlatformBundle:User');
        $followersUser = array();
        $followersList = $repoFollow->findByIdFollower($user);//

        foreach ($followersList as $key => $value) {
          $follower = $followersUserRepo->findOneBy(array('id'=>$value->getUser()->getId()));
          $followersUser[] = $follower;
        }//var_dump($followersUser); exit();

        $content = $this->get('templating')->render('NNPPlatformBundle:Homepage:profilVisite.html.twig', array('nbrNdem'=>$nbrNdem, 'nbrCom'=>$nbrCom,'idVisiteur' => $idVisiteur,'user'=>$user, 'followers' => $followersUser));
        return new Response($content);
    }

    public function profilAction(Request $request)
    {
        $idVisiteur = $request->query->get('idVisiteur');
        $em = $this->getDoctrine()->getManager(); 
        $listeNdem = $em->getRepository('NNPPlatformBundle:Ndem')->findByUser($this->getUser());
        $nbrNdem = sizeof($listeNdem);

        $listeCom = $em->getRepository('NNPPlatformBundle:Commentaire')->findByUser($this->getUser());
        $nbrCom = sizeof($listeCom);


        $user = $em->getRepository('NNPPlatformBundle:User')
                   ->find($this->getUser()->getId()); 

        $repoFollow = $em->getRepository('NNPPlatformBundle:Follower');
        $followersUserRepo = $em->getRepository('NNPPlatformBundle:User');
        $followersUser = array();
        $followersList = $repoFollow->findByIdFollower($user);//

        foreach ($followersList as $key => $value) {
          $follower = $followersUserRepo->findOneBy(array('id'=>$value->getUser()->getId()));
          $followersUser[] = $follower;
        }//var_dump($followersUser); exit();

        $content = $this->get('templating')->render('NNPPlatformBundle:Homepage:profil.html.twig', array('nbrNdem'=>$nbrNdem, 'nbrCom'=>$nbrCom, 'followers' => $followersUser));
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

          //$request->getSession()->getFlashBag()->add('notice', 'Ndem bien enregistrée.');

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

        return $this->redirectToRoute('nnp_platform_profil');
      }

      $content = $this->get('templating')->render('NNPPlatformBundle:Homepage:modifierPassword.html.twig', array('form' => $form->createView()));
      return new Response($content);

    }

    public function listeAction(Request $request)
    { 

        $ndemPost = new Ndem();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $ndemPost)
          ->add('categories')
          ->add('texte',   TextareaType::class,array('attr'=>array('placeholder'=>'Ecrire un nouveau ndem')))
          ->add('save', SubmitType::class, array('label'=>'Poster'))
        ;
        $form = $formBuilder->getForm();

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

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) { 
        //var_dump($form->getData()); exit();

          $ndemPost->setUser($this->getUser());
          $ndemPost->setTitre('New post');

          $em = $this->getDoctrine()->getManager();
          $em->persist($ndemPost);
          $em->flush();

          //$request->getSession()->getFlashBag()->add('notice', 'Ndem bien enregistrée.');

          return $this->redirectToRoute('nnp_platform_liste', array('nom'=>$categorie));
        }

        $content = $this->get('templating')->render('NNPPlatformBundle:Homepage:liste.html.twig', array('listeNdems' => $listeNdems,'categorie'=> $categorie, 'form'=>$form->createView() ));
        return new Response($content);

    }
}
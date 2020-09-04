<?php

namespace App\Controller;

use DateTime;
use App\Entity\Disc;
use App\Entity\News;
use App\Entity\User;
use App\Form\NewsType;
use App\Form\UserType;
use App\Entity\Artists;
use App\Entity\Musicians;
use App\Form\ChangeMailType;
use App\Entity\NewContribution;
use App\Form\ChangePasswordType;
use Symfony\Component\Form\FormError;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/user/list", name="admin_user_list")
     * @isGranted("ROLE_MODERATOR")
     */
    public function adminUserList(Request $request, PaginatorInterface $paginator)
    {
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $dataUsers = $userRepo->findBy([], ['id' => 'DESC']);

        $users = $paginator->paginate(
            $dataUsers,
            $request->query->getInt('page', 1),
            10
        );
        
        return $this->render('admin/userList.html.twig', [
            'users' => $users,
            'currantPage' => 'userAdmin'
        ]);
    }

    /**
     * @Route("/admin/userProfil/{id}", name="admin_user_profil")
     * @isGranted("ROLE_MODERATOR")
     * 
     */
    public function adminUserProfil($id)
    {
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepo->findOneBy(['id' => $id]);
        
        return $this->render('admin/userProfil.html.twig', [
            'user' => $user,
            'currantPage' => 'userAdmin'
        ]);
    }

        /**
     * @Route("/admin/userProfil/edit/{id}", name="admin_user_prodil_edit")
     * @isGranted("ROLE_MODERATOR")
     * 
     */
    public function adminUserProfilEdit($id, Request $request, UserPasswordEncoderInterface $passwordEncoder, ValidatorInterface $validator)
    {
        // Creation Password form
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepo->findOneBy(['id' => $id]);
        $oldMail = $user->getEmail();
        $changePass = $this->createForm(ChangePasswordType::class, $user);
        $changePass->handleRequest($request);

        // Creation Email form
        $changeMail = $this->createForm(ChangeMailType::class, $user);
        $changeMail->handleRequest($request);

        $changeUser = $this->createForm(UserType::class, $user);
        $changeUser->handleRequest($request);
        $oldRole;
        foreach ($user->getUserRole() as $value) {
            $oldRole = $value;
        }
      

        // Call DB
        $em = $this->getDoctrine()->getManager();

        if($changePass->isSubmitted()){

            if($changePass->getName() == 'change_password'){
                
                $oldPassword = $changePass->get('oldPassword')->getData();
                

                if (!$passwordEncoder->isPasswordValid($user, $oldPassword)) {
                    $changePass->get('oldPassword')->addError(new FormError('Ancien mot de passe incorrect'));
                    $this->addFlash('errorDisplay', '');
                }

                if ($changePass->get('newPassword')->get('first')->getData() != $changePass->get('newPassword')->get('second')->getData()){
                    $changePass->get('newPassword')->get('second')->addError(new FormError('Votre nouveau mot de passe n\'es pas identique.'));
                    $this->addFlash('errorDisplay', '');                   

                }

                if($changePass->get('newPassword')->get('first')->getData() == $oldPassword){
                    $changePass->get('oldPassword')->addError(new FormError('Votre nouveau mot de passe ne peut pas etre identique a votre ancien mot de passe.'));
                    $this->addFlash('errorDisplay', '');
                }

                if($changePass->isSubmitted() && $changePass->isValid()){
                    $newPass = $passwordEncoder->encodePassword($user, $changePass->get('newPassword')->getData());
                    $user->setPassword($newPass);
                    $em->persist($user);
                    $em->flush();
                    $this->addFlash('passChange', 'Vous avez changé de mot de passe');
                    return $this->redirectToRoute('admin_user_list');
                }

                
            }

            
            /* if($changeMail->getName() == 'change_mail') */
        }

        if($changeMail->isSubmitted()){

            if($changeMail->getName() == 'change_mail'){

                $newEmail=$changeMail->getData()->getEmail();
                $emailConstraint = new Assert\Email();
                $errors = $validator->validate($newEmail, $emailConstraint);
                if (count($errors) !== 0) {
                    $changeMail->get('email')->addError(new FormError('Votre email n\'es pas valide'));
                    $user->setEmail($oldMail);
                }
                
                if($changeMail->isSubmitted() && $changeMail->isValid()){
                    $user->setEmail($newEmail);
                    $em->persist($user);
                    $em->flush();
                    $this->addFlash('passChange', 'Vous avez changé votre Email');
                    return $this->redirectToRoute('admin_user_list');
                }

            
            }
        }

        if($changeUser->isSubmitted()){


            if($changeUser->isSubmitted() && $changeUser->isValid()){
                $user->removeUserRole($oldRole);
                $user->addUserRole($changeUser->get('userRole')->getData());
                $em->persist($user);
                $em->flush();
                $this->addFlash('passChange', 'Vous avez changé votre Email');
                return $this->redirectToRoute('admin_user_list');
            }
        }


        return $this->render('admin/userProfilEdit.html.twig', [
            'controller_name' => 'UserController',
            'name' => $user->getUsername(),
            'changePass' => $changePass->createView(),
            'changeMail' => $changeMail->createView(),
            'changeUser' => $changeUser->createView(),
            'currantPage' => 'userAdmin'
        ]);
    }

    /**
     * @Route("/admin/userProfil/delete/{id}", name="admin_user_profil_delete")
     * @isGranted("ROLE_MODERATOR")
     * 
     */
    public function adminUserProfilDelete($id)
    {
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepo->findOneBy(['id' => $id]);


        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        
        return $this->redirectToRoute('admin_user_list');
    }

    /**
     * @Route("/admin/artists/list", name="admin_artists_list")
     */
    public function adminArtistsList(Request $request, PaginatorInterface $paginator)
    {
        $artistsRepo = $this->getDoctrine()->getRepository(Artists::class);
        $dataArtists = $artistsRepo->findBy([], ['id' => 'DESC']);

        $artists = $paginator->paginate(
            $dataArtists,
            $request->query->getInt('page', 1),
            10
        );
        
        return $this->render('admin/artistsList.html.twig', [
            'artists' => $artists,
            'currantPage' => 'artistAdmin'
        ]);
    }

    /**
     * @Route("/admin/artist/delete/{id}", name="admin_artist_delete")
     */
    public function adminArtistDelete($id)
    {
        $artistsRepo = $this->getDoctrine()->getRepository(Artists::class);
        $artist = $artistsRepo->findOneBy(['id' => $id]);


        $em = $this->getDoctrine()->getManager();
        $em->remove($artist);
        $em->flush();
        
        return $this->redirectToRoute('admin_artists_list');
    }

    /**
     * @Route("/admin/musicians/list", name="admin_musicians_list")
     */
    public function adminMusiciansList(Request $request, PaginatorInterface $paginator)
    {
        $musiciansRepo = $this->getDoctrine()->getRepository(Musicians::class);
        $dataMusicians = $musiciansRepo->findBy([], ['id' => 'DESC']);

        $musicians = $paginator->paginate(
            $dataMusicians,
            $request->query->getInt('page', 1),
            10
        );
        
        return $this->render('admin/musiciansList.html.twig', [
            'musicians' => $musicians,
            'currantPage' => 'musicianAdmin'
        ]);
    }

    /**
     * @Route("/admin/musician/delete/{id}", name="admin_musician_delete")
     */
    public function adminMusicianDelete($id)
    {
        $musiciansRepo = $this->getDoctrine()->getRepository(Musicians::class);
        $musicians = $musiciansRepo->findOneBy(['id' => $id]);


        $em = $this->getDoctrine()->getManager();
        $em->remove($musicians);
        $em->flush();
        
        return $this->redirectToRoute('admin_musicians_list');
    }

    /**
     * @Route("/admin/discs/list", name="admin_discs_list")
     */
    public function adminDiscsList(Request $request, PaginatorInterface $paginator)
    {
        $discsRepo = $this->getDoctrine()->getRepository(Disc::class);
        $dataDiscs = $discsRepo->findBy([], ['id' => 'DESC']);

        $discs = $paginator->paginate(
            $dataDiscs,
            $request->query->getInt('page', 1),
            10
        );
        
        return $this->render('admin/discsList.html.twig', [
            'discs' => $discs,
            'currantPage' => 'discAdmin'
        ]);
    }

    /**
     * @Route("/admin/disc/delete/{id}", name="admin_disc_delete")
     */
    public function adminDiscDelete($id)
    {
        $discRepo = $this->getDoctrine()->getRepository(Disc::class);
        $disc = $discRepo->findOneBy(['id' => $id]);


        $em = $this->getDoctrine()->getManager();
        $em->remove($disc);
        $em->flush();
        
        return $this->redirectToRoute('admin_discs_list');
    }

    /**
     * @Route("/admin/news/list", name="admin_news_list")
     */
    public function adminNewsList(Request $request, PaginatorInterface $paginator)
    {
        $newsRepo = $this->getDoctrine()->getRepository(News::class);
        $dataNews = $newsRepo->findBy([], ['creationDate' => 'DESC']);

        $news = $paginator->paginate(
            $dataNews,
            $request->query->getInt('page', 1),
            10
        );
        
        return $this->render('admin/newsList.html.twig', [
            'news' => $news,
            'currantPage' => 'newsAdmin'
        ]);
    }

    /**
     * @Route("/admin/news/delete/{id}", name="admin_news_delete")
     *  @IsGranted("ROLE_EDITOR")
     */
    public function adminNewsDelete($id)
    {
        $newsRepo = $this->getDoctrine()->getRepository(News::class);
        $news = $newsRepo->findOneBy(['id' => $id]);


        $em = $this->getDoctrine()->getManager();
        $em->remove($news);
        $em->flush();
        
        return $this->redirectToRoute('admin_news_list');
    }

    /**
     * @Route("/news/add", name="news_add")
     * @IsGranted("ROLE_EDITOR")
     */
    public function newsAdd(Request $request)
    {
        $news = new News;
        $date = new \DateTime('now');
        $news->setAuthor($this->getUser()->getUsername());
        $news->setCreationDate($date);

        $form = $this->createForm(NewsType::Class, $news);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            if($form->isSubmitted() && $form->isValid()){

                $em = $this->getDoctrine()->getManager();
                $em->persist($news);
                $em->flush();

                return $this->redirectToRoute('admin_news_list');
            }
        }


        return $this->render('admin/newsAdd.html.twig',
        ['form' => $form->createView(),
        'currantPage' => 'makeNews']);
    }

    /**
     * @Route("/news/edit/{id}", name="news_edit")
     * @IsGranted("ROLE_EDITOR")
     */
    public function newsEdit(Request $request, int $id)
    {
        $repoNews = $this->getDoctrine()->getRepository(News::class);
        $news = $repoNews->findOneById($id);
        $date = new \DateTime('now');
        $news->setUpdateAuthor($this->getUser()->getUsername());
        $news->setUpdateDate($date);

        $form = $this->createForm(NewsType::Class, $news);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            if($form->isSubmitted() && $form->isValid()){

                $em = $this->getDoctrine()->getManager();
                $em->persist($news);
                $em->flush();

                return $this->redirectToRoute('admin_news_list');
            }
        }


        return $this->render('admin/newsAdd.html.twig',
        ['form' => $form->createView(),
        'currantPage' => 'makeNews']);
    }

    /**
     * @Route("/admin/contribution/list", name="admin_contribution_list")
     */
    public function adminContributionList(Request $request, PaginatorInterface $paginator)
    {
        $contribRepo = $this->getDoctrine()->getRepository(NewContribution::class);
        $dataContrib = $contribRepo->findBy(['isVerify' => 0], ['id' => 'DESC']);

        $contribs = $paginator->paginate(
            $dataContrib,
            $request->query->getInt('page', 1),
            10
        );
        
        return $this->render('admin/contribList.html.twig', [
            'contribs' => $contribs,
        ]);
    }

}

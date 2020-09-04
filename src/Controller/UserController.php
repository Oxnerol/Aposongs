<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangeMailType;
use App\Form\ChangePasswordType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
/**
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/user", name="profil_user")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, ValidatorInterface $validator)
    {
        // Creation Password form
        $user = new User();
        $user = $this->getUser();
        $oldMail = $user->getEmail();
        $changePass = $this->createForm(ChangePasswordType::class, $user);
        $changePass->handleRequest($request);

        // Creation Email form
        $changeMail = $this->createForm(ChangeMailType::class, $user);
        $changeMail->handleRequest($request);
        

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
                    return $this->redirectToRoute('profil_user');
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
                    return $this->redirectToRoute('profil_user');
                }

            
            }
        }


        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'changePass' => $changePass->createView(),
            'changeMail' => $changeMail->createView(),
            'currantPage' => 'profile'
        ]);
    }

}


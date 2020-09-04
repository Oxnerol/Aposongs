<?php

namespace App\Controller;

use App\Entity\Musicians;
use App\Form\MusiciansType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MusicianController extends AbstractController
{


    /**
     * @Route("/musician/search/{search}", name="musicians_search")
     * 
     */
    public function musiciansSearch($search){

        $repoMusicians = $this->getDoctrine()->getRepository(Musicians::class);

        if($search != '')
        {
            $musician = $repoMusicians->findByLikeMusicianFirstName($search);
            $musician = $musician + $repoMusicians->findByLikeMusicianLastName($search);
            $musician = $musician + $repoMusicians->findByLikeMusicianNickname($search);

        }

        $view = $this->render('musician/_list_search.html.twig', 
        ['musicians' => $musician,
        'currantPage' => 'musician']);

       return new Response ($view->getContent());



    }

        /**
     * @Route("/musician/read/{id}", name="musician_read")
     */
    public function artist($id){

        $repoMusicians = $this->getDoctrine()->getRepository(Musicians::class);

        $id = str_replace('-', ' ', $id);

        $musician = $repoMusicians->findOneBy(['id' => $id]);


        return $this->render('musician/musician.html.twig', 
            ['musician' => $musician,
            'currantPage' => 'musician']);

    }

    /**
     * @Route("/musician/add", name="musician_add") 
     * @IsGranted("ROLE_USER")
     */
    public function artistAdd(Request $request, SluggerInterface $slugger){

        $musician = new Musicians;
        $form = $this->createForm(MusiciansType::Class, $musician);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            $born = $form->get('born')->getData();
            $death = $form->get('death')->getData();

            if($born > $death){
                $form->get('death')->addError(new FormError('La date decces ne peut pas etre avant la date de naissance'));

            }

            $img = $form->get('musicianImg')->getData();
            if($img){
                if(!in_array($img->guessExtension(), array('jpg', 'JPG', 'JPEG', 'jpeg', 'PNG', 'png', 'GIF', 'gif'))){
                    $form->get('musicianImg')->addError(new FormError('Uniquement les fichiers .jpg .png et .gif sont accepté'));
                }
            }    

            if($form->isSubmitted() && $form->isValid()){

                if($img){
                    $originalFileName = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                
                    $safeFilename = $slugger->slug($originalFileName);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$img->guessExtension();
                    
                    try{
                        $img->move(
                            $this->getParameter('musician_directory'),
                            $newFilename
                        );
    
                    }catch(FileException $e){
    
                    }

                    $musician->setMusicianImg($newFilename);
                }
 
                $em = $this->getDoctrine()->getManager();
                $em->persist($musician);
                $em->flush();    
                return $this->redirectToRoute('musicians');
            }
        }



        return $this->render('musician/addMusician.html.twig',
                            ['form' => $form->createView(),
                            'currantPage' => 'musician']);
    }

    /**
     * @Route("/musician/edit/{id}", name="musician_edit") 
     * @IsGranted("ROLE_USER")
     */
    public function artistEdit($id, Request $request, SluggerInterface $slugger){

        $repoMusician = $this->getDoctrine()->getRepository(Musicians::class);
        $musician = $repoMusician->findOneBy(['id' => $id]);
        $form = $this->createForm(MusiciansType::Class, $musician);
        $form->handleRequest($request);

        $imgFile = $this->getParameter('musician_directory').'/'.$musician->getMusicianImg();

        if ($form->isSubmitted()) {


            $born = $form->get('born')->getData();
            $death = $form->get('death')->getData();

            if($born > $death){
                $form->get('death')->addError(new FormError('La date decces ne peut pas etre avant la date de naissance'));
            }

            $img = $form->get('musicianImg')->getData();
            if($img){
                if(!in_array($img->guessExtension(), array('jpg', 'JPG', 'JPEG', 'jpeg', 'PNG', 'png', 'GIF', 'gif'))){
                    $form->get('musicianImg')->addError(new FormError('Uniquement les fichiers .jpg .png et .gif sont accepté'));
                }
            }    

            if($form->isSubmitted() && $form->isValid()){

                if($img){
                    $originalFileName = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                
                    $safeFilename = $slugger->slug($originalFileName);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$img->guessExtension();
                    
                    try{
                        $img->move(
                            $this->getParameter('musician_directory'),
                            $newFilename
                        );
    
                    }catch(FileException $e){
    
                    }

                    $musician->setMusicianImg($newFilename);
                }
 
                $em = $this->getDoctrine()->getManager();
                $em->persist($musician);
                $em->flush();
    
                return $this->redirectToRoute('musicians');
            }
        }



        return $this->render('musician/editMusician.html.twig',
                            ['form' => $form->createView(),
                            'img' => $musician->getMusicianImg(),
                            'alt' => $musician->getAltImg(),
                            'first' => $musician->getFirstName(),
                            'last' => $musician->getLastName(),
                            'nick' => $musician->getNickname(),
                            'currantPage' => 'musician']);
    }


    /**
     * @Route("/musician/{page}", name="musicians", defaults={"page": 0})
     * @param integer $page
     * 
     */
    public function musicians(int $page, Request $request)
    {

        $repoMusician = $this->getDoctrine()->getRepository(Musicians::class);
        $changePageFlag;
        $musicians = $repoMusician->findBy([], ['firstName' => 'ASC'], 13, 12*$page);
        $lastMusicians = $repoMusician->findBy([], ['id' => 'DESC'], 5, 0);

        if(count($musicians) == 13)
        {
            $changePageFlag = true;
            array_splice($musicians,-1,1);

        }
        else{
            $changePageFlag = false;
        }

        

        if($request->isXmlHttpRequest()){
            return $this->render('musician/_list_pagination.html.twig', 
            ['musicians' => $musicians,
            'lastMusicians' => $lastMusicians,
            'nPage' => $page,
            'changePageFlag' => $changePageFlag,
            'currantPage' => 'musician']);
        }else{
            return $this->render('musician/musiciansList.html.twig', 
            ['musicians' => $musicians,
            'lastMusicians' => $lastMusicians,
            'nPage' => $page,
            'changePageFlag' => $changePageFlag,
            'currantPage' => 'musician']);
        }
        

    }
}

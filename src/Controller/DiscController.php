<?php

namespace App\Controller;

use App\Entity\Disc;
use App\Form\DiscType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DiscController extends AbstractController
{


        
    /**
     * @Route("/disc/search/{search}", name="disc_search")
     * 
     */
    public function artistsSearch($search = ''){

        $repoDisc = $this->getDoctrine()->getRepository(Disc::class);

        if($search != '')
        {
            $discs = $repoDisc->findByLikeDisc($search);


        }
        else{

            $discs = $repoDisc->findBy([], ['name' => 'ASC']);
        }

        $view = $this->render('disc/_list_search.html.twig', 
        ['discs' => $discs,
        'currantPage' => 'disc']);

       return new Response ($view->getContent());



    }

        /**
     * @Route("/disc/read/{id}", name="disc_read")
     */
    public function disc($id){

        $repoDisc = $this->getDoctrine()->getRepository(Disc::class);

        $id = str_replace('-', ' ', $id);

        $disc = $repoDisc->findOneBy(['id' => $id]);


        return $this->render('disc/disc.html.twig', 
            ['disc' => $disc,
            'currantPage' => 'disc']);

    }

    /**
     * @Route("/disc/add", name="disc_add") 
     * @IsGranted("ROLE_USER")
     */
    public function discAdd(Request $request, SluggerInterface $slugger){

        $disc = new Disc;
        $form = $this->createForm(DiscType::Class, $disc);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            $img = $form->get('cover')->getData();

            if(!in_array($img->guessExtension(), array('jpg', 'JPG', 'JPEG', 'jpeg', 'PNG', 'png', 'GIF', 'gif'))){
                $form->get('cover')->addError(new FormError('Uniquement les fichiers .jpg .png et .gif sont accepté'));
            }

            

            if($form->isSubmitted() && $form->isValid()){

                $originalFileName = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                
                $safeFilename = $slugger->slug($originalFileName);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img->guessExtension();
                
                try{
                    $img->move(
                        $this->getParameter('disc_directory'),
                        $newFilename
                    );

                }catch(FileException $e){

                }
                
                $disc->setCover($newFilename);
                $em = $this->getDoctrine()->getManager();
                $em->persist($disc);
                $em->flush();
    
                return $this->redirectToRoute('disc');
            }
        }




        return $this->render('disc/addDisc.html.twig',
                            ['form' => $form->createView(),
                            'currantPage' => 'disc']);
    }

    /**
     * @Route("/disc/edit/{id}", name="disc_edit") 
     * @IsGranted("ROLE_USER")
     */
    public function discEdit($id, Request $request, SluggerInterface $slugger){

        $repoDisc =$this->getDoctrine()->getRepository(Disc::class);
        $disc = $repoDisc->findOneBy(['id' => $id]);

        $form = $this->createForm(DiscType::Class, $disc);
        $form->handleRequest($request);

        $imgFile = $this->getParameter('disc_directory').'/'.$disc->getCover();

        if($form->isSubmitted()){

            $img = $form->get('cover')->getData();

            if($img){
                if(!in_array($img->guessExtension(), array('jpg', 'JPG', 'JPEG', 'jpeg', 'PNG', 'png', 'GIF', 'gif'))){
                    $form->get('cover')->addError(new FormError('Uniquement les fichiers .jpg .png et .gif sont accepté'));
                }
            }

            

            if($form->isSubmitted() && $form->isValid()){

                if($img){
                    $originalFileName = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                    
                    $safeFilename = $slugger->slug($originalFileName);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$img->guessExtension();
                    
                    try{
                        $img->move(
                            $this->getParameter('disc_directory'),
                            $newFilename
                        );

                    }catch(FileException $e){

                    }

                    $disc->setCover($newFilename);
                }
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($disc);
                $em->flush();
    
                return $this->redirectToRoute('disc');
            }
        }




        return $this->render('disc/editDisc.html.twig',
                            ['form' => $form->createView(), 
                            'discName' => $disc->getName(),
                            'img' => $disc->getCover(),
                            'alt' =>$disc->getAltImg(),
                            'currantPage' => 'disc']);
    }


    /**
     * @Route("/disc/{page}", name="disc", defaults={"page": 0})
     * @param integer $page
     */
    public function discs(int $page, Request $request)
    {

        $repoDisc = $this->getDoctrine()->getRepository(Disc::class);
        $changePageFlag;
        $discs = $repoDisc->findBy([], ['id' => 'ASC'], 13, 12*$page);
        $lastDiscs = $repoDisc->findBy([], ['id' => 'DESC'], 5, 0);

        if(count($discs) == 13)
        {
            $changePageFlag = true;
            array_splice($discs,-1,1);

        }
        else{
            $changePageFlag = false;
        }

        

        if($request->isXmlHttpRequest()){
            return $this->render('disc/_list_pagination.html.twig', 
            ['discs' => $discs,
            'lastDiscs' => $lastDiscs,
            'nPage' => $page,
            'changePageFlag' => $changePageFlag,
            'currantPage' => 'disc']);
        }else{
            return $this->render('disc/discList.html.twig', 
            ['discs' => $discs,
            'lastDiscs' => $lastDiscs,
            'nPage' => $page,
            'changePageFlag' => $changePageFlag,
            'currantPage' => 'disc']);
        }
        

    }
    
}

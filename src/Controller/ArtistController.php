<?php

namespace App\Controller;

use App\Entity\Disc;
use App\Entity\Link;
use App\Entity\Artists;
use App\Form\ArtistType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\NewContribution;

class ArtistController extends AbstractController
{

    
    /**
     * @Route("/artist/search/{search}", name="artist_search")
     * 
     */
    public function artistsSearch($search = ''){

        $repoArtists = $this->getDoctrine()->getRepository(Artists::class);

        if($search != '')
        {
            $artists = $repoArtists->findByLikeArtist($search);


        }
        else{

            $artists = $repoArtists->findBy([], ['name' => 'ASC']);
        }

        $view = $this->render('artist/_list_search.html.twig', 
        ['artists' => $artists,
        'currantPage' => 'artist']);

       return new Response ($view->getContent());

    }



    /**
     * @Route("/artist/read/{slug}", name="artist_read")
     * @param string $slug
     * 
     */
    public function artist(Artists $artist){
        
        $repoDisc = $this->getDoctrine()->getRepository(Disc::class);

        $discs = $repoDisc->getDiscByArtistId($artist->getId());


        return $this->render('artist/artist.html.twig', 
            ['artist' => $artist,
            'discs'=>$discs,
            'currantPage' => 'artist']);

    }

    /**
     * @Route("/artist/add", name="artist_add") 
     * @IsGranted("ROLE_USER")
     */
    public function addArtist(Request $request, SluggerInterface $slugger){

        $artist = new Artists;
        $form = $this->createForm(ArtistType::Class, $artist);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            
            
            if($form->get('bandActivityEnd')->getData() != null && $form->get('bandActivityStart')->getData() > $form->get('bandActivityEnd')->getData()){
                $form->get('bandActivityEnd')->addError(new FormError('La date de debut ne peut etre supérieure à la date de fin'));

            }

            
            $img = $form->get('logoImg')->getData();

            if(!in_array($img->guessExtension(), array('jpg', 'JPG', 'JPEG', 'jpeg', 'PNG', 'png', 'GIF', 'gif'))){
                $form->get('logoImg')->addError(new FormError('Uniquement les fichiers .jpg .png et .gif sont accepté'));
            }

            if($form->isSubmitted() && $form->isValid()){

                $originalFileName = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                
                $safeFilename = $slugger->slug($originalFileName);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img->guessExtension();
                
                try{
                    $img->move(
                        $this->getParameter('band_directory'),
                        $newFilename
                    );

                }catch(FileException $e){

                }

                $artist->setLogoImg($newFilename);
                $em = $this->getDoctrine()->getManager();
                $em->persist($artist);
                $em->flush();
    
                return $this->redirectToRoute('artist');
            }

            


        }


        return $this->render('artist/addArtist.html.twig',
                            ['form' => $form->createView(),
                            'currantPage' => 'artist']);

                   
    }

    /**
     * @Route("/artist/edit/{slug}", name="artist_edit") 
     * @IsGranted("ROLE_USER")
     */
    public function artistEdit(Artists $artist, Request $request, SluggerInterface $slugger){

        $repoArtist = $this->getDoctrine()->getRepository(Artists::class);
        $artist = $repoArtist->findOneBySlug($artist->getSlug());

        $form = $this->createForm(ArtistType::Class, $artist);
        $form->handleRequest($request);

        $imgFile = $this->getParameter('band_directory').'/'.$artist->getLogoImg();


         if($form->isSubmitted()){


            $startDate = $form->get('bandActivityStart')->getData();
            $endDate = $form->get('bandActivityEnd')->getData();

            if($form->get('bandActivityEnd')->getData() != null && $form->get('bandActivityStart')->getData() > $form->get('bandActivityEnd')->getData()){
                $form->get('bandActivityEnd')->addError(new FormError('La date de debut ne peut etre supérieure à la date de fin'));

            }

            $img = $form->get('logoImg')->getData();
            
            if($img){
                if(!in_array($img->guessExtension(), array('jpg', 'JPG', 'JPEG', 'jpeg', 'PNG', 'png', 'GIF', 'gif'))){
                    $form->get('logoImg')->addError(new FormError('Uniquement les fichiers .jpg .png et .gif sont accepté'));
                }
            }


            if($form->isSubmitted() && $form->isValid()){
                if($img){
                    $originalFileName = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                    
                    $safeFilename = $slugger->slug($originalFileName);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$img->guessExtension();
                    
                    try{
                        $img->move(
                            $this->getParameter('band_directory'),
                            $newFilename
                        );

                    }catch(FileException $e){

                    }

                    $artist->setLogoImg($newFilename);
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($artist);
                $em->flush();
    
                return $this->redirectToRoute('artist_read', ['slug' => $artist->getSlug()]);
            }

            


        }
        return $this->render('artist/editArtist.html.twig',
                            ['form' => $form->createView(), 
                            'bandName' => $artist->getName(),
                            'img' => $artist->getLogoImg(),
                            'alt' =>$artist->getAltImg(),
                            'currantPage' => 'artist']);

                   
    }

    
    /**
     * @Route("/artist/{page}", name="artist", defaults={"page": 0})
     * @param integer $page
     */
    public function artists(int $page, Request $request){

        $repoArtists = $this->getDoctrine()->getRepository(Artists::class);
        $changePageFlag;
        $artists = $repoArtists->findBy([], ['name' => 'ASC'], 13, 12*$page);
        $lastArtists = $repoArtists->findBy([], ['id' => 'DESC'], 5, 0);

        if(count($artists) == 13)
        {
            $changePageFlag = true;
            array_splice($artists,-1,1);

        }
        else{
            $changePageFlag = false;
        }

        

        if($request->isXmlHttpRequest()){
            return $this->render('artist/_list_pagination.html.twig', 
            ['artists' => $artists,
            'lastArtists' => $lastArtists,
            'nPage' => $page,
            'changePageFlag' => $changePageFlag,
            'currantPage' => 'artist']);
        }else{
            return $this->render('artist/artistList.html.twig', 
            ['artists' => $artists,
            'lastArtists' => $lastArtists,
            'nPage' => $page,
            'changePageFlag' => $changePageFlag,
            'currantPage' => 'artist']);
        }
        

    }

}

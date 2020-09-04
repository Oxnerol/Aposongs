<?php

namespace App\Controller;

use App\Entity\Link;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DiscoverBandController extends AbstractController
{
    /**
     * @Route("/discover", name="discover_band")
     */
    public function index()
    {
        $test = $this->randomTrack();

        return $this->render('discover_band/index.html.twig', [
            'currantPage' => 'discovery',
        ]);
    }

    /**
     * Search a link in a DB and play preview 
     * @Route("/discover/randomTrack", name="random_Track")
     */
    public function randomTrack()
    {
        /* load a random deezer link in DB*/
        $repoLink = $this->getDoctrine()->getRepository(Link::class);
        $link = $repoLink->findRandomDeezerLink();

        if($link)
        {

            $explodeUrl = explode('artist/', $link['url']); // https://www.deezer.com/fr/artist/1471724

            /*put the id of the band in the url address */
            $jsonArtiste = file_get_contents("https://api.deezer.com/artist/".$explodeUrl[1]."/albums");
            $decodeJsonArtiste = json_decode($jsonArtiste);
            $tableauAlbums = $decodeJsonArtiste->data;

            /* if there is a next page in the list it is retrieved and pushed into an array */
        
            while(isset($decodeJsonArtiste->next)){
            
                $jsonArtiste = file_get_contents($decodeJsonArtiste->next);
                $decodeJsonArtiste = json_decode($jsonArtiste);
            
                foreach ($decodeJsonArtiste->data as $key){
                    array_push($tableauAlbums, $key);
                }
            
            }
            
            /* generates a number in relation to the number of albums and retrieve the id of the chosen album */
            
            $numeroAleatoire = rand(0, count($tableauAlbums)-1);
            $idAlbum=$tableauAlbums[$numeroAleatoire]->id;
            
            /* album tracklist */
            
            $jsonMusique = file_get_contents("https://api.deezer.com/album/$idAlbum/tracks");
            $decodeJsonMusique = json_decode($jsonMusique);
            $tableauMusique = $decodeJsonMusique->data;

            /* if there is a next page in the list it is retrieved and pushed into an array */

            while(isset($decodeJsonMusique->next)){
        
                $jsonMusique = file_get_contents($decodeJsonMusique->next);
                $decodeJsonMusique = json_decode($jsonMusique);
            
                foreach ($decodeJsonMusique->data as $key){
                    array_push($tableauMusique, $key);
                }
        
            }
            
            
            /* generate a number in relation to the number of tracks and retrieve the id of the chosen track */
            
            $nombreMusique = $decodeJsonMusique->total-1;
            $numeroAleatoire = rand(0, $nombreMusique);

            $musiqueAleatoire = $tableauMusique[$numeroAleatoire];
            
            return new JsonResponse($musiqueAleatoire);
        }

        return new JsonResponse("false");

        

        
    }
 
}

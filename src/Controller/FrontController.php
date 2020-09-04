<?php

namespace App\Controller;

use App\Entity\Disc;
use App\Entity\News;
use App\Entity\Artists;
use App\Entity\HighlightIndex;
use App\Entity\NewContribution;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front")
     */
    public function index()
    {

        $repoHighlight = $this->getDoctrine()->getRepository(HighlightIndex::class);
        $highlight = $repoHighlight->findAll();

        $repoNews = $this->getDoctrine()->getRepository(News::class);
        $news = $repoNews->findBy([],['creationDate' => 'DESC'], 5);

        $repoNewContribution = $this->getDoctrine()->getRepository(NewContribution::class);
        $newContribution = $repoNewContribution->findBy(['contributionType' => 'add'],['id' => 'DESC'], 5);

        $discId;
        $artistId;
        $artist = null;
        $disc = null;

        foreach ($highlight as $value) {
            
            if($value->getName() == "artists"){
                $artistId = $value->getTargetId();
            }

            if($value->getName() == "disc"){
                $discId = $value->getTargetId();
            }
        }

        if(!empty($artistId) && !empty($discId))
        {
            $repoArtist = $this->getDoctrine()->getRepository(Artists::class);
            $artist = $repoArtist->findOneBy(['id' => $artistId]);

            $repoDisc = $this->getDoctrine()->getRepository(Disc::class);
            $disc = $repoDisc->findOneBy(['id' => $discId]);
        }

        return $this->render('front/index.html.twig', [
            'artist' => $artist,
            'disc' => $disc,
            'news' => $news,
            'newConts' => $newContribution,
            'currantPage' => 'acceuil'

        ]);
    }



    
}

<?php

namespace App\Controller;

use App\Entity\News;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewsController extends AbstractController
{
    /**
     * @Route("/news", name="news")
     */
    public function index(Request $request, PaginatorInterface $paginator){

        $repoNews = $this->getDoctrine()->getRepository(News::class);
        $dataNews = $repoNews->findBy([],['creationDate' => 'DESC'], 5);

        $news = $paginator->paginate(
            $dataNews,
            $request->query->getInt('page', 1),
            10
        );
        

        return $this->render('news/newsList.html.twig', [
            'news' => $news,
            'currantPage' => 'news'
        ]);
    }

    /**
     * @Route("/news/read/{id}", name="news_read")
     */
    public function newsRead (int $id = 0, Request $request)    {

        $repoNews = $this->getDoctrine()->getRepository(News::class);
        $news = $repoNews->findOneById($id);

        return $this->render('news/newsRead.html.twig', [
            'news' => $news,
            'currantPage' => 'news'
            
        ]);

    }

}

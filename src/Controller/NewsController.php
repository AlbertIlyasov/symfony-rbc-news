<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use App\Service\NewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    /**
     * @Route("/news", name="news")
     */
    public function index(NewsService $service, NewsRepository $newsRepo): Response
    {
        $service->parseLastNews();
        return $this->render('news/index.html.twig', [
            'newsItems' => $newsRepo->findAll(),
        ]);
    }

    /**
     * @Route("/news/{id}", name="news_view")
     */
    public function view(NewsRepository $newsRepo, int $id): Response
    {
        $news = $newsRepo->find($id);
        if (!$news) {
            //todo: redirect to page 404
            throw new NotFoundHttpException;
        }
        return $this->render('news/view.html.twig', [
            'news' => $news,
        ]);
    }
}

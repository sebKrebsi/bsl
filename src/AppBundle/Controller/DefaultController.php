<?php

namespace AppBundle\Controller;

use AppBundle\Admin\Controller\TeamMapTrait;
use AppBundle\Entity\File;
use AppBundle\Entity\News;
use AppBundle\Entity\Team;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    use TeamMapTrait;

    /**
     * @Route("/news", name="news")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newsAction(Request $request)
    {

        $query     = $this->getDoctrine()->getRepository(News::class)->getPublishedPostQuery();
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('default/news.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/post/{id}", name="single_post")
     * @param News $news
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function singlePostAction(News $news)
    {
        return $this->render('default/singlePost.html.twig', [
            'post' => $news
        ]);
    }

    /**
     * @Route("/", name="homepage")
     */
    public function teamsAction()
    {
        $teams   = $this->getDoctrine()->getRepository(Team::class)->getTeams();

        // replace this example code with whatever you need
        return $this->render('default/teams.html.twig', [
            'teams'    => $teams,
            'basePath' => $this->getParameter('base_path_download'),
            'teamMap'  => $this->fetchMap()
        ]);
    }

    /**
     * @Route("/imprint", name="imprint")
     */
    public function imprintAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/imprint.html.twig', [
        ]);
    }

    /**
     * @Route("/downloads", name="downloads")
     */
    public function downloadsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $files = $em->getRepository(File::class)->findAll();

        // replace this example code with whatever you need
        return $this->render('default/downloads.html.twig', [
            'files'    => $files,
            'basePath' => $this->getParameter('base_path_download')
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/contact.html.twig', [
        ]);
    }

    /**
     * @Route("/leagues", name="leagues")
     */
    public function leaguesAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/leagues.html.twig', [
        ]);
    }

    /**
     * @Route("/access-denied", name="accessDenied")
     */
    public function accessDeniedAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
        ]);
    }
}

<?php

namespace Tecnotek\RetoAprenderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Tecnotek\RetoAprenderBundle\Form\ContactType;

class NewsController extends Controller
{

    public function newsAction()
    {
        $this->get('google.analytics')->setCustomPageView('/news');
        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT news FROM RetoAprenderBundle:News news ORDER BY news.date";
        $query = $em->createQuery($dql)->setFirstResult(0)->setMaxResults(10);

        //$news = $em->getRepository('RetoAprenderBundle:News')->findAll();
        $news = $query->getResult();
        return $this->render('RetoAprenderBundle::news.html.twig', array(
            'news' => $news,
        ));
    }
}

<?php

namespace Tecnotek\RetoAprenderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Tecnotek\RetoAprenderBundle\Entity\News;

use Tecnotek\RetoAprenderBundle\Form\NewsFormType;

class NewsController extends Controller
{

    public function newsAction()
    {
        $this->get('google.analytics')->setCustomPageView('/news');
        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT news FROM RetoAprenderBundle:News news WHERE news.enabled = true ORDER BY news.date DESC";
        $query = $em->createQuery($dql)->setFirstResult(0)->setMaxResults(10);

        //$news = $em->getRepository('RetoAprenderBundle:News')->findAll();
        $news = $query->getResult();
        return $this->render('RetoAprenderBundle::news.html.twig', array(
            'news' => $news,
        ));
    }

    /* Admin Actions start */
    public function newsListAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT news FROM RetoAprenderBundle:News news ORDER BY news.date";
        $query = $em->createQuery($dql);

        $news = $query->getResult();
        return $this->render('RetoAprenderBundle::admin/news/list.html.twig', array(
            'news' => $news,
        ));
    }

    public function newsNewAction(){
        $entity = new News();
        $form   = $this->createForm(new NewsFormType(), $entity);
        return $this->render('RetoAprenderBundle:admin:news/new.html.twig', array('entity' => $entity,
            'form'   => $form->createView()));
    }

    public function newsSaveAction(){
        $entity  = new News();
        $request = $this->getRequest();
        $form    = $this->createForm(new NewsFormType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $entity->setUser($this->getUser());
            $entity->setLastUserEditor($this->getUser());
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('reto_aprender_admin_news',
                array('id' => $entity->getId())));
        } else {
            return $this->render('RetoAprenderBundle:admin:news/new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView()
            ));
        }
    }

    public function newsEditAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:News")->find($request->get('id'));
        if ( isset($entity) ) {
            $form   = $this->createForm(new NewsFormType(), $entity);
            return $this->render('RetoAprenderBundle:admin:news/edit.html.twig', array('entity' => $entity,
                'form'   => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('reto_aprender_admin_news'));
        }
    }

    public function newsUpdateAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:News")->find($request->get('id'));
        if ( isset($entity) ) {
            $form    = $this->createForm(new NewsFormType(), $entity);
            $form->bindRequest($request);

            if ($form->isValid()) {
                $entity->setLastUserEditor($this->getUser());
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('reto_aprender_admin_news'));
            } else {
                return $this->render('RetoAprenderBundle:admin:news/edit.html.twig', array(
                    'entity' => $entity, 'form'   => $form->createView()
                ));
            }
        } else {
            return $this->redirect($this->generateUrl('reto_aprender_admin_news'));
        }
    }

    public function newsDeleteAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("RetoAprenderBundle:News")->find( $id );
        if ( isset($entity) ) {
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('reto_aprender_admin_news'));
    }
    /* Admin Actions End */
}

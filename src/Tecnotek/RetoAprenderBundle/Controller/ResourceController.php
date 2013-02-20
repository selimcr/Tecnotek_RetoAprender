<?php

namespace Tecnotek\RetoAprenderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Tecnotek\RetoAprenderBundle\Entity\User;

class ResourceController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("RetoAprenderBundle:Topic")->find(1);
        return $this->render('RetoAprenderBundle:resources:index.html.twig', array('topic'=> $entity));
    }

    public function unitAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("RetoAprenderBundle:Unit")->find($id);
        return $this->render('RetoAprenderBundle:resources:unit.html.twig', array('unit'=> $entity));
    }

    public function activityAction($id)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->render('RetoAprenderBundle:Payment:payment.html.twig', array('activity'=> ""));
        }
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("RetoAprenderBundle:Activity")->find($id);
        $slides_name = "";
        $total_slides = 0;
        if($entity->getType() == 2){
            list($slides_name, $total_slides) = explode(",", $entity->getIncludeText(), 2);
        }
        return $this->render('RetoAprenderBundle:resources:activity.html.twig', array(
            'activity'=> $entity, 'slides_name' => $slides_name, 'slides_total' => $total_slides));
    }
}

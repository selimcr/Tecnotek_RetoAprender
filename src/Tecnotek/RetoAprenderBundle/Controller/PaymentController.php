<?php

namespace Tecnotek\RetoAprenderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends Controller
{

    public function indexAction()
    {
        return $this->render('RetoAprenderBundle:Payment:index.html.twig');
    }

    public function unitAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("RetoAprenderBundle:Unit")->find($id);
        return $this->render('RetoAprenderBundle:resources:unit.html.twig', array('unit'=> $entity));
    }

    public function activityAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("RetoAprenderBundle:Activity")->find($id);
        return $this->render('RetoAprenderBundle:resources:activity.html.twig', array('activity'=> $entity));
    }
}

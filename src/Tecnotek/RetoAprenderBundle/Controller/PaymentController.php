<?php

namespace Tecnotek\RetoAprenderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{

    public function indexAction()
    {
        return $this->render('RetoAprenderBundle:Payment:index.html.twig');
    }

    public function successAction(){
        $logger = $this->get('logger');

        /*$expirationDate = $user->getPremiumAccessExpiration();
        $workDate = new \DateTime();
        if(isset($expirationDate)) {//Date exists; add 6 months
            $workDate = $expirationDate;
        }
        date_add($workDate, date_interval_create_from_date_string('180 days'));
        $user->setPremiumAccessExpiration($workDate);
        $em = $this->getDoctrine()->getManager();
        $role = $em->getRepository('RetoAprenderBundle:Role')->
            findOneBy(array('role' => 'ROLE_PREMIUM'));
        $user->getUserRoles()->add($role);

        $em->persist($user);
        $em->flush();*/

        $user  = $this->getUser();
        $form    = $this->createForm(new \Tecnotek\RetoAprenderBundle\Form\UserFormType(), $user);

        return $this->render('RetoAprenderBundle:user:index.html.twig', array('entity' => $user, 'form'=> $form->createView(),
            'showAccountBox' => false, "infoMessage" => "Su pago sera procesado en unos minutos, un correo electronico sera enviado cuando se complete el proceso."));
    }

    public function processAction(){
        $logger = $this->get('logger');
        $request = new Request();
        $request = $this->get('request');
        $logger->err("--> Process Payment Action with request: " . $request->attributes->all());
        /*$expirationDate = $user->getPremiumAccessExpiration();
        $workDate = new \DateTime();
        if(isset($expirationDate)) {//Date exists; add 6 months
            $workDate = $expirationDate;
        }
        date_add($workDate, date_interval_create_from_date_string('180 days'));
        $user->setPremiumAccessExpiration($workDate);
        $em = $this->getDoctrine()->getManager();
        $role = $em->getRepository('RetoAprenderBundle:Role')->
            findOneBy(array('role' => 'ROLE_PREMIUM'));
        $user->getUserRoles()->add($role);

        $em->persist($user);
        $em->flush();*/

        return new Response('<html><body>ok</body></html>');
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

<?php

namespace Tecnotek\RetoAprenderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Tecnotek\RetoAprenderBundle\Entity\User;

class UserController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("RetoAprenderBundle:Topic")->find(1);
        return $this->render('RetoAprenderBundle:user:index.html.twig', array('topic'=> $entity));
    }

    public function registerAction(){
        $entity  = new User();
        $request = $this->getRequest();
        $form    = $this->createForm(new \Tecnotek\RetoAprenderBundle\Form\UserFormType(), $entity);
        $logger = $this->get("logger");
        $logger->err($request);
        $form->bindRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $role = $em->getRepository('RetoAprenderBundle:Role')->
                findOneBy(array('role' => 'ROLE_USER'));
            $entity->getUserRoles()->add($role);
            $entity->setActive(true);
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('reto_aprender_homepage',
                array('id' => $entity->getId())));
        } else {
            return $this->render('RetoAprenderBundle:Secured:login.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView()
            ));
        }
    }

    public function paymentAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("RetoAprenderBundle:Topic")->find(1);
        return $this->render('RetoAprenderBundle:user:payment.html.twig', array('topic'=> $entity));
    }
}

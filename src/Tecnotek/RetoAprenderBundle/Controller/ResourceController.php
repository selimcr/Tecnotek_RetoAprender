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

    public function topicAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("RetoAprenderBundle:Topic")->find($id);
        return $this->render('RetoAprenderBundle:resources:index.html.twig', array('topic'=> $entity));
    }

    public function levelAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("RetoAprenderBundle:Level")->find($id);
        return $this->render('RetoAprenderBundle:resources:level.html.twig', array('level'=> $entity));
    }

    public function unitAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("RetoAprenderBundle:Unit")->find($id);
        return $this->render('RetoAprenderBundle:resources:unit.html.twig', array('unit'=> $entity));
    }

    public function activityAction($id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository("RetoAprenderBundle:Activity")->find($id);
        $premiumAccess = $em->getRepository("RetoAprenderBundle:PremiumAccess")->findOneBy(
            array('user' => $user, 'level' => $entity->getUnit()->getLevel()));
        $securityContext = $this->container->get('security.context');
        if(isset($premiumAccess)  || $securityContext->isGranted('ROLE_ADMIN')){//Exists register
            $slides_name = "";
            $total_slides = 0;
            if($entity->getType() == 2){
                list($slides_name, $total_slides) = explode(",", $entity->getIncludeText(), 2);
            } else {
                if($entity->getType() == 3){//It's a Test, find the related test of the Unit
                    $test = $em->getRepository("RetoAprenderBundle:Test")->findOneBy(
                        array('unit' => $entity->getUnit()));

                    $questions = $em->getRepository("RetoAprenderBundle:Question")->findBy(
                        array('test' => $test));
                    shuffle($questions);
                    $questionsSlice = array_slice($questions, 0, 10);
                }
            }
            return $this->render('RetoAprenderBundle:resources:activity.html.twig', array(
                'activity'=> $entity, 'slides_name' => $slides_name, 'slides_total' => $total_slides, "menuSmall" => true,
                'test' => $test, 'questions' => $questionsSlice));
        } else {
            return $this->redirect($this->generateUrl('reto_aprender_user',
                array()));
        }
    }
}

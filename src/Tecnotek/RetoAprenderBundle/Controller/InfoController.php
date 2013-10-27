<?php

namespace Tecnotek\RetoAprenderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Tecnotek\RetoAprenderBundle\Entity\News;

use Tecnotek\RetoAprenderBundle\Form\NewsFormType;

class InfoController extends Controller
{

    public function infoEditAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:Info")->find($request->get('id'));
        if ( isset($entity) ) {
            $form   = $this->createForm(new InfoFormType(), $entity);
            return $this->render('RetoAprenderBundle:admin:info/edit.html.twig', array('entity' => $entity,
                'form'   => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('reto_aprender_admin_info'));
        }
    }

    public function infoUpdateAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:Info")->find($request->get('id'));
        if ( isset($entity) ) {
            $form    = $this->createForm(new InfoFormType(), $entity);
            $form->bindRequest($request);

            if ($form->isValid()) {
                $entity->setLastUserEditor($this->getUser());
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('reto_aprender_admin_info'));
            } else {
                return $this->render('RetoAprenderBundle:admin:info/edit.html.twig', array(
                    'entity' => $entity, 'form'   => $form->createView()
                ));
            }
        } else {
            return $this->redirect($this->generateUrl('reto_aprender_admin_info'));
        }
    }


    /* Admin Actions End */
}

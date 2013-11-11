<?php

namespace Tecnotek\RetoAprenderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Tecnotek\RetoAprenderBundle\Entity\Activity;
use Tecnotek\RetoAprenderBundle\Entity\Level;
use Tecnotek\RetoAprenderBundle\Entity\Unit;

use Tecnotek\RetoAprenderBundle\Entity\Answer;
use Tecnotek\RetoAprenderBundle\Entity\Test;
use Tecnotek\RetoAprenderBundle\Entity\Question;

use Tecnotek\RetoAprenderBundle\Form\ContactType;
use Tecnotek\RetoAprenderBundle\Form\LevelFormType;
use Tecnotek\RetoAprenderBundle\Form\UnitFormType;
use Tecnotek\RetoAprenderBundle\Form\AnswerFormType;
use Tecnotek\RetoAprenderBundle\Form\QuestionFormType;
use Tecnotek\RetoAprenderBundle\Form\TestFormType;
use Tecnotek\RetoAprenderBundle\Form\ActivityFormType;

class AdminController extends Controller
{

    public function indexAction()
    {
        return $this->render('RetoAprenderBundle:admin:index.html.twig');
    }

    /* TOPICS */
    public function topicListAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository("RetoAprenderBundle:Topic")->findAll();
        return $this->render('RetoAprenderBundle:admin:topic/list.html.twig', array('entities'=> $entities));
    }

    /* LEVELS */
    public function levelListAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository("RetoAprenderBundle:Level")->findAll();
        return $this->render('RetoAprenderBundle:admin:level/list.html.twig', array('entities'=> $entities));
    }

    public function levelNewAction(){
        $entity = new Level();
        $form   = $this->createForm(new LevelFormType(), $entity);
        return $this->render('RetoAprenderBundle:admin:level/new.html.twig', array('entity' => $entity,
            'form'   => $form->createView()));
    }

    public function levelSaveAction(){
        $entity  = new Level();
        $request = $this->getRequest();
        $form    = $this->createForm(new LevelFormType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('reto_aprender_admin_level',
                array('id' => $entity->getId())));
        } else {
            return $this->render('RetoAprenderBundle:admin:level/new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView()
            ));
        }
    }

    public function levelEditAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:Level")->find($request->get('id'));
        if ( isset($entity) ) {
            $form   = $this->createForm(new LevelFormType(), $entity);
            return $this->render('RetoAprenderBundle:admin:level/edit.html.twig', array('entity' => $entity,
                'form'   => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('reto_aprender_admin_level'));
        }
    }

    public function levelUpdateAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:Level")->find($request->get('id'));
        if ( isset($entity) ) {
            $form    = $this->createForm(new LevelFormType(), $entity);
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('reto_aprender_admin_level'));
            } else {
                return $this->render('RetoAprenderBundle:admin:level/edit.html.twig', array(
                    'entity' => $entity, 'form'   => $form->createView()
                ));
            }
        } else {
            return $this->redirect($this->generateUrl('reto_aprender_admin_level'));
        }
    }

    public function levelDeleteAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("RetoAprenderBundle:Level")->find( $id );
        if ( isset($entity) ) {
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('reto_aprender_admin_level'));
    }
    /* END LEVELS */

    /* UNITS */
    public function unitListAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository("RetoAprenderBundle:Unit")->findAll();
        return $this->render('RetoAprenderBundle:admin:unit/list.html.twig', array('entities'=> $entities));
    }

    public function unitNewAction(){
        $entity = new Unit();
        $form   = $this->createForm(new UnitFormType(), $entity);
        return $this->render('RetoAprenderBundle:admin:unit/new.html.twig', array('entity' => $entity,
            'form'   => $form->createView()));
    }

    public function unitSaveAction(){
        $entity  = new Unit();
        $request = $this->getRequest();
        $form    = $this->createForm(new UnitFormType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('reto_aprender_admin_unit',
                array('id' => $entity->getId())));
        } else {
            return $this->render('RetoAprenderBundle:admin:unit/new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView()
            ));
        }
    }

    public function unitEditAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:Unit")->find($request->get('id'));
        if ( isset($entity) ) {
            $form   = $this->createForm(new UnitFormType(), $entity);
            return $this->render('RetoAprenderBundle:admin:unit/edit.html.twig', array('entity' => $entity,
                'form'   => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('reto_aprender_admin_unit'));
        }
    }

    public function unitUpdateAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:Unit")->find($request->get('id'));
        if ( isset($entity) ) {
            $form    = $this->createForm(new UnitFormType(), $entity);
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('reto_aprender_admin_unit'));
            } else {
                return $this->render('RetoAprenderBundle:admin:unit/edit.html.twig', array(
                    'entity' => $entity, 'form'   => $form->createView()
                ));
            }
        } else {
            return $this->redirect($this->generateUrl('reto_aprender_admin_unit'));
        }
    }

    public function unitDeleteAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("RetoAprenderBundle:Unit")->find( $id );
        if ( isset($entity) ) {
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('reto_aprender_admin_unit'));
    }
    /* END UNITS */

    /* ACTIVITIES */
    public function activityListAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository("RetoAprenderBundle:Activity")->findAll();
        return $this->render('RetoAprenderBundle:admin:activity/list.html.twig', array('entities'=> $entities));
    }

    public function activityNewAction(){
        $entity = new Activity();
        $form   = $this->createForm(new ActivityFormType(), $entity);
        return $this->render('RetoAprenderBundle:admin:activity/new.html.twig', array('entity' => $entity,
            'form'   => $form->createView()));
    }

    public function activitySaveAction(){
        $entity  = new Activity();
        $request = $this->getRequest();
        $form    = $this->createForm(new ActivityFormType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('reto_aprender_admin_activity',
                array('id' => $entity->getId())));
        } else {
            return $this->render('RetoAprenderBundle:admin:activity/new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView()
            ));
        }
    }

    public function activityEditAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:Activity")->find($request->get('id'));
        if ( isset($entity) ) {
            $form   = $this->createForm(new ActivityFormType(), $entity);
            return $this->render('RetoAprenderBundle:admin:activity/edit.html.twig', array('entity' => $entity,
                'form'   => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('reto_aprender_admin_activity'));
        }
    }

    public function activityUpdateAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:Activity")->find($request->get('id'));
        if ( isset($entity) ) {
            $form    = $this->createForm(new ActivityFormType(), $entity);
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('reto_aprender_admin_activity'));
            } else {
                return $this->render('RetoAprenderBundle:admin:activity/edit.html.twig', array(
                    'entity' => $entity, 'form'   => $form->createView()
                ));
            }
        } else {
            return $this->redirect($this->generateUrl('reto_aprender_admin_activity'));
        }
    }

    public function activityDeleteAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("RetoAprenderBundle:Activity")->find( $id );
        if ( isset($entity) ) {
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('reto_aprender_admin_activity'));
    }
    /* END ACTIVITIES */

    public function historyAction()
    {
        return $this->render('RetoAprenderBundle::history.html.twig');
    }

    public function contactAction(Request $request)
    {
        $form = $this->get('form.factory')->create(new ContactType());

        if ($request->getMethod() == 'POST')
        {
            $contact = $request->request->get('contact');
            $form->bindRequest($request);
            if ($form->isValid())
            {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Website Contact Message')
                    ->setFrom("web-contact@retoaprender.com")
                    ->setTo("selim@retoaprender.com")
                    ->setBody($this->renderView('RetoAprenderBundle:emails:contactEmail.txt.twig', array('contact' => $form)),
                    'text/html');
                $this->get('mailer')->send($message);

                $this->get('session')->setFlash('notice', 'Su mensaje ha sido enviado!!!');

                return new RedirectResponse($this->generateUrl('reto_aprender_contact'));
            } else {
                var_dump($form);
                $logger = $this->get('logger');
                $logger->err("Form is Invalid!!!!");

            }
        }

        return $this->render('RetoAprenderBundle::contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    /*
    public function contactAction()
    {
        return $this->render('RetoAprenderBundle::contact.html.twig');
    }*/

    /* TEST */
    public function testListAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository("RetoAprenderBundle:Test")->findAll();
        return $this->render('RetoAprenderBundle:admin:test/list.html.twig', array('entities'=> $entities));
    }

    public function testNewAction(){
        $entity = new Test();
        $form   = $this->createForm(new TestFormType(), $entity);
        return $this->render('RetoAprenderBundle:admin:test/new.html.twig', array('entity' => $entity,
            'form'   => $form->createView()));
    }

    public function testSaveAction(){
        $entity  = new Test();
        $request = $this->getRequest();
        $form    = $this->createForm(new TestFormType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('reto_aprender_admin_test',
                array('id' => $entity->getId())));
        } else {
            return $this->render('RetoAprenderBundle:admin:test/new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView()
            ));
        }
    }

    public function testEditAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:Test")->find($request->get('id'));
        if ( isset($entity) ) {
            $form   = $this->createForm(new TestFormType(), $entity);
            return $this->render('RetoAprenderBundle:admin:test/edit.html.twig', array('entity' => $entity,
                'form'   => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('reto_aprender_admin_test'));
        }
    }

    public function testUpdateAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:Test")->find($request->get('id'));
        if ( isset($entity) ) {
            $form    = $this->createForm(new TestFormType(), $entity);
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('reto_aprender_admin_test'));
            } else {
                return $this->render('RetoAprenderBundle:admin:test/edit.html.twig', array(
                    'entity' => $entity, 'form'   => $form->createView()
                ));
            }
        } else {
            return $this->redirect($this->generateUrl('reto_aprender_admin_level'));
        }
    }

    public function testDeleteAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("RetoAprenderBundle:Test")->find( $id );
        if ( isset($entity) ) {
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('reto_aprender_admin_test'));
    }
    /* END TEST */


    /* QUESTION */
    public function questionListAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository("RetoAprenderBundle:Question")->findAll();
        return $this->render('RetoAprenderBundle:admin:question/list.html.twig', array('entities'=> $entities));
    }

    public function questionNewAction(){
        $entity = new Question();
        $form   = $this->createForm(new QuestionFormType(), $entity);
        return $this->render('RetoAprenderBundle:admin:question/new.html.twig', array('entity' => $entity,
            'form'   => $form->createView()));
    }

    public function questionSaveAction(){
        $entity  = new Question();
        $request = $this->getRequest();
        $form    = $this->createForm(new QuestionFormType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('reto_aprender_admin_question',
                array('id' => $entity->getId())));
        } else {
            return $this->render('RetoAprenderBundle:admin:question/new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView()
            ));
        }
    }

    public function questionEditAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:Question")->find($request->get('id'));
        if ( isset($entity) ) {
            $form   = $this->createForm(new QuestionFormType(), $entity);
            return $this->render('RetoAprenderBundle:admin:question/edit.html.twig', array('entity' => $entity,
                'form'   => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('reto_aprender_admin_question'));
        }
    }

    public function questionUpdateAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:Question")->find($request->get('id'));
        if ( isset($entity) ) {
            $form    = $this->createForm(new QuestionFormType(), $entity);
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('reto_aprender_admin_question'));
            } else {
                return $this->render('RetoAprenderBundle:admin:question/edit.html.twig', array(
                    'entity' => $entity, 'form'   => $form->createView()
                ));
            }
        } else {
            return $this->redirect($this->generateUrl('reto_aprender_admin_question'));
        }
    }

    public function QuestionDeleteAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("RetoAprenderBundle:Question")->find( $id );
        if ( isset($entity) ) {
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('reto_aprender_admin_question'));
    }
    /* END QUESTION */


    /* ANSWER */
    public function answerListAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository("RetoAprenderBundle:Answer")->findAll();
        return $this->render('RetoAprenderBundle:admin:answer/list.html.twig', array('entities'=> $entities));
    }

    public function AnswerNewAction(){
        $entity = new Answer();
        $form   = $this->createForm(new AnswerFormType(), $entity);
        return $this->render('RetoAprenderBundle:admin:answer/new.html.twig', array('entity' => $entity,
            'form'   => $form->createView()));
    }

    public function answerSaveAction(){
        $entity  = new Answer();
        $request = $this->getRequest();
        $form    = $this->createForm(new AnswerFormType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('reto_aprender_admin_answer',
                array('id' => $entity->getId())));
        } else {
            return $this->render('RetoAprenderBundle:admin:answer/new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView()
            ));
        }
    }

    public function answerEditAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:Answer")->find($request->get('id'));
        if ( isset($entity) ) {
            $form   = $this->createForm(new AnswerFormType(), $entity);
            return $this->render('RetoAprenderBundle:admin:answer/edit.html.twig', array('entity' => $entity,
                'form'   => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('reto_aprender_admin_answer'));
        }
    }

    public function answerUpdateAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:Answer")->find($request->get('id'));
        if ( isset($entity) ) {
            $form    = $this->createForm(new AnswerFormType(), $entity);
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('reto_aprender_admin_answer'));
            } else {
                return $this->render('RetoAprenderBundle:admin:answer/edit.html.twig', array(
                    'entity' => $entity, 'form'   => $form->createView()
                ));
            }
        } else {
            return $this->redirect($this->generateUrl('reto_aprender_admin_answer'));
        }
    }

    public function answerDeleteAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("RetoAprenderBundle:answer")->find( $id );
        if ( isset($entity) ) {
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('reto_aprender_admin_answer'));
    }
    /* END ANSWER */

}

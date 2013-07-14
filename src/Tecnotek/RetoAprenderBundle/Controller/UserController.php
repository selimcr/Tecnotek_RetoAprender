<?php

namespace Tecnotek\RetoAprenderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Tecnotek\RetoAprenderBundle\Entity\User;

use Tecnotek\RetoAprenderBundle\Form\UserAdminFormType;

class UserController extends Controller
{
    public function indexAction()
    {
        $entity  = $this->getUser();
        $form    = $this->createForm(new \Tecnotek\RetoAprenderBundle\Form\UserFormType(), $entity);

        return $this->render('RetoAprenderBundle:user:index.html.twig', array('entity' => $entity));
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
            $entity->setLastPasswordUpdate(new \DateTime());
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

    public function updateBasicInfoAction()
    {
        $logger = $this->get('logger');
        if ($this->get('request')->isXmlHttpRequest())// Is the request an ajax one?
        {
            try {
                $request = $this->get('request')->request;
                $firstname = $request->get('firstname');
                $lastname = $request->get('lastname');
                $email = $request->get('email');

                $translator = $this->get("translator");

                if( isset($firstname) && isset($lastname) && isset($email)) {

                    $user= $this->getUser();
                    $user->setFirstname($lastname);
                    $user->setLastname($firstname);
                    $user->setEmail($email);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();

                    return new Response(json_encode(array('error' => false)));
                } else {
                    return new Response(json_encode(array('error' => true, 'message' =>$translator->trans("error.paramateres.missing"))));
                }
            }
            catch (Exception $e) {
                $info = toString($e);
                $logger->err('SuperAdmin::saveStudentQualificationAction [' . $info . "]");
                return new Response(json_encode(array('error' => true, 'message' => $info)));
            }
        }// endif this is an ajax request
        else
        {
            return new Response("<b>Not an ajax call!!!" . "</b>");
        }
    }

    public function updatePasswordAction()
    {
        $logger = $this->get('logger');
        if ($this->get('request')->isXmlHttpRequest())// Is the request an ajax one?
        {
            try {
                $request = $this->get('request')->request;
                $currentPassword = $request->get('current');
                $newPassword = $request->get('new');

                $translator = $this->get("translator");

                if( isset($currentPassword) && isset($newPassword) ) {

                    $user= $this->getUser();

                    if($user->getPassword() != $user->getEncryptedPassword($currentPassword) ){
                        return new Response(json_encode(array('error' => true, 'message' =>$translator->trans("error.password.not.match") )));
                    } else {
                        $user->setPassword($user->getEncryptedPassword($newPassword));
                        $user->setLastPasswordUpdate(new \DateTime());

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($user);
                        $em->flush();

                        return new Response(json_encode(array('error' => false)));
                    }

                } else {
                    return new Response(json_encode(array('error' => true, 'message' =>$translator->trans("error.paramateres.missing"))));
                }
            }
            catch (Exception $e) {
                $info = toString($e);
                $logger->err('SuperAdmin::saveStudentQualificationAction [' . $info . "]");
                return new Response(json_encode(array('error' => true, 'message' => $info)));
            }
        }// endif this is an ajax request
        else
        {
            return new Response("<b>Not an ajax call!!!" . "</b>");
        }
    }

    public function uploadAvatarAction()
    {
        $request = $this->get('request');
        $file = $request->files->get('avatar');
        $user  = $this->getUser();
        $dir = '../web' . $user->getUploadDir() . "/";

        $now = new \DateTime();
        $newName = "avatar_" . $user->getId() . "_" . $now->getTimestamp() . ".png";
        $file->move($dir, $newName);

        $oldAvatar = $user->getAvatar();

        if( isset($oldAvatar) && $oldAvatar!="" ){//delete if exists
            $oldAvatarPath = $this->getRequest()->server->get('DOCUMENT_ROOT') .
                $this->getRequest()->getBasePath() . $user->getUploadDir() . "/" . $oldAvatar;
            if (file_exists($oldAvatarPath) &&
                is_writable($oldAvatarPath))
            {
                unlink ( $oldAvatarPath );
            }
        }

        $user->setAvatar($newName);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $form    = $this->createForm(new \Tecnotek\RetoAprenderBundle\Form\UserFormType(), $user);
        return $this->render('RetoAprenderBundle:user:index.html.twig', array('entity' => $user));
    }

    /* Users in Admin Actions start */
    public function usersListAction($type)
    {
        $em = $this->getDoctrine()->getManager();

        if($type == "admin"){
            $dql = "SELECT users FROM RetoAprenderBundle:User users "
                . " JOIN users.roles roles "
                . " WHERE roles.role = 'ROLE_ADMIN' "
                . " AND users.id <> " . $this->getUser()->getId()
                . " ORDER BY users.firstname";
            $query = $em->createQuery($dql);

            $entities = $query->getResult();
            return $this->render('RetoAprenderBundle::admin/users/administrators/list.html.twig', array(
                'entities' => $entities,
            ));
        } else {
            $dql = "SELECT users FROM RetoAprenderBundle:User users "
                . " JOIN users.roles roles "
                . " WHERE roles.role = 'ROLE_USER' "
                . " AND users.id <> " . $this->getUser()->getId()
                . " ORDER BY users.firstname";
            $query = $em->createQuery($dql);

            $entities = $query->getResult();
            return $this->render('RetoAprenderBundle::admin/users/regulars/list.html.twig', array(
                'entities' => $entities,
            ));
        }
    }

    public function usersNewAction($type){
        $entity = new User();
        $form   = $this->createForm(new UserAdminFormType(), $entity);

        if($type == "admin"){
            return $this->render('RetoAprenderBundle:admin:users/administrators/new.html.twig', array('entity' => $entity,
                'form'   => $form->createView()));
        } else {
            return $this->render('RetoAprenderBundle:admin:users/regulars/new.html.twig', array('entity' => $entity,
                'form'   => $form->createView()));
        }
    }

    public function usersSaveAction($type){
        $entity  = new User();
        $password = md5(uniqid(rand(), true));
        $password = substr($password, 0, 8);

        $entity->setLastPasswordUpdate(new \DateTime());
        $entity->setPassword($password);

        $request = $this->getRequest();
        $form    = $this->createForm(new UserAdminFormType(), $entity);
        $form->bindRequest($request);

        $em = $this->getDoctrine()->getManager();

        if($type == "admin"){
            if ($form->isValid()) {
                $role = $em->getRepository('RetoAprenderBundle:Role')->
                    findOneBy(array('role' => 'ROLE_ADMIN'));
                $entity->getUserRoles()->add($role);
				
				$message = \Swift_Message::newInstance()
                    ->setSubject('RetoAprender - Cuenta de Administrador Creada')
                    ->setFrom("web-contact@retoaprender.com")
                    ->setTo($entity->getEmail())
                    ->setBody($this->renderView('RetoAprenderBundle:emails:adminAccountCreatedEmail.txt.twig',
                        array('user' => $entity, 'password' => $password)),
                    'text/html');

                $this->get('mailer')->send($message);
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('reto_aprender_admin_users',
                    array('id' => $entity->getId(), 'type' => 'admin')));
            } else {
                return $this->render('RetoAprenderBundle:admin:users/administrators/new.html.twig', array(
                    'entity' => $entity,
                    'form'   => $form->createView()
                ));
            }
        } else {
            if ($form->isValid()) {
                $role = $em->getRepository('RetoAprenderBundle:Role')->
                    findOneBy(array('role' => 'ROLE_USER'));
                $entity->getUserRoles()->add($role);
				
				$message = \Swift_Message::newInstance()
                    ->setSubject('RetoAprender - Cuenta de Usuario Creada')
                    ->setFrom("web-contact@retoaprender.com")
                    ->setTo($entity->getEmail())
                    ->setBody($this->renderView('RetoAprenderBundle:emails:accountCreatedEmail.txt.twig',
                        array('user' => $entity, 'password' => $password)),
                    'text/html');

                $this->get('mailer')->send($message);
				
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('reto_aprender_admin_users',
                    array('id' => $entity->getId(), 'type' => 'regular')));
            } else {
                return $this->render('RetoAprenderBundle:admin:users/regulars/new.html.twig', array(
                    'entity' => $entity,
                    'form'   => $form->createView()
                ));
            }
        }
    }

    public function usersEditAction($type){
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:User")->find($request->get('id'));
        if ( isset($entity) ) {
            $form   = $this->createForm(new UserAdminFormType(), $entity);
            if($type == "admin"){
                return $this->render('RetoAprenderBundle:admin:users/administrators/edit.html.twig', array('entity' => $entity,
                    'form'   => $form->createView()));
            } else {
                return $this->render('RetoAprenderBundle:admin:users/regulars/edit.html.twig', array('entity' => $entity,
                    'form'   => $form->createView()));
            }
        } else {
            if($type == "admin"){
                return $this->redirect($this->generateUrl('reto_aprender_admin_users', array('type' => 'admin')));
            } else {
                return $this->redirect($this->generateUrl('reto_aprender_admin_users', array('type' => 'regular')));
            }
        }
    }

    public function usersUpdateAction($type){
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:User")->find($request->get('id'));
        if ( isset($entity) ) {
            $form    = $this->createForm(new UserAdminFormType(), $entity);
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em->persist($entity);
                $em->flush();
                if($type == "admin"){
                    return $this->redirect($this->generateUrl('reto_aprender_admin_users', array('type' => 'admin')));
                } else {
                    return $this->redirect($this->generateUrl('reto_aprender_admin_users', array('type' => 'regular')));
                }
            } else {
                if($type == "admin"){
                    return $this->render('RetoAprenderBundle:admin:users/administrators/edit.html.twig', array('entity' => $entity,
                        'form'   => $form->createView()));
                } else {
                    return $this->render('RetoAprenderBundle:admin:users/regulars/edit.html.twig', array('entity' => $entity,
                        'form'   => $form->createView()));
                }
            }
        } else {
            if($type == "admin"){
                return $this->redirect($this->generateUrl('reto_aprender_admin_users', array('type' => 'admin')));
            } else {
                return $this->redirect($this->generateUrl('reto_aprender_admin_users', array('type' => 'regular')));
            }
        }
    }

    public function usersDeleteAction($type, $id){
        $logger = $this->get("logger");
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:User")->find( $id );
        if ( isset($entity) ) {
            $logger->err("Eliminando Usuario: El administrador '" . $this->getUser() . "' ha eliminado el usuario: " . $entity->getUsername());
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('reto_aprender_admin_users', array('type' => $type)));
    }

    public function resetPasswordAction($type, $id){
        $logger = $this->get("logger");
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $entity = $em->getRepository("RetoAprenderBundle:User")->find( $id );
        if ( isset($entity) ) {
            $logger->err("Resetando password de Usuario: El administrador '" . $this->getUser() . "' ha generado un nuevo password para el usuario: " . $entity->getUsername());

            $password = md5(uniqid(rand(), true));
            $password = substr($password, 0, 8);

            $message = \Swift_Message::newInstance()
                ->setSubject('RetoAprender - Cuenta de Administrador Creada')
                ->setFrom("web-contact@retoaprender.com")
                ->setTo($entity->getEmail())
                ->setBody($this->renderView('RetoAprenderBundle:emails:passwordResetEmail.txt.twig',
                    array('user' => $entity, 'password' => $password)),
                'text/html');

            $this->get('mailer')->send($message);

            $entity->setPassword($entity->getEncryptedPassword($password));
            $entity->setLastPasswordUpdate(new \DateTime());
            $em->persist($entity);
            $em->flush();

            /*$em->remove($entity);
            $em->flush();*/
        }

        return $this->redirect($this->generateUrl('reto_aprender_admin_users', array('type' => $type)));
    }
    /* Users in Admin Actions End */
}

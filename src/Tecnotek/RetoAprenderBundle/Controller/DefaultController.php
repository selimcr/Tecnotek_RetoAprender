<?php

namespace Tecnotek\RetoAprenderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Tecnotek\RetoAprenderBundle\Form\ContactType;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $this->get('google.analytics')->setCustomPageView('/homepage');
        return $this->render('RetoAprenderBundle::index.html.twig');
    }

    public function aboutAction()
    {
        return $this->render('RetoAprenderBundle::about.html.twig');
    }

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
}

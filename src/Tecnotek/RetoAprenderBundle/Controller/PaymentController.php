<?php

namespace Tecnotek\RetoAprenderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Tecnotek\RetoAprenderBundle\Entity\Payment;
use Tecnotek\RetoAprenderBundle\Entity\User;

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
            'showAccountBox' => false, "infoMessage" => "Si su pago no es procesado de inmediato el mismo lo sera en unos pocos minutos."));
    }

    public function processAction(){
        $logger = $this->get('logger');
        $request = new Request();
        $request = $this->get('request');

        $logger->err("--> Process Payment Action with request: [custom="
            . $request->get('custom') . "]-[payment_status="
            . $request->get('payment_status') . "]-[payer_email="
            . $request->get('payer_email') . "]-[payment_date="
            . $request->get('payment_date') . "]-[receiver_id="
            . $request->get('receiver_id') . "]-[item_number="
            . $request->get('item_number') . "]-[txn_id=" . $request->get('txn_id') . "]-[invoice="
            . $request->get('invoice') . "]");

        $status = $request->get('payment_status');
        /**************************/ // $status = "Completed";

        if(isset($status)){
            if ($status == "Completed"){//Is a valid transaction
                $transaccionId = $request->get('txn_id');
                /**************************/ //$transaccionId = "9U601677AY8601065";

                $em = $this->getDoctrine()->getManager();

                //Check if the transaction is already register
                $transaction = $em->getRepository("RetoAprenderBundle:Payment")->findOneByTransaccionId($transaccionId);

                if(isset($transaction)){//Do nothing; already process it.
                } else {
                    $custom = $request->get('custom');
                    /**************************/ //$custom = "4-12";

                    if(isset($custom) && $custom!=""){
                        $words = explode("-", $custom);
                        $payment = new Payment();
                        $payment->setDate(new \DateTime());
                        $payment->setTransactionId($transaccionId);
                        $payment->setType($words[1]);

                        $user = $em->getRepository("RetoAprenderBundle:User")->find($words[0]);
                        $payment->setUser($user);

                        $em->persist($payment);

                        $expirationDate = $user->getPremiumAccessExpiration();
                        $workDate = new \DateTime();
                        if(isset($expirationDate)) {//Date exists
                            $workDate = $expirationDate;
                        } else {
                            $role = $em->getRepository('RetoAprenderBundle:Role')->
                                findOneBy(array('role' => 'ROLE_PREMIUM'));
                            $user->getUserRoles()->add($role);
                        }
                        //$workDate = date_add($workDate, date_interval_create_from_date_string($words[1] . ' days'));
                        $newDate = $workDate->add(new \DateInterval('P' . $words[1] . 'D'));
                        $d = new \DateTime($newDate->format('Y-m-d'));
                        $user->setPremiumAccessExpiration($d);
                        $em->persist($user);
                        $em->flush();
                    }
                }
            } else {
                $logger->info("The status is invalid:  [custom="
                    . $request->get('custom') . "]-[payment_status="
                    . $request->get('payment_status') . "]-[payer_email="
                    . $request->get('payer_email') . "]-[payment_date="
                    . $request->get('payment_date') . "]-[receiver_id="
                    . $request->get('receiver_id') . "]-[item_number="
                    . $request->get('item_number') . "]-[txn_id=" . $request->get('txn_id') . "]-[invoice="
                    . $request->get('invoice') . "]");
            }
        }

        //Find


        /*
[2013-06-24 22:36:51] app.ERROR: --> Process Payment Action with request:
[custom=4-12]-
[payment_status=Completed]-
[payer_email=selim-test2@retoaprender.com]-
[payment_date=20:36:32 Jun 24, 2013 PDT]-
[receiver_id=YYCVMD6AQ7ZLA]-
[item_number=1]-
[txn_id=9U601677AY860105K]-[invoice=] [] []
         *
         */

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

    /**** Actions for the Admin Section ****/


    public function adminListPaymentsAction(){
        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT p FROM RetoAprenderBundle:Payment p ORDER BY p.date DESC";
        $query = $em->createQuery($dql)->setFirstResult(0)->setMaxResults(25);
        $payments = $query->getResult();

        return $this->render('RetoAprenderBundle:admin:payment/index.html.twig', array('entities'=> $payments));
    }
}

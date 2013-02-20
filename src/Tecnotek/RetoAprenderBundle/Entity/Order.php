<?php
namespace Tecnotek\RetoAprenderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Payment\CoreBundle\Entity\PaymentInstruction as PaymentInstruction;

/**
 * @ORM\Table(name="tek_orders")
 * @ORM\Entity()
 */
class Order
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="JMS\Payment\CoreBundle\Entity\PaymentInstruction")
     */
    private $paymentInstruction;

    /**
     * @ORM\Column(type="string", unique = true)
     */
    private $orderNumber;

    /**
     * @ORM\Column(type="decimal", precision = 2)
     */
    private $amount;

    // ...

    public function __construct($amount, $orderNumber)
    {
        $this->amount = $amount;
        $this->orderNumber = $orderNumber;
    }

    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getPaymentInstruction()
    {
        return $this->paymentInstruction;
    }

    public function setPaymentInstruction(PaymentInstruction $instruction)
    {
        $this->paymentInstruction = $instruction;
    }

    // ...
}
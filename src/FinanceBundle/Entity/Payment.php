<?php

namespace FinanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payment
 *
 * @ORM\Table(name="payment", indexes={
 *     @ORM\Index(name="date", columns={"date"}),
 *     @ORM\Index(name="fk_payment_payment_category", columns={"category_id"})})
 * @ORM\Entity(repositoryClass="FinanceBundle\Repository\PaymentRepository")
 */
class Payment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer", nullable=true)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var \FinanceBundle\Entity\Wallet
     *
     * @ORM\ManyToOne(targetEntity="Wallet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="wallet_from_id", referencedColumnName="id")
     * })
     */
    private $walletFrom;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @var \FinanceBundle\Entity\PaymentCategory
     *
     * @ORM\ManyToOne(targetEntity="PaymentCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="set null")
     * })
     */
    private $category;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return Payment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Payment
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set walletFrom
     *
     * @param integer $walletFrom
     *
     * @return Payment
     */
    public function setWalletFrom($walletFrom)
    {
        $this->walletFrom = $walletFrom;

        return $this;
    }

    /**
     * Get walletFrom
     *
     * @return Wallet
     */
    public function getWalletFrom()
    {
        return $this->walletFrom;
    }


    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Payment
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set category
     *
     * @param \FinanceBundle\Entity\PaymentCategory $category
     *
     * @return Payment
     */
    public function setCategory(PaymentCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \FinanceBundle\Entity\PaymentCategory
     */
    public function getCategory()
    {
        return $this->category;
    }
}

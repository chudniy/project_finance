<?php

namespace FinanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Refill
 *
 * @ORM\Table(name="refill")
 * @ORM\Entity(repositoryClass="FinanceBundle\Repository\RefillRepository")
 */
class Refill
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535)
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
     * @var \FinanceBundle\Entity\Wallet
     *
     * @ORM\ManyToOne(targetEntity="Wallet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="wallet_to_id", referencedColumnName="id", onDelete="set null")
     * })
     */
    private $walletTo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;


    /**
     * Get id
     *
     * @return int
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
     * @return Refill
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return int
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
     * @return Refill
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
     * @return Refill
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
     * Set walletTo
     *
     * @param integer $walletTo
     *
     * @return Refill
     */
    public function setWalletTo($walletTo)
    {
        $this->walletTo = $walletTo;

        return $this;
    }

    /**
     * Get walletTo
     *
     * @return Wallet
     */
    public function getWalletTo()
    {
        return $this->walletTo;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Refill
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
}

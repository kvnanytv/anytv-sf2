<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Referral
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Anytv\DashboardBundle\Entity\ReferralRepository")
 */
class Referral
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;
    
    /**
     * @ORM\ManyToOne(targetEntity="Affiliate", inversedBy="referrerReferrals")
     * @ORM\JoinColumn(name="referrer_id", referencedColumnName="id")
     */
    private $referrer;

    /**
     * @ORM\ManyToOne(targetEntity="Affiliate", inversedBy="referredReferrals")
     * @ORM\JoinColumn(name="referred_id", referencedColumnName="id")
     */
    private $referred;

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
     * @param float $amount
     * @return Referral
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Referral
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
     * Set referrer
     *
     * @param \Anytv\DashboardBundle\Entity\Affiliate $referrer
     * @return Referral
     */
    public function setReferrer(\Anytv\DashboardBundle\Entity\Affiliate $referrer = null)
    {
        $this->referrer = $referrer;
    
        return $this;
    }

    /**
     * Get referrer
     *
     * @return \Anytv\DashboardBundle\Entity\Affiliate 
     */
    public function getReferrer()
    {
        return $this->referrer;
    }

    /**
     * Set referred
     *
     * @param \Anytv\DashboardBundle\Entity\Affiliate $referred
     * @return Referral
     */
    public function setReferred(\Anytv\DashboardBundle\Entity\Affiliate $referred = null)
    {
        $this->referred = $referred;
    
        return $this;
    }

    /**
     * Get referred
     *
     * @return \Anytv\DashboardBundle\Entity\Affiliate 
     */
    public function getReferred()
    {
        return $this->referred;
    }
    
    /**
     * Echo date string
     *
     * @return \DateTime string 
     */
    public function getDateAsString()
    {
        return date_format($this->date, 'Y-m-d');
    }
}
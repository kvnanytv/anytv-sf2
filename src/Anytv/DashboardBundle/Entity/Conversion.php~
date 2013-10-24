<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conversion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Anytv\DashboardBundle\Entity\ConversionRepository")
 */
class Conversion
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
     * @var integer
     *
     * @ORM\Column(name="conversionId", type="integer")
     */
    private $conversionId;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255, nullable=true)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="transactionId", type="string", length=255, nullable=true)
     */
    private $transactionId;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @var float
     *
     * @ORM\Column(name="payout", type="float", nullable=true)
     */
    private $payout;

    /**
     * @var float
     *
     * @ORM\Column(name="revenue", type="float", nullable=true)
     */
    private $revenue;

    /**
     * @var float
     *
     * @ORM\Column(name="saleAmount", type="float", nullable=true)
     */
    private $saleAmount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isAdjustment", type="boolean", nullable=true)
     */
    private $isAdjustment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdAt;
    
    /**
     * @ORM\ManyToOne(targetEntity="Affiliate", inversedBy="conversions")
     * @ORM\JoinColumn(name="affiliate_id", referencedColumnName="id")
     */
    private $affiliate;
    
     /**
     * @ORM\ManyToOne(targetEntity="Offer", inversedBy="conversions")
     * @ORM\JoinColumn(name="offer_id", referencedColumnName="id")
     */
    private $offer;


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
     * Set conversionId
     *
     * @param integer $conversionId
     * @return Conversion
     */
    public function setConversionId($conversionId)
    {
        $this->conversionId = $conversionId;
    
        return $this;
    }

    /**
     * Get conversionId
     *
     * @return integer 
     */
    public function getConversionId()
    {
        return $this->conversionId;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Conversion
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    
        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set transactionId
     *
     * @param string $transactionId
     * @return Conversion
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    
        return $this;
    }

    /**
     * Get transactionId
     *
     * @return string 
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Conversion
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set payout
     *
     * @param float $payout
     * @return Conversion
     */
    public function setPayout($payout)
    {
        $this->payout = $payout;
    
        return $this;
    }

    /**
     * Get payout
     *
     * @return float 
     */
    public function getPayout()
    {
        return $this->payout;
    }

    /**
     * Set revenue
     *
     * @param float $revenue
     * @return Conversion
     */
    public function setRevenue($revenue)
    {
        $this->revenue = $revenue;
    
        return $this;
    }

    /**
     * Get revenue
     *
     * @return float 
     */
    public function getRevenue()
    {
        return $this->revenue;
    }

    /**
     * Set saleAmount
     *
     * @param float $saleAmount
     * @return Conversion
     */
    public function setSaleAmount($saleAmount)
    {
        $this->saleAmount = $saleAmount;
    
        return $this;
    }

    /**
     * Get saleAmount
     *
     * @return float 
     */
    public function getSaleAmount()
    {
        return $this->saleAmount;
    }

    /**
     * Set isAdjustment
     *
     * @param boolean $isAdjustment
     * @return Conversion
     */
    public function setIsAdjustment($isAdjustment)
    {
        $this->isAdjustment = $isAdjustment;
    
        return $this;
    }

    /**
     * Get isAdjustment
     *
     * @return boolean 
     */
    public function getIsAdjustment()
    {
        return $this->isAdjustment;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Conversion
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
     /**
     * Echo createdAt string
     *
     * @return \DateTime string 
     */
    public function getCreatedAtAsString()
    {
        return date_format($this->createdAt, 'Y-m-d H:i:s');
    }

    /**
     * Set affiliate
     *
     * @param \Anytv\DashboardBundle\Entity\Affiliate $affiliate
     * @return Conversion
     */
    public function setAffiliate(\Anytv\DashboardBundle\Entity\Affiliate $affiliate = null)
    {
        $this->affiliate = $affiliate;
    
        return $this;
    }

    /**
     * Get affiliate
     *
     * @return \Anytv\DashboardBundle\Entity\Affiliate 
     */
    public function getAffiliate()
    {
        return $this->affiliate;
    }

    /**
     * Set offer
     *
     * @param \Anytv\DashboardBundle\Entity\Offer $offer
     * @return Conversion
     */
    public function setOffer(\Anytv\DashboardBundle\Entity\Offer $offer = null)
    {
        $this->offer = $offer;
    
        return $this;
    }

    /**
     * Get offer
     *
     * @return \Anytv\DashboardBundle\Entity\Offer 
     */
    public function getOffer()
    {
        return $this->offer;
    }
}
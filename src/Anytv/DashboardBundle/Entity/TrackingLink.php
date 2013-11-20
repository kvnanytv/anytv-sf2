<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrackingLink
 *
 * @ORM\Table(name="TrackingLink")
 * @ORM\Entity(repositoryClass="Anytv\DashboardBundle\Entity\TrackingLinkRepository")
 */
class TrackingLink
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
     * @ORM\Column(name="affiliate_id", type="integer")
     */
    private $affiliateId;

    /**
     * @var integer
     *
     * @ORM\Column(name="offer_id", type="integer")
     */
    private $offerId;

    /**
     * @var string
     *
     * @ORM\Column(name="click_url", type="string", length=255)
     */
    private $clickUrl;


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
     * Set affiliateId
     *
     * @param integer $affiliateId
     * @return TrackingLink
     */
    public function setAffiliateId($affiliateId)
    {
        $this->affiliateId = $affiliateId;
    
        return $this;
    }

    /**
     * Get affiliateId
     *
     * @return integer 
     */
    public function getAffiliateId()
    {
        return $this->affiliateId;
    }

    /**
     * Set offerId
     *
     * @param integer $offerId
     * @return TrackingLink
     */
    public function setOfferId($offerId)
    {
        $this->offerId = $offerId;
    
        return $this;
    }

    /**
     * Get offerId
     *
     * @return integer 
     */
    public function getOfferId()
    {
        return $this->offerId;
    }

    /**
     * Set clickUrl
     *
     * @param string $clickUrl
     * @return TrackingLink
     */
    public function setClickUrl($clickUrl)
    {
        $this->clickUrl = $clickUrl;
    
        return $this;
    }

    /**
     * Get clickUrl
     *
     * @return string 
     */
    public function getClickUrl()
    {
        return $this->clickUrl;
    }
}
<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Anytv\DashboardBundle\Entity\Offer;

/**
 * TrafficReferral
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Anytv\DashboardBundle\Entity\TrafficReferralRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TrafficReferral
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
     * @ORM\ManyToOne(targetEntity="Affiliate", inversedBy="trafficReferrals")
     * @ORM\JoinColumn(name="affiliate_id", referencedColumnName="id")
     */
    private $affiliate;
    
     /**
     * @ORM\ManyToOne(targetEntity="Offer", inversedBy="trafficReferrals")
     * @ORM\JoinColumn(name="offer_id", referencedColumnName="id")
     */
    private $offer;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=510)
     */
    private $url;

    /**
     * @var integer
     *
     * @ORM\Column(name="clicks", type="integer")
     */
    private $clicks;

    /**
     * @var integer
     *
     * @ORM\Column(name="conversions", type="integer")
     */
    private $conversions;

    /**
     * @var integer
     *
     * @ORM\Column(name="likes", type="integer")
     */
    private $likes;

    /**
     * @var integer
     *
     * @ORM\Column(name="dislikes", type="integer")
     */
    private $dislikes;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="count", type="integer")
     */
    private $count;
    
    /**
     * @var \Date
     *
     * @ORM\Column(name="stat_date", type="date")
     */
    private $statDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;


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
     * Set url
     *
     * @param string $url
     * @return TrafficReferral
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set clicks
     *
     * @param integer $clicks
     * @return TrafficReferral
     */
    public function setClicks($clicks)
    {
        $this->clicks = $clicks;
    
        return $this;
    }

    /**
     * Get clicks
     *
     * @return integer 
     */
    public function getClicks()
    {
        return $this->clicks;
    }

    /**
     * Set conversions
     *
     * @param integer $conversions
     * @return TrafficReferral
     */
    public function setConversions($conversions)
    {
        $this->conversions = $conversions;
    
        return $this;
    }

    /**
     * Get conversions
     *
     * @return integer 
     */
    public function getConversions()
    {
        return $this->conversions;
    }

    /**
     * Set likes
     *
     * @param integer $likes
     * @return TrafficReferral
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    
        return $this;
    }

    /**
     * Get likes
     *
     * @return integer 
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Set dislikes
     *
     * @param integer $dislikes
     * @return TrafficReferral
     */
    public function setDislikes($dislikes)
    {
        $this->dislikes = $dislikes;
    
        return $this;
    }

    /**
     * Get dislikes
     *
     * @return integer 
     */
    public function getDislikes()
    {
        return $this->dislikes;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return TrafficReferral
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return TrafficReferral
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
      $this->createdAt = new \DateTime();
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
      $this->updatedAt = new \DateTime();
    }

    /**
     * Set count
     *
     * @param integer $count
     * @return TrafficReferral
     */
    public function setCount($count)
    {
        $this->count = $count;
    
        return $this;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set statDate
     *
     * @param \DateTime $statDate
     * @return TrafficReferral
     */
    public function setStatDate($statDate)
    {
        $this->statDate = $statDate;
    
        return $this;
    }

    /**
     * Get statDate
     *
     * @return \DateTime 
     */
    public function getStatDate()
    {
        return $this->statDate;
    }
    
    /**
     * Echo statDate
     *
     * @return \DateTime string 
     */
    public function getStatDateAsString()
    {
        return date_format($this->statDate, 'Y-m-d');
    }

    /**
     * Set affiliate
     *
     * @param \Anytv\DashboardBundle\Entity\Affiliate $affiliate
     * @return TrafficReferral
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
     * @return TrafficReferral
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
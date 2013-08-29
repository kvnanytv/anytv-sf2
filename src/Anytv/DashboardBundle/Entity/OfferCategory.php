<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * OfferCategory
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Anytv\DashboardBundle\Entity\OfferCategoryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class OfferCategory
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
     * @ORM\Column(name="offer_category_id", type="integer")
     */
    private $offerCategoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="offer_count", type="integer")
     */
    private $offerCount;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updated_at;
    
    /**
     * @ORM\ManyToMany(targetEntity="Offer", mappedBy="offerCategories")
     */
    protected $offers;
    
    public function __construct()
    {
        $this->offers = new ArrayCollection();
    }


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
     * Set name
     *
     * @param string $name
     * @return OfferCategory
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return OfferCategory
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
     * Set offerCount
     *
     * @param integer $offerCount
     * @return OfferCategory
     */
    public function setOfferCount($offerCount)
    {
        $this->offerCount = $offerCount;
    
        return $this;
    }

    /**
     * Get offerCount
     *
     * @return integer 
     */
    public function getOfferCount()
    {
        return $this->offerCount;
    }

    /**
     * Set offerCategoryId
     *
     * @param integer $offerCategoryId
     * @return OfferCategory
     */
    public function setOfferCategoryId($offerCategoryId)
    {
        $this->offerCategoryId = $offerCategoryId;
    
        return $this;
    }

    /**
     * Get offerCategoryId
     *
     * @return integer 
     */
    public function getOfferCategoryId()
    {
        return $this->offerCategoryId;
    }

    /**
     * Add offers
     *
     * @param \Anytv\DashboardBundle\Entity\Offer $offers
     * @return OfferCategory
     */
    public function addOffer(\Anytv\DashboardBundle\Entity\Offer $offers)
    {
        $this->offers[] = $offers;
    
        return $this;
    }

    /**
     * Remove offers
     *
     * @param \Anytv\DashboardBundle\Entity\Offer $offers
     */
    public function removeOffer(\Anytv\DashboardBundle\Entity\Offer $offers)
    {
        $this->offers->removeElement($offers);
    }

    /**
     * Get offers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOffers()
    {
        return $this->offers;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return OfferCategory
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    
        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return OfferCategory
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
      $this->created_at = new \DateTime();
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
      if(!$this->updated_at)
      {
        $this->updated_at = new \DateTime();
      }
    }
}
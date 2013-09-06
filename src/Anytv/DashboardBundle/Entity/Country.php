<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Country
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Anytv\DashboardBundle\Entity\CountryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Country
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;
    
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
     * @ORM\ManyToMany(targetEntity="Offer", mappedBy="countries")
     */
    protected $offers;
    
    /**
     * @ORM\OneToMany(targetEntity="Affiliate", mappedBy="country")
     */
    private $affiliates;
    
    /**
     * @ORM\OneToMany(targetEntity="Advertiser", mappedBy="country")
     */
    private $advertisers;
    
    public function __construct()
    {
        $this->offers = new ArrayCollection();
        $this->affiliates = new ArrayCollection();
        $this->advertisers = new ArrayCollection();
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
     * @return Country
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
     * Set code
     *
     * @param string $code
     * @return Country
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Add offers
     *
     * @param \Anytv\DashboardBundle\Entity\Offer $offers
     * @return Country
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
     * @return Country
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
     * @return Country
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

    /**
     * Add affiliates
     *
     * @param \Anytv\DashboardBundle\Entity\Affiliate $affiliates
     * @return Country
     */
    public function addAffiliate(\Anytv\DashboardBundle\Entity\Affiliate $affiliates)
    {
        $this->affiliates[] = $affiliates;
    
        return $this;
    }

    /**
     * Remove affiliates
     *
     * @param \Anytv\DashboardBundle\Entity\Affiliate $affiliates
     */
    public function removeAffiliate(\Anytv\DashboardBundle\Entity\Affiliate $affiliates)
    {
        $this->affiliates->removeElement($affiliates);
    }

    /**
     * Get affiliates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAffiliates()
    {
        return $this->affiliates;
    }
    
    public function __toString() 
    {
      return $this->getName();    
    }

    /**
     * Add advertisers
     *
     * @param \Anytv\DashboardBundle\Entity\Advertiser $advertisers
     * @return Country
     */
    public function addAdvertiser(\Anytv\DashboardBundle\Entity\Advertiser $advertisers)
    {
        $this->advertisers[] = $advertisers;
    
        return $this;
    }

    /**
     * Remove advertisers
     *
     * @param \Anytv\DashboardBundle\Entity\Advertiser $advertisers
     */
    public function removeAdvertiser(\Anytv\DashboardBundle\Entity\Advertiser $advertisers)
    {
        $this->advertisers->removeElement($advertisers);
    }

    /**
     * Get advertisers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAdvertisers()
    {
        return $this->advertisers;
    }
}
<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Advertiser
 *
 * @ORM\Table(name="Advertiser")
 * @ORM\Entity(repositoryClass="Anytv\DashboardBundle\Entity\AdvertiserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Advertiser
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
     * @ORM\Column(name="advertiser_id", type="integer")
     */
    private $advertiserId;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=255)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="address1", type="string", length=255, nullable=true)
     */
    private $address1;

    /**
     * @var string
     *
     * @ORM\Column(name="address2", type="string", length=255, nullable=true)
     */
    private $address2;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255, nullable=true)
     */
    private $region;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="advertisers")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="other", type="string", length=255, nullable=true)
     */
    private $other;

    /**
     * @var string
     *
     * @ORM\Column(name="zipcode", type="string", length=255, nullable=true)
     */
    private $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="signup_ip", type="string", length=255, nullable=true)
     */
    private $signupIp;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     * @Assert\Choice(
     *     choices = { "active", "pending", "deleted", "blocked", "rejected" },
     *     message = "Choose a valid status."
     * )
     */
    private $status;

    /**
     * @var boolean
     *
     * @ORM\Column(name="wants_alerts", type="boolean", nullable=true)
     */
    private $wantsAlerts;

    /**
     * @var integer
     *
     * @ORM\Column(name="account_manager_id", type="integer", nullable=true)
     */
    private $accountManagerId;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_id", type="string", length=255, nullable=true)
     */
    private $refId;

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
     * @ORM\OneToMany(targetEntity="Offer", mappedBy="advertiser")
     */
    private $offers;
    
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
     * Set advertiserId
     *
     * @param integer $advertiserId
     * @return Advertiser
     */
    public function setAdvertiserId($advertiserId)
    {
        $this->advertiserId = $advertiserId;
    
        return $this;
    }

    /**
     * Get advertiserId
     *
     * @return integer 
     */
    public function getAdvertiserId()
    {
        return $this->advertiserId;
    }

    /**
     * Set company
     *
     * @param string $company
     * @return Advertiser
     */
    public function setCompany($company)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set address1
     *
     * @param string $address1
     * @return Advertiser
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    
        return $this;
    }

    /**
     * Get address1
     *
     * @return string 
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2
     *
     * @param string $address2
     * @return Advertiser
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    
        return $this;
    }

    /**
     * Get address2
     *
     * @return string 
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Advertiser
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return Advertiser
     */
    public function setRegion($region)
    {
        $this->region = $region;
    
        return $this;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set other
     *
     * @param string $other
     * @return Advertiser
     */
    public function setOther($other)
    {
        $this->other = $other;
    
        return $this;
    }

    /**
     * Get other
     *
     * @return string 
     */
    public function getOther()
    {
        return $this->other;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     * @return Advertiser
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    
        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string 
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Advertiser
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Advertiser
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    
        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Advertiser
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    
        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set signupIp
     *
     * @param string $signupIp
     * @return Advertiser
     */
    public function setSignupIp($signupIp)
    {
        $this->signupIp = $signupIp;
    
        return $this;
    }

    /**
     * Get signupIp
     *
     * @return string 
     */
    public function getSignupIp()
    {
        return $this->signupIp;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Advertiser
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
     * Set wantsAlerts
     *
     * @param boolean $wantsAlerts
     * @return Advertiser
     */
    public function setWantsAlerts($wantsAlerts)
    {
        $this->wantsAlerts = $wantsAlerts;
    
        return $this;
    }

    /**
     * Get wantsAlerts
     *
     * @return boolean 
     */
    public function getWantsAlerts()
    {
        return $this->wantsAlerts;
    }

    /**
     * Set accountManagerId
     *
     * @param integer $accountManagerId
     * @return Advertiser
     */
    public function setAccountManagerId($accountManagerId)
    {
        $this->accountManagerId = $accountManagerId;
    
        return $this;
    }

    /**
     * Get accountManagerId
     *
     * @return integer 
     */
    public function getAccountManagerId()
    {
        return $this->accountManagerId;
    }

    /**
     * Set refId
     *
     * @param string $refId
     * @return Advertiser
     */
    public function setRefId($refId)
    {
        $this->refId = $refId;
    
        return $this;
    }

    /**
     * Get refId
     *
     * @return string 
     */
    public function getRefId()
    {
        return $this->refId;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Advertiser
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
     * @return Advertiser
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
      if(!$this->created_at)
      {
        $this->created_at = new \DateTime();
      }
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
     * Add offers
     *
     * @param \Anytv\DashboardBundle\Entity\Offer $offers
     * @return Advertiser
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
     * Set country
     *
     * @param \Anytv\DashboardBundle\Entity\Country $country
     * @return Advertiser
     */
    public function setCountry(\Anytv\DashboardBundle\Entity\Country $country = null)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return \Anytv\DashboardBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }
    
    /**
     * Echo dateAdded string
     *
     * @return \DateTime string 
     */
    public function getDateAddedAsString()
    {
        return date_format($this->created_at, 'Y-m-d');
    }
    
     /**
     * Echo modified string
     *
     * @return \DateTime string 
     */
    public function getDateModifiedAsString()
    {
        return date_format($this->updated_at, 'Y-m-d');
    }
    
    public function __toString() 
    {
      return $this->getCompany();    
    }
}
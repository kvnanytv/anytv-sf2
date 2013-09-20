<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Offer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Anytv\DashboardBundle\Entity\OfferRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Offer
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
     * @ORM\Column(name="offer_id", type="integer")
     */
    private $offerId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min = "3")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;
    
    /**
     * @ORM\ManyToOne(targetEntity="Advertiser", inversedBy="offers")
     * @ORM\JoinColumn(name="advertiser_id", referencedColumnName="id")
     */
    private $advertiser;

    /**
     * @var string
     *
     * @ORM\Column(name="offer_url", type="string", length=510)
     * @Assert\NotBlank()
     * @Assert\Length(min = "5")
     */
    private $offerUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="preview_url", type="string", length=255, nullable=true)
     */
    private $previewUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="protocol", type="string", length=255, nullable=true)
     */
    private $protocol;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     * @Assert\Choice(
     *     choices = { "active", "paused", "pending", "expired", "deleted" },
     *     message = "Choose a valid status."
     * )
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiration_date", type="date", nullable=true)
     */
    private $expirationDate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="payout_type", type="string", length=255, nullable=true)
     */
    private $payout_type;
    
    /**
     * @var string
     *
     * @ORM\Column(name="revenue_type", type="string", length=255, nullable=true)
     */
    private $revenue_type;
    
    /**
     * @var float
     *
     * @ORM\Column(name="default_payout", type="float", nullable=true)
     */
    private $default_payout;
    
    /**
     * @var float
     *
     * @ORM\Column(name="max_payout", type="float", nullable=true)
     */
    private $max_payout;
    
    /**
     * @var float
     *
     * @ORM\Column(name="percent_payout", type="float", nullable=true)
     */
    private $percent_payout;
    
    /**
     * @var float
     *
     * @ORM\Column(name="max_percent_payout", type="float", nullable=true)
     */
    private $max_percent_payout;

    /**
     * @var boolean
     *
     * @ORM\Column(name="tiered_payout", type="boolean", nullable=true)
     */
    private $tiered_payout;
    
    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=255, nullable=true)
     */
    private $currency;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_private", type="boolean", nullable=true)
     */
    private $is_private;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="require_approval", type="boolean", nullable=true)
     */
    private $require_approval;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="require_terms_and_conditions", type="boolean", nullable=true)
     */
    private $require_terms_and_conditions;
    
    /**
     * @var text
     *
     * @ORM\Column(name="terms_and_conditions", type="text", nullable=true)
     */
    private $terms_and_conditions;
    
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
     * @ORM\ManyToMany(targetEntity="OfferGroup", inversedBy="offers")
     */
    protected $offerGroups;
    
    /**
     * @ORM\ManyToMany(targetEntity="OfferCategory", inversedBy="offers")
     */
    protected $offerCategories;
    
    /**
     * @ORM\OneToMany(targetEntity="TrafficReferral", mappedBy="offer")
     */
    private $trafficReferrals;
    
    /**
     * @ORM\ManyToMany(targetEntity="Country", inversedBy="offers")
     */
    protected $countries;
    
    public function __construct()
    {
        $this->offerCategories = new ArrayCollection();
        $this->countries = new ArrayCollection();
        $this->trafficReferrals = new ArrayCollection();
        $this->offerGroups = new ArrayCollection();
    }
    
    /**
     * @var string
     * 
     * @ORM\Column(name="thumbnail", type="string", length=255, nullable=true)
     */
    private $thumbnail;

    public function getAbsolutePath()
    {
        return null === $this->thumbnail
            ? null
            : $this->getUploadRootDir().'/'.$this->thumbnail;
    }

    public function getWebPath()
    {
        return null === $this->thumbnail
            ? null
            : $this->getUploadDir().'/'.$this->thumbnail;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // images should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/offers/thumbnails';
    }
    
    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;
    
    private $temp;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        
        if (isset($this->thumbnail)) {
            $this->temp = $this->thumbnail;
            $this->thumbnail = null;
        } else {
            $this->thumbnail = 'initial';
        }
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            $filename = sha1(uniqid(mt_rand(), true));
            $this->thumbnail = $filename.'.'.$this->getFile()->guessExtension();
        }
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        $this->getFile()->move($this->getUploadRootDir(), $this->thumbnail);

        if (isset($this->temp)) {
            unlink($this->getUploadRootDir().'/'.$this->temp);
            $this->temp = null;
        }
        $this->file = null;
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    
     /**
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return News
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    
        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string 
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
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
     * Set offerId
     *
     * @param integer $offerId
     * @return Offer
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
     * Set name
     *
     * @param string $name
     * @return Offer
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
     * Set description
     *
     * @param string $description
     * @return Offer
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
     * Set offerUrl
     *
     * @param string $offerUrl
     * @return Offer
     */
    public function setOfferUrl($offerUrl)
    {
        $this->offerUrl = $offerUrl;
    
        return $this;
    }

    /**
     * Get offerUrl
     *
     * @return string 
     */
    public function getOfferUrl()
    {
        return $this->offerUrl;
    }

    /**
     * Set previewUrl
     *
     * @param string $previewUrl
     * @return Offer
     */
    public function setPreviewUrl($previewUrl)
    {
        $this->previewUrl = $previewUrl;
    
        return $this;
    }

    /**
     * Get previewUrl
     *
     * @return string 
     */
    public function getPreviewUrl()
    {
        return $this->previewUrl;
    }

    /**
     * Set protocol
     *
     * @param string $protocol
     * @return Offer
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
    
        return $this;
    }

    /**
     * Get protocol
     *
     * @return string 
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Offer
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
     * Set expirationDate
     *
     * @param \DateTime $expirationDate
     * @return Offer
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
    
        return $this;
    }

    /**
     * Get expirationDate
     *
     * @return \DateTime 
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }
    
    /**
     * Echo expirationDate string
     *
     * @return \DateTime string 
     */
    public function getExpirationDateAsString()
    {
        return date_format($this->expirationDate, 'Y-m-d');
    }

    /**
     * Set payout_type
     *
     * @param string $payoutType
     * @return Offer
     */
    public function setPayoutType($payoutType)
    {
        $this->payout_type = $payoutType;
    
        return $this;
    }

    /**
     * Get payout_type
     *
     * @return string 
     */
    public function getPayoutType()
    {
        return $this->payout_type;
    }

    /**
     * Set revenue_type
     *
     * @param string $revenueType
     * @return Offer
     */
    public function setRevenueType($revenueType)
    {
        $this->revenue_type = $revenueType;
    
        return $this;
    }

    /**
     * Get revenue_type
     *
     * @return string 
     */
    public function getRevenueType()
    {
        return $this->revenue_type;
    }

    /**
     * Set default_payout
     *
     * @param float $defaultPayout
     * @return Offer
     */
    public function setDefaultPayout($defaultPayout)
    {
        $this->default_payout = $defaultPayout;
    
        return $this;
    }

    /**
     * Get default_payout
     *
     * @return float 
     */
    public function getDefaultPayout()
    {
        return $this->default_payout;
    }

    /**
     * Set max_payout
     *
     * @param float $maxPayout
     * @return Offer
     */
    public function setMaxPayout($maxPayout)
    {
        $this->max_payout = $maxPayout;
    
        return $this;
    }

    /**
     * Get max_payout
     *
     * @return float 
     */
    public function getMaxPayout()
    {
        return $this->max_payout;
    }

    /**
     * Set percent_payout
     *
     * @param float $percentPayout
     * @return Offer
     */
    public function setPercentPayout($percentPayout)
    {
        $this->percent_payout = $percentPayout;
    
        return $this;
    }

    /**
     * Get percent_payout
     *
     * @return float 
     */
    public function getPercentPayout()
    {
        return $this->percent_payout;
    }

    /**
     * Set max_percent_payout
     *
     * @param float $maxPercentPayout
     * @return Offer
     */
    public function setMaxPercentPayout($maxPercentPayout)
    {
        $this->max_percent_payout = $maxPercentPayout;
    
        return $this;
    }

    /**
     * Get max_percent_payout
     *
     * @return float 
     */
    public function getMaxPercentPayout()
    {
        return $this->max_percent_payout;
    }

    /**
     * Set tiered_payout
     *
     * @param boolean $tieredPayout
     * @return Offer
     */
    public function setTieredPayout($tieredPayout)
    {
        $this->tiered_payout = $tieredPayout;
    
        return $this;
    }

    /**
     * Get tiered_payout
     *
     * @return boolean 
     */
    public function getTieredPayout()
    {
        return $this->tiered_payout;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return Offer
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    
        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set is_private
     *
     * @param boolean $isPrivate
     * @return Offer
     */
    public function setIsPrivate($isPrivate)
    {
        $this->is_private = $isPrivate;
    
        return $this;
    }

    /**
     * Get is_private
     *
     * @return boolean 
     */
    public function getIsPrivate()
    {
        return $this->is_private;
    }

    /**
     * Set require_approval
     *
     * @param boolean $requireApproval
     * @return Offer
     */
    public function setRequireApproval($requireApproval)
    {
        $this->require_approval = $requireApproval;
    
        return $this;
    }

    /**
     * Get require_approval
     *
     * @return boolean 
     */
    public function getRequireApproval()
    {
        return $this->require_approval;
    }

    /**
     * Set require_terms_and_conditions
     *
     * @param boolean $requireTermsAndConditions
     * @return Offer
     */
    public function setRequireTermsAndConditions($requireTermsAndConditions)
    {
        $this->require_terms_and_conditions = $requireTermsAndConditions;
    
        return $this;
    }

    /**
     * Get require_terms_and_conditions
     *
     * @return boolean 
     */
    public function getRequireTermsAndConditions()
    {
        return $this->require_terms_and_conditions;
    }

    /**
     * Set terms_and_conditions
     *
     * @param string $termsAndConditions
     * @return Offer
     */
    public function setTermsAndConditions($termsAndConditions)
    {
        $this->terms_and_conditions = $termsAndConditions;
    
        return $this;
    }

    /**
     * Get terms_and_conditions
     *
     * @return string 
     */
    public function getTermsAndConditions()
    {
        return $this->terms_and_conditions;
    }

    /**
     * Add offerCategories
     *
     * @param \Anytv\DashboardBundle\Entity\OfferCategory $offerCategories
     * @return Offer
     */
    public function addOfferCategorie(\Anytv\DashboardBundle\Entity\OfferCategory $offerCategories)
    {
        $this->offerCategories[] = $offerCategories;
    
        return $this;
    }

    /**
     * Remove offerCategories
     *
     * @param \Anytv\DashboardBundle\Entity\OfferCategory $offerCategories
     */
    public function removeOfferCategorie(\Anytv\DashboardBundle\Entity\OfferCategory $offerCategories)
    {
        $this->offerCategories->removeElement($offerCategories);
    }

    /**
     * Get offerCategories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOfferCategories()
    {
        return $this->offerCategories;
    }
    
    public function getOfferCategoriesNames()
    {
        $offerCategories = $this->getOfferCategories();
        
        $offerCategoriesNames = array();
        
        foreach($offerCategories as $offerCategory)
        {
          $offerCategoriesNames[] = $offerCategory->getName(); 
        }
        
        return implode(', ', $offerCategoriesNames);
    }

    /**
     * Add countries
     *
     * @param \Anytv\DashboardBundle\Entity\Country $countries
     * @return Offer
     */
    public function addCountrie(\Anytv\DashboardBundle\Entity\Country $countries)
    {
        $this->countries[] = $countries;
    
        return $this;
    }

    /**
     * Remove countries
     *
     * @param \Anytv\DashboardBundle\Entity\Country $countries
     */
    public function removeCountrie(\Anytv\DashboardBundle\Entity\Country $countries)
    {
        $this->countries->removeElement($countries);
    }

    /**
     * Get countries
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCountries()
    {
        return $this->countries;
    }
    
    public function getCountriesNames()
    {
        $countries = $this->getCountries();
        
        $countriesNames = array();
        
        foreach($countries as $country)
        {
          $countriesNames[] = $country->getName(); 
        }
        
        return implode(', ', $countriesNames);
    }
    
    public function getCountriesTotal()
    {
        $countries = $this->getCountries();
        
        $total = count($countries);
        
        return $total ? $total : 'All';
    }
    
    

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Offer
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
     * @return Offer
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
    
    /*
     
    preRemove
    postRemove
    prePersist
    postPersist
    preUpdate
    postUpdate
    postLoad
    loadClassMetadata
     
     */

    

    

    /**
     * Set advertiser
     *
     * @param \Anytv\DashboardBundle\Entity\Advertiser $advertiser
     * @return Offer
     */
    public function setAdvertiser(\Anytv\DashboardBundle\Entity\Advertiser $advertiser = null)
    {
        $this->advertiser = $advertiser;
    
        return $this;
    }

    /**
     * Get advertiser
     *
     * @return \Anytv\DashboardBundle\Entity\Advertiser 
     */
    public function getAdvertiser()
    {
        return $this->advertiser;
    }
    
    public function __toString() 
    {
      return $this->getName();    
    }

    /**
     * Add trafficReferrals
     *
     * @param \Anytv\DashboardBundle\Entity\TrafficReferral $trafficReferrals
     * @return Offer
     */
    public function addTrafficReferral(\Anytv\DashboardBundle\Entity\TrafficReferral $trafficReferrals)
    {
        $this->trafficReferrals[] = $trafficReferrals;
    
        return $this;
    }

    /**
     * Remove trafficReferrals
     *
     * @param \Anytv\DashboardBundle\Entity\TrafficReferral $trafficReferrals
     */
    public function removeTrafficReferral(\Anytv\DashboardBundle\Entity\TrafficReferral $trafficReferrals)
    {
        $this->trafficReferrals->removeElement($trafficReferrals);
    }

    /**
     * Get trafficReferrals
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTrafficReferrals()
    {
        return $this->trafficReferrals;
    }

    /**
     * Add offerGroups
     *
     * @param \Anytv\DashboardBundle\Entity\OfferGroup $offerGroups
     * @return Offer
     */
    public function addOfferGroup(\Anytv\DashboardBundle\Entity\OfferGroup $offerGroups)
    {
        $this->offerGroups[] = $offerGroups;
    
        return $this;
    }

    /**
     * Remove offerGroups
     *
     * @param \Anytv\DashboardBundle\Entity\OfferGroup $offerGroups
     */
    public function removeOfferGroup(\Anytv\DashboardBundle\Entity\OfferGroup $offerGroups)
    {
        $this->offerGroups->removeElement($offerGroups);
    }

    /**
     * Get offerGroups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOfferGroups()
    {
        return $this->offerGroups;
    }
}
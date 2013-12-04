<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Affiliate
 *
 * @ORM\Table(name="Affiliate")
 * @ORM\Entity(repositoryClass="Anytv\DashboardBundle\Entity\AffiliateRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Affiliate
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
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=255)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="address1", type="string", length=255)
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
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;
    
    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="affiliates")
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
     * @ORM\Column(name="zipcode", type="string", length=255)
     */
    private $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
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
     * @ORM\Column(name="signup_ip", type="string", length=255, nullable=true)
     */
    private $signupIp;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     * @Assert\Choice(
     *     choices = { "active", "pending", "deleted", "blocked", "rejected" },
     *     message = "Choose a valid status."
     * )
     */
    private $status;

    /**
     * @var boolean
     *
     * @ORM\Column(name="wants_alerts", type="boolean")
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
     * @ORM\Column(name="payment_method", type="string", length=255, nullable=true)
     */
    private $paymentMethod;
    
    /**
     * @var string
     *
     * @ORM\Column(name="paypal_email", type="string", length=100, nullable=true)
     */
    private $paypalEmail;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="paypal_email_requested", type="boolean")
     */
    private $paypalEmailRequested;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="paypal_email_modified", type="datetime", nullable=true)
     */
    private $paypalEmailModified;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="signup_answers_requested", type="boolean")
     */
    private $signupAnswersRequested;

    /**
     * @var integer
     *
     * @ORM\Column(name="referral_id", type="integer", nullable=true)
     */
    private $referralId;
    
    /**
     * @ORM\ManyToOne(targetEntity="Affiliate", inversedBy="referredAffiliates")
     * @ORM\JoinColumn(name="referrer_id", referencedColumnName="id")
     */
    private $referrer;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="referrer_requested", type="boolean")
     */
    private $referrerRequested;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_added", type="datetime")
     */
    private $dateAdded;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime", nullable=true)
     */
    private $modified;
    
    /**
     * @ORM\OneToMany(targetEntity="AffiliateUser", mappedBy="affiliate")
     */
    private $affiliateUsers;
    
    /**
     * @ORM\OneToMany(targetEntity="TrafficReferral", mappedBy="affiliate")
     */
    private $trafficReferrals;
    
    /**
     * @ORM\OneToMany(targetEntity="Conversion", mappedBy="affiliate")
     */
    private $conversions;
    
    /**
     * @ORM\OneToMany(targetEntity="Affiliate", mappedBy="referrer")
     */
    private $referredAffiliates;
    
    /**
     * @ORM\OneToMany(targetEntity="Referral", mappedBy="referred")
     */
    private $referredReferrals;
    
    /**
     * @ORM\OneToMany(targetEntity="SignupAnswer", mappedBy="affiliate")
     */
    private $signupAnswers;
    
    /**
     * @ORM\OneToMany(targetEntity="Referral", mappedBy="referrer")
     */
    private $referrerReferrals;
    
    /**
     * @ORM\OneToMany(targetEntity="YoutubeVideo", mappedBy="affiliate")
     */
    private $youtubeVideos;
    
    public function __construct()
    {
        $this->affiliateUsers = new ArrayCollection();
        $this->trafficReferrals = new ArrayCollection();
        $this->referredAffiliates = new ArrayCollection();
        $this->conversions = new ArrayCollection();
        $this->wantsAlerts = true;
        $this->paypalEmailRequested = false;
        $this->referrerRequested = false;
        $this->signupAnswersRequested = false;
        $this->referredReferrals = new ArrayCollection();
        $this->referrerReferrals = new ArrayCollection();
        $this->signupAnswers = new ArrayCollection();
        $this->youtubeVideos = new ArrayCollection();
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
        return 'uploads/affiliates/thumbnails';
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
     * Set company
     *
     * @param string $company
     * @return Affiliate
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
     * @return Affiliate
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
     * @return Affiliate
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
     * Get full address
     *
     * @return string 
     */
    public function getFullAddress()
    {
        $full_address = '';
        
        if($this->address1)
        {
          $full_address .= $this->address1;    
        }
        
        if($this->address2)
        {
          $full_address .= $full_address ? ' '.$this->address2 : $this->address2;    
        }
        
        if($this->city)
        {
          $full_address .= $full_address ? ' '.$this->city.',' : $this->city.',';    
        }
        
        if($this->country)
        {
          $full_address .= $full_address ? ' '.$this->country : $this->country;    
        }
        elseif($this->other)
        {
          $full_address .= $full_address ? ' '.$this->other : $this->other;    
        }
        
        if($this->zipcode)
        {
          $full_address .= $full_address ? ' '.$this->zipcode : $this->zipcode;    
        }
       
        return $full_address;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Affiliate
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
     * Set other
     *
     * @param string $other
     * @return Affiliate
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
     * Set fax
     *
     * @param string $fax
     * @return Affiliate
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
     * Set signupIp
     *
     * @param string $signupIp
     * @return Affiliate
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
     * @return Affiliate
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
     * @return Affiliate
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
     * @return Affiliate
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
     * Set paymentMethod
     *
     * @param string $paymentMethod
     * @return Affiliate
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    
        return $this;
    }

    /**
     * Get paymentMethod
     *
     * @return string 
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set paymentTerms
     *
     * @param string $paymentTerms
     * @return Affiliate
     */
    public function setPaymentTerms($paymentTerms)
    {
        $this->paymentTerms = $paymentTerms;
    
        return $this;
    }

    /**
     * Get paymentTerms
     *
     * @return string 
     */
    public function getPaymentTerms()
    {
        return $this->paymentTerms;
    }

    /**
     * Set referralId
     *
     * @param integer $referralId
     * @return Affiliate
     */
    public function setReferralId($referralId)
    {
        $this->referralId = $referralId;
    
        return $this;
    }

    /**
     * Get referralId
     *
     * @return integer 
     */
    public function getReferralId()
    {
        return $this->referralId;
    }

    /**
     * Set affiliateTierId
     *
     * @param integer $affiliateTierId
     * @return Affiliate
     */
    public function setAffiliateTierId($affiliateTierId)
    {
        $this->affiliateTierId = $affiliateTierId;
    
        return $this;
    }

    /**
     * Get affiliateTierId
     *
     * @return integer 
     */
    public function getAffiliateTierId()
    {
        return $this->affiliateTierId;
    }

    /**
     * Set dateAdded
     *
     * @param \DateTime $dateAdded
     * @return Affiliate
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;
    
        return $this;
    }

    /**
     * Get dateAdded
     *
     * @return \DateTime 
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     * @return Affiliate
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    
        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime 
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set affiliateId
     *
     * @param integer $affiliateId
     * @return Affiliate
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
     * @ORM\PrePersist
     */
    public function setDatedAddedValue()
    {
      if(!$this->dateAdded)
      {
        $this->dateAdded = new \DateTime();
      }
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setModifiedValue()
    {
      $this->modified = new \DateTime();
    }
    
     /**
     * Echo dateAdded string
     *
     * @return \DateTime string 
     */
    public function getDateAddedAsString()
    {
        return date_format($this->dateAdded, 'Y-m-d');
    }

    /**
     * Set country
     *
     * @param \Anytv\DashboardBundle\Entity\Country $country
     * @return Affiliate
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
    
    public function __toString() 
    {
      return $this->getCompany(); 
    }

    /**
     * Add affiliateUsers
     *
     * @param \Anytv\DashboardBundle\Entity\AffiliateUser $affiliateUsers
     * @return Affiliate
     */
    public function addAffiliateUser(\Anytv\DashboardBundle\Entity\AffiliateUser $affiliateUsers)
    {
        $this->affiliateUsers[] = $affiliateUsers;
    
        return $this;
    }

    /**
     * Remove affiliateUsers
     *
     * @param \Anytv\DashboardBundle\Entity\AffiliateUser $affiliateUsers
     */
    public function removeAffiliateUser(\Anytv\DashboardBundle\Entity\AffiliateUser $affiliateUsers)
    {
        $this->affiliateUsers->removeElement($affiliateUsers);
    }

    /**
     * Get affiliateUsers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAffiliateUsers()
    {
        return $this->affiliateUsers;
    }

    /**
     * Add trafficReferrals
     *
     * @param \Anytv\DashboardBundle\Entity\TrafficReferral $trafficReferrals
     * @return Affiliate
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
     * Set referrer
     *
     * @param \Anytv\DashboardBundle\Entity\Affiliate $referrer
     * @return Affiliate
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
     * Add referredAffiliates
     *
     * @param \Anytv\DashboardBundle\Entity\Affiliate $referredAffiliates
     * @return Affiliate
     */
    public function addReferredAffiliate(\Anytv\DashboardBundle\Entity\Affiliate $referredAffiliates)
    {
        $this->referredAffiliates[] = $referredAffiliates;
    
        return $this;
    }

    /**
     * Remove referredAffiliates
     *
     * @param \Anytv\DashboardBundle\Entity\Affiliate $referredAffiliates
     */
    public function removeReferredAffiliate(\Anytv\DashboardBundle\Entity\Affiliate $referredAffiliates)
    {
        $this->referredAffiliates->removeElement($referredAffiliates);
    }

    /**
     * Get referredAffiliates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReferredAffiliates()
    {
        return $this->referredAffiliates;
    }

    /**
     * Set paypalEmail
     *
     * @param string $paypalEmail
     * @return Affiliate
     */
    public function setPaypalEmail($paypalEmail)
    {
        $this->paypalEmail = $paypalEmail;
    
        return $this;
    }

    /**
     * Get paypalEmail
     *
     * @return string 
     */
    public function getPaypalEmail()
    {
        return $this->paypalEmail;
    }

    /**
     * Set paypalEmailModified
     *
     * @param \DateTime $paypalEmailModified
     * @return Affiliate
     */
    public function setPaypalEmailModified($paypalEmailModified)
    {
        $this->paypalEmailModified = $paypalEmailModified;
    
        return $this;
    }

    /**
     * Get paypalEmailModified
     *
     * @return \DateTime 
     */
    public function getPaypalEmailModified()
    {
        return $this->paypalEmailModified;
    }

    /**
     * Set paypalEmailRequested
     *
     * @param boolean $paypalEmailRequested
     * @return Affiliate
     */
    public function setPaypalEmailRequested($paypalEmailRequested)
    {
        $this->paypalEmailRequested = $paypalEmailRequested;
    
        return $this;
    }

    /**
     * Get paypalEmailRequested
     *
     * @return boolean 
     */
    public function getPaypalEmailRequested()
    {
        return $this->paypalEmailRequested;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     * @return Affiliate
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
     * @return Affiliate
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
        $phone = $this->phone;
        
        if(substr($phone, 0, 3) == '011')
        {
          $phone = substr_replace($phone, '+', 0, 3);
        }
        
        return $phone;
    }

    /**
     * Set referrerRequested
     *
     * @param boolean $referrerRequested
     * @return Affiliate
     */
    public function setReferrerRequested($referrerRequested)
    {
        $this->referrerRequested = $referrerRequested;
    
        return $this;
    }

    /**
     * Get referrerRequested
     *
     * @return boolean 
     */
    public function getReferrerRequested()
    {
        return $this->referrerRequested;
    }

    /**
     * Add conversions
     *
     * @param \Anytv\DashboardBundle\Entity\Conversion $conversions
     * @return Affiliate
     */
    public function addConversion(\Anytv\DashboardBundle\Entity\Conversion $conversions)
    {
        $this->conversions[] = $conversions;
    
        return $this;
    }

    /**
     * Remove conversions
     *
     * @param \Anytv\DashboardBundle\Entity\Conversion $conversions
     */
    public function removeConversion(\Anytv\DashboardBundle\Entity\Conversion $conversions)
    {
        $this->conversions->removeElement($conversions);
    }

    /**
     * Get conversions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getConversions()
    {
        return $this->conversions;
    }

    /**
     * Add referredReferrals
     *
     * @param \Anytv\DashboardBundle\Entity\Referral $referredReferrals
     * @return Affiliate
     */
    public function addReferredReferral(\Anytv\DashboardBundle\Entity\Referral $referredReferrals)
    {
        $this->referredReferrals[] = $referredReferrals;
    
        return $this;
    }

    /**
     * Remove referredReferrals
     *
     * @param \Anytv\DashboardBundle\Entity\Referral $referredReferrals
     */
    public function removeReferredReferral(\Anytv\DashboardBundle\Entity\Referral $referredReferrals)
    {
        $this->referredReferrals->removeElement($referredReferrals);
    }

    /**
     * Get referredReferrals
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReferredReferrals()
    {
        return $this->referredReferrals;
    }

    /**
     * Add referrerReferrals
     *
     * @param \Anytv\DashboardBundle\Entity\Referral $referrerReferrals
     * @return Affiliate
     */
    public function addReferrerReferral(\Anytv\DashboardBundle\Entity\Referral $referrerReferrals)
    {
        $this->referrerReferrals[] = $referrerReferrals;
    
        return $this;
    }

    /**
     * Remove referrerReferrals
     *
     * @param \Anytv\DashboardBundle\Entity\Referral $referrerReferrals
     */
    public function removeReferrerReferral(\Anytv\DashboardBundle\Entity\Referral $referrerReferrals)
    {
        $this->referrerReferrals->removeElement($referrerReferrals);
    }

    /**
     * Get referrerReferrals
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReferrerReferrals()
    {
        return $this->referrerReferrals;
    }

    /**
     * Set signupAnswersRequested
     *
     * @param boolean $signupAnswersRequested
     * @return Affiliate
     */
    public function setSignupAnswersRequested($signupAnswersRequested)
    {
        $this->signupAnswersRequested = $signupAnswersRequested;
    
        return $this;
    }

    /**
     * Get signupAnswersRequested
     *
     * @return boolean 
     */
    public function getSignupAnswersRequested()
    {
        return $this->signupAnswersRequested;
    }

    /**
     * Add signupAnswers
     *
     * @param \Anytv\DashboardBundle\Entity\SignupAnswer $signupAnswers
     * @return Affiliate
     */
    public function addSignupAnswer(\Anytv\DashboardBundle\Entity\SignupAnswer $signupAnswers)
    {
        $this->signupAnswers[] = $signupAnswers;
    
        return $this;
    }

    /**
     * Remove signupAnswers
     *
     * @param \Anytv\DashboardBundle\Entity\SignupAnswer $signupAnswers
     */
    public function removeSignupAnswer(\Anytv\DashboardBundle\Entity\SignupAnswer $signupAnswers)
    {
        $this->signupAnswers->removeElement($signupAnswers);
    }

    /**
     * Get signupAnswers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSignupAnswers()
    {
        return $this->signupAnswers;
    }

    /**
     * Add youtubeVideos
     *
     * @param \Anytv\DashboardBundle\Entity\YoutubeVideo $youtubeVideos
     * @return Affiliate
     */
    public function addYoutubeVideo(\Anytv\DashboardBundle\Entity\YoutubeVideo $youtubeVideos)
    {
        $this->youtubeVideos[] = $youtubeVideos;
    
        return $this;
    }

    /**
     * Remove youtubeVideos
     *
     * @param \Anytv\DashboardBundle\Entity\YoutubeVideo $youtubeVideos
     */
    public function removeYoutubeVideo(\Anytv\DashboardBundle\Entity\YoutubeVideo $youtubeVideos)
    {
        $this->youtubeVideos->removeElement($youtubeVideos);
    }

    /**
     * Get youtubeVideos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getYoutubeVideos()
    {
        return $this->youtubeVideos;
    }
}
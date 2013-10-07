<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Anytv\DashboardBundle\Entity\Affiliate;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * AffiliateUser
 *
 * @ORM\Table(name="AffiliateUser")
 * @ORM\Entity(repositoryClass="Anytv\DashboardBundle\Entity\AffiliateUserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class AffiliateUser implements UserInterface, \Serializable
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
     * @ORM\ManyToOne(targetEntity="Affiliate", inversedBy="affiliateUsers")
     * @ORM\JoinColumn(name="affiliate_id", referencedColumnName="id")
     */
    private $affiliate;

    /**
     * @var integer
     *
     * @ORM\Column(name="affiliate_user_id", type="integer")
     */
    private $affiliateUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;
    
    /**
     * @var string
     *
     * @ORM\Column(name="password_decoded", type="string", length=100, nullable=true)
     */
    private $password_decoded;
    
    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=32)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     * @Assert\Choice(
     *     choices = { "active", "blocked", "deleted" },
     *     message = "Choose a valid status."
     * )
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="cell_phone", type="string", length=255, nullable=true)
     */
    private $cellPhone;

    /**
     * @var boolean
     *
     * @ORM\Column(name="wants_alerts", type="boolean")
     */
    private $wantsAlerts;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_creator", type="boolean", nullable=true)
     */
    private $isCreator;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="join_date", type="datetime")
     */
    private $joinDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime", nullable=true)
     */
    private $modified;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="login_count", type="integer")
     */
    private $loginCount;
    
    /**
     * @var string
     *
     * @ORM\Column(name="login_ip", type="string", length=255, nullable=true)
     */
    private $loginIp;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="login_ip_change_count", type="integer")
     */
    private $loginIpChangeCount;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="show_photo", type="boolean")
     */
    private $showPhoto;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_public", type="boolean")
     */
    private $isPublic;
    
    /**
     * @var string
     *
     * @ORM\Column(name="shoutout", type="string", length=255, nullable=true)
     */
    private $shoutout;
    
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
        return 'uploads/affiliate_users/thumbnails';
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
     * @var boolean
     *
     * @ORM\Column(name="is_admin", type="boolean")
     */
    private $isAdmin;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct()
    {
        $this->isAdmin = false;
        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
        $this->loginCount = 0;
        $this->loginIpChangeCount = 0;
        $this->showPhoto = true;
        $this->isPublic = true;
        $this->wantsAlerts = true;
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
     * Set email
     *
     * @param string $email
     * @return AffiliateUser
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return AffiliateUser
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return AffiliateUser
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return AffiliateUser
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return AffiliateUser
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
     * Set title
     *
     * @param string $title
     * @return AffiliateUser
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return AffiliateUser
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
     * Set cellPhone
     *
     * @param string $cellPhone
     * @return AffiliateUser
     */
    public function setCellPhone($cellPhone)
    {
        $this->cellPhone = $cellPhone;
    
        return $this;
    }

    /**
     * Get cellPhone
     *
     * @return string 
     */
    public function getCellPhone()
    {
        return $this->cellPhone;
    }

    /**
     * Set wantsAlerts
     *
     * @param boolean $wantsAlerts
     * @return AffiliateUser
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
     * Set isCreator
     *
     * @param boolean $isCreator
     * @return AffiliateUser
     */
    public function setIsCreator($isCreator)
    {
        $this->isCreator = $isCreator;
    
        return $this;
    }

    /**
     * Get isCreator
     *
     * @return boolean 
     */
    public function getIsCreator()
    {
        return $this->isCreator;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return AffiliateUser
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set joinDate
     *
     * @param \DateTime $joinDate
     * @return AffiliateUser
     */
    public function setJoinDate($joinDate)
    {
        $this->joinDate = $joinDate;
    
        return $this;
    }

    /**
     * Get joinDate
     *
     * @return \DateTime 
     */
    public function getJoinDate()
    {
        return $this->joinDate;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     * @return AffiliateUser
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
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     * @return AffiliateUser
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    
        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime 
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return AffiliateUser
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set affiliateUserId
     *
     * @param integer $affiliateUserId
     * @return AffiliateUser
     */
    public function setAffiliateUserId($affiliateUserId)
    {
        $this->affiliateUserId = $affiliateUserId;
    
        return $this;
    }

    /**
     * Get affiliateUserId
     *
     * @return integer 
     */
    public function getAffiliateUserId()
    {
        return $this->affiliateUserId;
    }

    /**
     * Set affiliate
     *
     * @param \Anytv\DashboardBundle\Entity\Affiliate $affiliate
     * @return AffiliateUser
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
    
    public function getFullName()
    {
        $full_name = '';
        
        if($this->title)
        {
          $full_name .= $this->title.' ';
        }
        
        if($this->firstName)
        {
          $full_name .= $this->firstName.' ';
        }
        
        if($this->lastName)
        {
          $full_name .= $this->lastName;
        }
        
        return $full_name ? $full_name : $this->getAffiliate()->getCompany();
    }
    
    public function __toString() 
    {
      return $this->getFullName();
    }
    
     /**
     * Echo dateJoined string
     *
     * @return \DateTime string 
     */
    public function getDateJoinedAsString()
    {
        return date_format($this->joinDate, 'Y-m-d');
    }
    
    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->email;
    }
    
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        $roles = array('ROLE_USER');
        
        if($this->isAdmin)
        {
          $roles[] = 'ROLE_ADMIN';   
        }
        
        return $roles;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return AffiliateUser
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set password_decoded
     *
     * @param string $passwordDecoded
     * @return AffiliateUser
     */
    public function setPasswordDecoded($passwordDecoded)
    {
        $this->password_decoded = $passwordDecoded;
    
        return $this;
    }

    /**
     * Get password_decoded
     *
     * @return string 
     */
    public function getPasswordDecoded()
    {
        return $this->password_decoded;
    }

    /**
     * Set isAdmin
     *
     * @param boolean $isAdmin
     * @return AffiliateUser
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    
        return $this;
    }

    /**
     * Get isAdmin
     *
     * @return boolean 
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Set loginCount
     *
     * @param integer $loginCount
     * @return AffiliateUser
     */
    public function setLoginCount($loginCount)
    {
        $this->loginCount = $loginCount;
    
        return $this;
    }

    /**
     * Get loginCount
     *
     * @return integer 
     */
    public function getLoginCount()
    {
        return $this->loginCount;
    }

    /**
     * Set loginIp
     *
     * @param string $loginIp
     * @return AffiliateUser
     */
    public function setLoginIp($loginIp)
    {
        $this->loginIp = $loginIp;
    
        return $this;
    }

    /**
     * Get loginIp
     *
     * @return string 
     */
    public function getLoginIp()
    {
        return $this->loginIp;
    }

    /**
     * Set loginIpChangeCount
     *
     * @param integer $loginIpChangeCount
     * @return AffiliateUser
     */
    public function setLoginIpChangeCount($loginIpChangeCount)
    {
        $this->loginIpChangeCount = $loginIpChangeCount;
    
        return $this;
    }

    /**
     * Get loginIpChangeCount
     *
     * @return integer 
     */
    public function getLoginIpChangeCount()
    {
        return $this->loginIpChangeCount;
    }

    /**
     * Set showPhoto
     *
     * @param boolean $showPhoto
     * @return AffiliateUser
     */
    public function setShowPhoto($showPhoto)
    {
        $this->showPhoto = $showPhoto;
    
        return $this;
    }

    /**
     * Get showPhoto
     *
     * @return boolean 
     */
    public function getShowPhoto()
    {
        return $this->showPhoto;
    }

    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     * @return AffiliateUser
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    
        return $this;
    }

    /**
     * Get isPublic
     *
     * @return boolean 
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * Set shoutout
     *
     * @param string $shoutout
     * @return AffiliateUser
     */
    public function setShoutout($shoutout)
    {
        $this->shoutout = $shoutout;
    
        return $this;
    }

    /**
     * Get shoutout
     *
     * @return string 
     */
    public function getShoutout()
    {
        return $this->shoutout;
    }
}
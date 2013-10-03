<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * OfferGroup
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Anytv\DashboardBundle\Entity\OfferGroupRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class OfferGroup
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
     * @ORM\Column(name="offer_group_id", type="integer")
     */
    private $offerGroupId;

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
     * @ORM\ManyToMany(targetEntity="Offer", mappedBy="offerGroups")
     */
    private $offers;
    
    public function __construct()
    {
        $this->offers = new ArrayCollection();
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
        return 'uploads/offergroups/thumbnails';
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
     * Set name
     *
     * @param string $name
     * @return OfferGroup
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
     * @return OfferGroup
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
     * @return OfferGroup
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
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return OfferGroup
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
     * @return OfferGroup
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
     * Set offerGroupId
     *
     * @param integer $offerGroupId
     * @return OfferGroup
     */
    public function setOfferGroupId($offerGroupId)
    {
        $this->offerGroupId = $offerGroupId;
    
        return $this;
    }

    /**
     * Get offerGroupId
     *
     * @return integer 
     */
    public function getOfferGroupId()
    {
        return $this->offerGroupId;
    }
    
    public function __toString() 
    {
      return $this->getName();    
    }

    /**
     * Add offers
     *
     * @param \Anytv\DashboardBundle\Entity\Offer $offers
     * @return OfferGroup
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
}
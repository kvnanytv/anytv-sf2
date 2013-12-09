<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * YoutubeVideo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Anytv\DashboardBundle\Entity\YoutubeVideoRepository")
 */
class YoutubeVideo
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
     * @ORM\ManyToOne(targetEntity="Affiliate", inversedBy="youtubeVideos")
     * @ORM\JoinColumn(name="affiliate_id", referencedColumnName="id")
     */
    private $affiliate;
    
     /**
     * @ORM\ManyToOne(targetEntity="Offer", inversedBy="youtubeVideos")
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
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="views", type="integer")
     */
    private $views;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="thumbnail", type="string", length=255, nullable=true)
     */
    private $thumbnail;
    
    /**
     * @var \Date
     *
     * @ORM\Column(name="first_stat_date", type="date", nullable=true)
     */
    private $firstStatDate;
    
    /**
     * @var \Date
     *
     * @ORM\Column(name="last_stat_date", type="date", nullable=true)
     */
    private $lastStatDate;
    
    public function __construct()
    {
        $this->clicks = 0;
        $this->conversions = 0;
        $this->likes = 0;
        $this->dislikes = 0;
        $this->count = 0;
        $this->views = 0;
        $this->status = 'active';
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
     * Set url
     *
     * @param string $url
     * @return YoutubeVideo
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
     * @return YoutubeVideo
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
     * @return YoutubeVideo
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
     * @return YoutubeVideo
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
     * @return YoutubeVideo
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
     * Set count
     *
     * @param integer $count
     * @return YoutubeVideo
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
     * Set description
     *
     * @param string $description
     * @return YoutubeVideo
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
     * Set views
     *
     * @param integer $views
     * @return YoutubeVideo
     */
    public function setViews($views)
    {
        $this->views = $views;
    
        return $this;
    }

    /**
     * Get views
     *
     * @return integer 
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return YoutubeVideo
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
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return YoutubeVideo
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
     * Set lastStatDate
     *
     * @param \DateTime $lastStatDate
     * @return YoutubeVideo
     */
    public function setLastStatDate($lastStatDate)
    {
        $this->lastStatDate = $lastStatDate;
    
        return $this;
    }

    /**
     * Get lastStatDate
     *
     * @return \DateTime 
     */
    public function getLastStatDate()
    {
        return $this->lastStatDate;
    }

    /**
     * Set affiliate
     *
     * @param \Anytv\DashboardBundle\Entity\Affiliate $affiliate
     * @return YoutubeVideo
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
     * @return YoutubeVideo
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
    
    /**
     * Echo lastStatDate
     *
     * @return \DateTime string 
     */
    public function getLastStatDateAsString()
    {
        return date_format($this->lastStatDate, 'Y-m-d');
    }

    /**
     * Set firstStatDate
     *
     * @param \DateTime $firstStatDate
     * @return YoutubeVideo
     */
    public function setFirstStatDate($firstStatDate)
    {
        $this->firstStatDate = $firstStatDate;
    
        return $this;
    }

    /**
     * Get firstStatDate
     *
     * @return \DateTime 
     */
    public function getFirstStatDate()
    {
        return $this->firstStatDate;
    }
}
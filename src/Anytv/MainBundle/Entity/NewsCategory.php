<?php

namespace Anytv\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * NewsCategory
 *
 * @ORM\Table(name="NewsCategory")
 * @ORM\Entity(repositoryClass="Anytv\MainBundle\Entity\NewsCategoryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class NewsCategory
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
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="news_count", type="integer", nullable=true)
     */
    private $newsCount;

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
     * @ORM\OneToMany(targetEntity="News", mappedBy="category")
     */
    protected $news;


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
     * @return NewsCategory
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
     * @return NewsCategory
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
     * Set newsCount
     *
     * @param integer $newsCount
     * @return NewsCategory
     */
    public function setNewsCount($newsCount)
    {
        $this->newsCount = $newsCount;
    
        return $this;
    }

    /**
     * Get newsCount
     *
     * @return integer 
     */
    public function getNewsCount()
    {
        return $this->newsCount;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return NewsCategory
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
     * @return NewsCategory
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
     * Constructor
     */
    public function __construct()
    {
        $this->news = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add news
     *
     * @param \Anytv\MainBundle\Entity\News $news
     * @return NewsCategory
     */
    public function addNew(\Anytv\MainBundle\Entity\News $news)
    {
        $this->news[] = $news;
    
        return $this;
    }

    /**
     * Remove news
     *
     * @param \Anytv\MainBundle\Entity\News $news
     */
    public function removeNew(\Anytv\MainBundle\Entity\News $news)
    {
        $this->news->removeElement($news);
    }

    /**
     * Get news
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNews()
    {
        return $this->news;
    }
    
    public function __toString() 
    {
      return $this->getName();    
    }
}
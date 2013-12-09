<?php

namespace Anytv\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Page
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Anytv\MainBundle\Entity\PageRepository")
 */
class Page
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
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="contentZh", type="text", nullable=true)
     */
    private $contentZh;

    /**
     * @var string
     *
     * @ORM\Column(name="contentNl", type="text", nullable=true)
     */
    private $contentNl;

    /**
     * @var string
     *
     * @ORM\Column(name="contentDe", type="text", nullable=true)
     */
    private $contentDe;

    /**
     * @var string
     *
     * @ORM\Column(name="pageKey", type="string", length=20)
     */
    private $pageKey;


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
     * Set title
     *
     * @param string $title
     * @return Page
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
     * Set content
     *
     * @param string $content
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent($locale = 'en')
    {
        $content = '';
        
        switch($locale)
        {
          case 'en':
              $content = $this->content;
              break;
          case 'zh':
              $content = $this->contentZh;
              break;
          case 'nl':
              $content = $this->contentNl;
              break;
          case 'de':
              $content = $this->contentDe;
              break;
        }
        
        return $content ? $content : $this->content;
    }

    /**
     * Set contentZh
     *
     * @param string $contentZh
     * @return Page
     */
    public function setContentZh($contentZh)
    {
        $this->contentZh = $contentZh;
    
        return $this;
    }

    /**
     * Get contentZh
     *
     * @return string 
     */
    public function getContentZh()
    {
        return $this->contentZh;
    }

    /**
     * Set contentNl
     *
     * @param string $contentNl
     * @return Page
     */
    public function setContentNl($contentNl)
    {
        $this->contentNl = $contentNl;
    
        return $this;
    }

    /**
     * Get contentNl
     *
     * @return string 
     */
    public function getContentNl()
    {
        return $this->contentNl;
    }

    /**
     * Set contentDe
     *
     * @param string $contentDe
     * @return Page
     */
    public function setContentDe($contentDe)
    {
        $this->contentDe = $contentDe;
    
        return $this;
    }

    /**
     * Get contentDe
     *
     * @return string 
     */
    public function getContentDe()
    {
        return $this->contentDe;
    }

    /**
     * Set pageKey
     *
     * @param string $pageKey
     * @return Page
     */
    public function setPageKey($pageKey)
    {
        $this->pageKey = $pageKey;
    
        return $this;
    }

    /**
     * Get pageKey
     *
     * @return string 
     */
    public function getPageKey()
    {
        return $this->pageKey;
    }
}
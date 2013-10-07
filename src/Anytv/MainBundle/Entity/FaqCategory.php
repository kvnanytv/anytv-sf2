<?php

namespace Anytv\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * FaqCategory
 *
 * @ORM\Table(name="FaqCategory")
 * @ORM\Entity(repositoryClass="Anytv\MainBundle\Entity\FaqCategoryRepository")
 */
class FaqCategory
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
     * @ORM\ManyToMany(targetEntity="Faq", mappedBy="categories")
     */
    protected $faqs;
    
    public function __construct()
    {
        $this->faqs = new ArrayCollection();
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
     * @return FaqCategory
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
     * Add faqs
     *
     * @param \Anytv\MainBundle\Entity\Faq $faqs
     * @return FaqCategory
     */
    public function addFaq(\Anytv\MainBundle\Entity\Faq $faqs)
    {
        $this->faqs[] = $faqs;
    
        return $this;
    }

    /**
     * Remove faqs
     *
     * @param \Anytv\MainBundle\Entity\Faq $faqs
     */
    public function removeFaq(\Anytv\MainBundle\Entity\Faq $faqs)
    {
        $this->faqs->removeElement($faqs);
    }

    /**
     * Get faqs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFaqs()
    {
        return $this->faqs;
    }
    
    public function __toString() 
    {
      return $this->getName();    
    }
}
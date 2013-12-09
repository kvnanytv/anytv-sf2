<?php

namespace Anytv\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Faq
 *
 * @ORM\Table(name="Faq")
 * @ORM\Entity(repositoryClass="Anytv\MainBundle\Entity\FaqRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Faq
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
     * @ORM\Column(name="question", type="text")
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="answer", type="text")
     */
    private $answer;
    
    /**
     * @var string
     *
     * @ORM\Column(name="question_zh", type="text", nullable=true)
     */
    private $questionZh;

    /**
     * @var string
     *
     * @ORM\Column(name="answer_zh", type="text", nullable=true)
     */
    private $answerZh;
    
    /**
     * @var string
     *
     * @ORM\Column(name="question_nl", type="text", nullable=true)
     */
    private $questionNl;

    /**
     * @var string
     *
     * @ORM\Column(name="answer_nl", type="text", nullable=true)
     */
    private $answerNl;
    
    /**
     * @var string
     *
     * @ORM\Column(name="question_de", type="text", nullable=true)
     */
    private $questionDe;

    /**
     * @var string
     *
     * @ORM\Column(name="answer_de", type="text", nullable=true)
     */
    private $answerDe;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_visible_en", type="boolean")
     */
    private $isVisibleEn;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_visible_zh", type="boolean")
     */
    private $isVisibleZh;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_visible_nl", type="boolean")
     */
    private $isVisibleNl;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_visible_de", type="boolean")
     */
    private $isVisibleDe;

    /**
     * @var integer
     *
     * @ORM\Column(name="sort_order", type="integer", nullable=true)
     */
    private $sortOrder;
    
    /**
     * @ORM\ManyToMany(targetEntity="FaqCategory", inversedBy="faqs")
     */
    protected $categories;

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
    
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->isActive = true;
        $this->isVisibleEn = true;
        $this->isVisibleZh = true;
        $this->isVisibleNl = true;
        $this->isVisibleDe = true;
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
     * Set question
     *
     * @param string $question
     * @return Faq
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return string 
     */
    public function getQuestion($locale = 'en')
    {
        $question = '';
        
        switch($locale)
        {
          case 'en':
              $question = $this->question;
              break;
          case 'zh':
              $question = $this->questionZh;
              break;
          case 'nl':
              $question = $this->questionNl;
              break;
          case 'de':
              $question = $this->questionDe;
              break;
        }
        
        return $question ? $question : $this->question;
    }

    /**
     * Set answer
     *
     * @param string $answer
     * @return Faq
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    
        return $this;
    }

    /**
     * Get answer
     *
     * @return string 
     */
    public function getAnswer($locale = 'en')
    {
        $answer = '';
        
        switch($locale)
        {
          case 'en':
              $answer = $this->answer;
              break;
          case 'zh':
              $answer = $this->answerZh;
              break;
          case 'nl':
              $answer = $this->answerNl;
              break;
          case 'de':
              $answer = $this->answerDe;
              break;
        }
        
        return $answer ? $answer : $this->answer;
    }

    /**
     * Set sortOrder
     *
     * @param integer $sortOrder
     * @return Faq
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    
        return $this;
    }

    /**
     * Get sortOrder
     *
     * @return integer 
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Faq
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
     * @return Faq
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
     * Set category
     *
     * @param \Anytv\MainBundle\Entity\FaqCategory $category
     * @return Faq
     */
    public function setCategory(\Anytv\MainBundle\Entity\FaqCategory $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \Anytv\MainBundle\Entity\FaqCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add categories
     *
     * @param \Anytv\MainBundle\Entity\FaqCategory $categories
     * @return Faq
     */
    public function addCategorie(\Anytv\MainBundle\Entity\FaqCategory $categories)
    {
        $this->categories[] = $categories;
    
        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Anytv\MainBundle\Entity\FaqCategory $categories
     */
    public function removeCategorie(\Anytv\MainBundle\Entity\FaqCategory $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set questionZh
     *
     * @param string $questionZh
     * @return Faq
     */
    public function setQuestionZh($questionZh)
    {
        $this->questionZh = $questionZh;
    
        return $this;
    }

    /**
     * Get questionZh
     *
     * @return string 
     */
    public function getQuestionZh()
    {
        return $this->questionZh;
    }

    /**
     * Set answerZh
     *
     * @param string $answerZh
     * @return Faq
     */
    public function setAnswerZh($answerZh)
    {
        $this->answerZh = $answerZh;
    
        return $this;
    }

    /**
     * Get answerZh
     *
     * @return string 
     */
    public function getAnswerZh()
    {
        return $this->answerZh;
    }

    /**
     * Set questionNl
     *
     * @param string $questionNl
     * @return Faq
     */
    public function setQuestionNl($questionNl)
    {
        $this->questionNl = $questionNl;
    
        return $this;
    }

    /**
     * Get questionNl
     *
     * @return string 
     */
    public function getQuestionNl()
    {
        return $this->questionNl;
    }

    /**
     * Set answerNl
     *
     * @param string $answerNl
     * @return Faq
     */
    public function setAnswerNl($answerNl)
    {
        $this->answerNl = $answerNl;
    
        return $this;
    }

    /**
     * Get answerNl
     *
     * @return string 
     */
    public function getAnswerNl()
    {
        return $this->answerNl;
    }

    /**
     * Set questionDe
     *
     * @param string $questionDe
     * @return Faq
     */
    public function setQuestionDe($questionDe)
    {
        $this->questionDe = $questionDe;
    
        return $this;
    }

    /**
     * Get questionDe
     *
     * @return string 
     */
    public function getQuestionDe()
    {
        return $this->questionDe;
    }

    /**
     * Set answerDe
     *
     * @param string $answerDe
     * @return Faq
     */
    public function setAnswerDe($answerDe)
    {
        $this->answerDe = $answerDe;
    
        return $this;
    }

    /**
     * Get answerDe
     *
     * @return string 
     */
    public function getAnswerDe()
    {
        return $this->answerDe;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Faq
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
    
    public function __toString() 
    {
      return $this->getQuestion();
    }

    /**
     * Set isVisibleEn
     *
     * @param boolean $isVisibleEn
     * @return Faq
     */
    public function setIsVisibleEn($isVisibleEn)
    {
        $this->isVisibleEn = $isVisibleEn;
    
        return $this;
    }

    /**
     * Get isVisibleEn
     *
     * @return boolean 
     */
    public function getIsVisibleEn()
    {
        return $this->isVisibleEn;
    }

    /**
     * Set isVisibleZh
     *
     * @param boolean $isVisibleZh
     * @return Faq
     */
    public function setIsVisibleZh($isVisibleZh)
    {
        $this->isVisibleZh = $isVisibleZh;
    
        return $this;
    }

    /**
     * Get isVisibleZh
     *
     * @return boolean 
     */
    public function getIsVisibleZh()
    {
        return $this->isVisibleZh;
    }

    /**
     * Set isVisibleNl
     *
     * @param boolean $isVisibleNl
     * @return Faq
     */
    public function setIsVisibleNl($isVisibleNl)
    {
        $this->isVisibleNl = $isVisibleNl;
    
        return $this;
    }

    /**
     * Get isVisibleNl
     *
     * @return boolean 
     */
    public function getIsVisibleNl()
    {
        return $this->isVisibleNl;
    }

    /**
     * Set isVisibleDe
     *
     * @param boolean $isVisibleDe
     * @return Faq
     */
    public function setIsVisibleDe($isVisibleDe)
    {
        $this->isVisibleDe = $isVisibleDe;
    
        return $this;
    }

    /**
     * Get isVisibleDe
     *
     * @return boolean 
     */
    public function getIsVisibleDe()
    {
        return $this->isVisibleDe;
    }
}
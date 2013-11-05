<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SignupQuestion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Anytv\DashboardBundle\Entity\SignupQuestionRepository")
 */
class SignupQuestion
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
     * @ORM\Column(name="questionId", type="integer")
     */
    private $questionId;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=255)
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var boolean
     *
     * @ORM\Column(name="required", type="boolean")
     */
    private $required;

    /**
     * @var string
     *
     * @ORM\Column(name="class", type="string", length=255)
     */
    private $class;

    /**
     * @var integer
     *
     * @ORM\Column(name="type_id", type="integer", nullable=true)
     */
    private $typeId;

    /**
     * @var string
     *
     * @ORM\Column(name="class_data", type="text", nullable=true)
     */
    private $classData;
    
    /**
     * @ORM\OneToMany(targetEntity="SignupAnswer", mappedBy="question")
     */
    private $signupAnswers;
    
    public function __construct()
    {
        $this->signupAnswers = new ArrayCollection();
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
     * Set questionId
     *
     * @param integer $questionId
     * @return SignupQuestion
     */
    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;
    
        return $this;
    }

    /**
     * Get questionId
     *
     * @return integer 
     */
    public function getQuestionId()
    {
        return $this->questionId;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return SignupQuestion
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set question
     *
     * @param string $question
     * @return SignupQuestion
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
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return SignupQuestion
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
     * Set required
     *
     * @param boolean $required
     * @return SignupQuestion
     */
    public function setRequired($required)
    {
        $this->required = $required;
    
        return $this;
    }

    /**
     * Get required
     *
     * @return boolean 
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Get required
     *
     * @return boolean 
     */
    public function getRequiredAsString()
    {
        return $this->getRequired() ? 'Yes':'No';
    }
    
    /**
     * Set class
     *
     * @param string $class
     * @return SignupQuestion
     */
    public function setClass($class)
    {
        $this->class = $class;
    
        return $this;
    }

    /**
     * Get class
     *
     * @return string 
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set typeId
     *
     * @param integer $typeId
     * @return SignupQuestion
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
    
        return $this;
    }

    /**
     * Get typeId
     *
     * @return integer 
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Set classData
     *
     * @param string $classData
     * @return SignupQuestion
     */
    public function setClassData($classData)
    {
        $this->classData = $classData;
    
        return $this;
    }

    /**
     * Get classData
     *
     * @return string 
     */
    public function getClassData()
    {
        return $this->classData;
    }

    /**
     * Add signupAnswers
     *
     * @param \Anytv\DashboardBundle\Entity\SignupAnswer $signupAnswers
     * @return SignupQuestion
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
    
    public function __toString() 
    {
      return $this->getQuestion(); 
    }
}
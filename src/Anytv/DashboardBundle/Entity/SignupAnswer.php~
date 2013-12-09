<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SignupAnswer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Anytv\DashboardBundle\Entity\SignupAnswerRepository")
 */
class SignupAnswer
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
     * @ORM\Column(name="answerId", type="integer")
     */
    private $answerId;

   /**
     * @ORM\ManyToOne(targetEntity="SignupQuestion", inversedBy="signupAnswers")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    private $question;
    
    private $questionTranslated;

    /**
     * @var string
     *
     * @ORM\Column(name="answer", type="text")
     */
    private $answer;

    /**
     * @ORM\ManyToOne(targetEntity="Affiliate", inversedBy="signupAnswers")
     * @ORM\JoinColumn(name="affiliate_id", referencedColumnName="id")
     */
    private $affiliate;

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
     * Set answerId
     *
     * @param integer $answerId
     * @return SignupAnswer
     */
    public function setAnswerId($answerId)
    {
        $this->answerId = $answerId;
    
        return $this;
    }

    /**
     * Get answerId
     *
     * @return integer 
     */
    public function getAnswerId()
    {
        return $this->answerId;
    }

    /**
     * Set signupQuestionId
     *
     * @param integer $signupQuestionId
     * @return SignupAnswer
     */
    public function setSignupQuestionId($signupQuestionId)
    {
        $this->signupQuestionId = $signupQuestionId;
    
        return $this;
    }

    /**
     * Get signupQuestionId
     *
     * @return integer 
     */
    public function getSignupQuestionId()
    {
        return $this->signupQuestionId;
    }

    /**
     * Set answer
     *
     * @param string $answer
     * @return SignupAnswer
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
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set question
     *
     * @param \Anytv\DashboardBundle\Entity\SignupQuestion $question
     * @return SignupAnswer
     */
    public function setQuestion(\Anytv\DashboardBundle\Entity\SignupQuestion $question = null)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return \Anytv\DashboardBundle\Entity\SignupQuestion 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set affiliate
     *
     * @param \Anytv\DashboardBundle\Entity\Affiliate $affiliate
     * @return SignupAnswer
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
     * Set questionTranslated
     *
     * @param string $question
     * @return string
     */
    public function setQuestionTranslated($question)
    {
        $this->questionTranslated = $question;
    
        return $this;
    }

    /**
     * Get questionTranslated
     *
     * @return string 
     */
    public function getQuestionTranslated()
    {
        return $this->questionTranslated;
    }
}
<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrafficReferralVote
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Anytv\DashboardBundle\Entity\TrafficReferralVoteRepository")
 */
class TrafficReferralVote
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
     * @ORM\Column(name="affiliate_user_id", type="integer")
     */
    private $affiliateUserId;

    /**
     * @var integer
     *
     * @ORM\Column(name="traffic_referral_id", type="integer")
     */
    private $trafficReferralId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="vote", type="boolean")
     */
    private $vote;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;


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
     * Set affiliateUserId
     *
     * @param integer $affiliateUserId
     * @return TrafficReferralVote
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
     * Set trafficReferralId
     *
     * @param integer $trafficReferralId
     * @return TrafficReferralVote
     */
    public function setTrafficReferralId($trafficReferralId)
    {
        $this->trafficReferralId = $trafficReferralId;
    
        return $this;
    }

    /**
     * Get trafficReferralId
     *
     * @return integer 
     */
    public function getTrafficReferralId()
    {
        return $this->trafficReferralId;
    }

    /**
     * Set vote
     *
     * @param boolean $vote
     * @return TrafficReferralVote
     */
    public function setVote($vote)
    {
        $this->vote = $vote;
    
        return $this;
    }

    /**
     * Get vote
     *
     * @return boolean 
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return TrafficReferralVote
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
}
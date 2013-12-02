<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ReferralRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReferralRepository extends EntityRepository
{
    public function findAllReferrals($page, $items_per_page, $order_by, $order, $referrer = null, $referral_hide_zeros = false, $start_date = null, $end_date = null)
    {
        $first_result = ($items_per_page * ($page-1));
        
        $query = $this->createQueryBuilder('r');
        
        if($referrer)
        {
          $where = "r.referrer = :referrer";
          $params = array('referrer'=>$referrer);
          
          if($referral_hide_zeros)
          {
            $where .= " AND r.amount > :min_amount";
            $params['min_amount'] = 0;
          }
          
          if($start_date)
          {
            $where .= " AND r.date >= :start_date";
            $params['start_date'] = $start_date;    
          }
          
          if($end_date)
          {
            $where .= " AND r.date <= :end_date";
            $params['end_date'] = $end_date;    
          }
        
          $query = $query->where($where)
                         ->setParameters($params)
                         ->setFirstResult($first_result)
                         ->setMaxResults($items_per_page)
                         ->orderBy('r.'.$order_by, $order)
                         ->getQuery();  
        }
        else
        {
          $query = $query->setFirstResult($first_result)
                         ->setMaxResults($items_per_page)
                         ->orderBy('r.'.$order_by, $order)
                         ->getQuery();  
        }
          
        return $query->getResult();
    }
    
    public function countAllReferrals($referrer = null, $referral_hide_zeros = false, $start_date = null, $end_date = null)
    {    
        $query = $this->createQueryBuilder('r')
                      ->select('count(r.id)');
        
        if($referrer)
        {
          $where = "r.referrer = :referrer";
          $params = array('referrer'=>$referrer);
          
          if($referral_hide_zeros)
          {
            $where .= " AND r.amount > :min_amount";
            $params['min_amount'] = 0;
          }
          
          if($start_date)
          {
            $where .= " AND r.date >= :start_date";
            $params['start_date'] = $start_date;    
          }
          
          if($end_date)
          {
            $where .= " AND r.date <= :end_date";
            $params['end_date'] = $end_date;    
          }
          
          $query = $query->where($where)
                         ->setParameters($params)
                         ->getQuery();
        }
        else
        {
          $query = $query->getQuery(); 
        } 
          
        return $query->getSingleScalarResult();
    }
    
    public function getMaxReferralDate()
    {    
        $query = $this->createQueryBuilder('r')
                      ->select('max(r.date)')
                      ->getQuery();
        
        return $query->getSingleScalarResult();
    }
    
    public function findAllAffiliateReferrals($order_by, $order, $referrer, $referral_hide_zeros = false, $start_date = null, $end_date = null)
    {
        $query = $this->createQueryBuilder('r');
        
        $where = "r.referrer = :referrer";
        $params = array('referrer'=>$referrer);
          
        if($referral_hide_zeros)
        {
          $where .= " AND r.amount > :min_amount";
          $params['min_amount'] = 0;
        }
          
        $where .= " AND r.date >= :start_date";
        $params['start_date'] = $start_date;      
        
        $where .= " AND r.date <= :end_date";
        $params['end_date'] = $end_date;    
        
        $query = $query->where($where)
                       ->setParameters($params)
                       ->orderBy('r.'.$order_by, $order)
                       ->getQuery();  
        
        return $query->getResult();
    }
    
    public function findAllReferralsForGraph($order_by, $order, $referrer = null, $referral_hide_zeros = false, $start_date = null, $end_date = null)
    {
        $query = $this->createQueryBuilder('r');
        
        $where = "r.referrer = :referrer";
        $params = array('referrer'=>$referrer);
          
        if($referral_hide_zeros)
        {
          $where .= " AND r.amount > :min_amount";
          $params['min_amount'] = 0;
        }
          
        $where .= " AND r.date >= :start_date";
        $params['start_date'] = $start_date;      
        
        $where .= " AND r.date <= :end_date";
        $params['end_date'] = $end_date;    
        
        $query = $query->where($where)
                       ->setParameters($params)
                       ->orderBy('r.'.$order_by, $order)
                       ->getQuery();  
        
        return $query->getResult();
    }
}

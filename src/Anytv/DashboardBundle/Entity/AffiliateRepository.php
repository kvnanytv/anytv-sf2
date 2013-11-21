<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AffiliateRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AffiliateRepository extends EntityRepository
{
    public function findAllAffiliates($page, $items_per_page, $order_by, $order, $keyword, $country_id, $status, $with_paypal)
    {
        $first_result = ($items_per_page * ($page-1));
        
        $query = $this->createQueryBuilder('a')
                      ->leftJoin('a.country', 'c');
        
        $where = "a.status = :status";
        $params = array('status'=>$status);
        
        if($keyword)
        {
          $where .= " AND a.company LIKE :keyword";
          $params['keyword'] = "%$keyword%"; 
        }
        
        if($country_id)
        {
          $where .= " AND c.id = :country_id";
          $params['country_id'] = $country_id; 
        }
        
        if($with_paypal)
        {
          $where .= " AND a.paypalEmail IS NOT NULL";
        }
        
        $query = $query->where($where)
                       ->setParameters($params)
                       ->setFirstResult($first_result)
                       ->setMaxResults($items_per_page)
                       ->orderBy('a.'.$order_by, $order)
                       ->getQuery();
          
        return $query->getResult();
    }
    
    public function countAllAffiliates($keyword, $country_id, $status, $with_paypal)
    {    
        $query = $this->createQueryBuilder('a')
                      ->select('count(a.id)')
                      ->leftJoin('a.country', 'c');
        
        $where = "a.status = :status";
        $params = array('status'=>$status);
        
        if($keyword)
        {
          $where .= " AND a.company LIKE :keyword";
          $params['keyword'] = "%$keyword%"; 
        }
        
        if($country_id)
        {
          $where .= " AND c.id = :country_id";
          $params['country_id'] = $country_id; 
        }
        
        if($with_paypal)
        {
          $where .= " AND a.paypalEmail IS NOT NULL";
        }
        
        $query = $query->where($where)
                       ->setParameters($params)
                       ->getQuery(); 
          
        return $query->getSingleScalarResult();
    }
    
    public function findAllAffiliatesByCountry($country_id, $status)
    {
      $query = $this->getEntityManager()->createQueryBuilder()
          ->select(array('a', 'c'))
          ->from('Anytv\DashboardBundle\Entity\Affiliate', 'a')
          ->leftJoin('a.country', 'c')
          ->where("a.status = :status AND c.id = :country_id")
          ->setParameters(array('country_id' => $country_id, 'status' => $status))
          ->orderBy('a.company', 'ASC')
          ->getQuery();   
      
      return $query->getResult();
    }
    
    public function getMaxAffiliateId()
    {    
        $query = $this->createQueryBuilder('a')
                      ->select('max(a.affiliateId)')
                      ->getQuery();
        
        return $query->getSingleScalarResult();
    }
    
    public function findAllAffiliatesByReferrer($referrer, $page, $items_per_page, $order_by, $order)
    {
        $first_result = ($items_per_page * ($page-1));
        
        $query = $this->createQueryBuilder('a');
        
        $where = "a.status = :status AND a.referrer = :referrer";
        $params = array('status'=>'active', 'referrer'=>$referrer);
        
        $query = $query->where($where)
                       ->setParameters($params)
                       ->setFirstResult($first_result)
                       ->setMaxResults($items_per_page)
                       ->orderBy('a.'.$order_by, $order)
                       ->getQuery();
          
        return $query->getResult();
    }
    
    public function countAllAffiliatesByReferrer($referrer)
    {    
        $query = $this->createQueryBuilder('a')
                      ->select('count(a.id)');
        
        $where = "a.status = :status AND a.referrer = :referrer";
        $params = array('status'=>'active', 'referrer'=>$referrer);
        
        $query = $query->where($where)
                       ->setParameters($params)
                       ->getQuery(); 
          
        return $query->getSingleScalarResult();
    }
}
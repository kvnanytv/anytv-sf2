<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * YoutubeVideoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class YoutubeVideoRepository extends EntityRepository
{
    public function getMaxYoutubeVideoDate()
    {    
        $query = $this->createQueryBuilder('yv')
                      ->select('max(yv.lastStatDate)')
                      ->getQuery();
        
        return $query->getSingleScalarResult();
    }
   
    public function findAllYoutubeVideosFiltered($page, $items_per_page, $order_by, $order_by_2, $order, $affiliate = null)
    {
      $first_result = ($items_per_page * ($page-1));
        
      $query = $this->createQueryBuilder('yv');
      
      if($affiliate)
      {
        $query = $query->where("yv.affiliate = :affiliate")
                       ->setParameters(array("affiliate"=>$affiliate))
                       ->setFirstResult($first_result)
                       ->setMaxResults($items_per_page)
                       ->addOrderBy('yv.'.$order_by, $order)
                       ->addOrderBy('yv.'.$order_by_2, $order)
                       ->getQuery();   
      }
      else
      {
        $query = $query->setFirstResult($first_result)
                       ->setMaxResults($items_per_page)
                       ->addOrderBy('yv.'.$order_by, $order)
                       ->addOrderBy('yv.'.$order_by_2, $order)
                       ->getQuery();
      }
          
      return $query->getResult();
    }
    
    public function countAllYoutubeVideosFiltered($affiliate = null)
    {    
        if($affiliate)
      {
        $query = $this->createQueryBuilder('yv')
                      ->select('count(yv.id)')
                      ->where("yv.affiliate = :affiliate")
                       ->setParameters(array("affiliate"=>$affiliate));
      }
      else
      {
        $query = $this->createQueryBuilder('yv')
                      ->select('count(yv.id)');
      } 
        
        
        $query = $query->getQuery(); 
          
        return $query->getSingleScalarResult();
    }
}

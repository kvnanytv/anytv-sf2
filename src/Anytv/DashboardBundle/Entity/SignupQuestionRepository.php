<?php

namespace Anytv\DashboardBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SignupQuestionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SignupQuestionRepository extends EntityRepository
{
    public function findAllSignupQuestions($order_by, $order)
    {
        $query = $this->createQueryBuilder('sq')
                      ->orderBy('sq.'.$order_by, $order)
                      ->getQuery();
          
        return $query->getResult();
    }
}

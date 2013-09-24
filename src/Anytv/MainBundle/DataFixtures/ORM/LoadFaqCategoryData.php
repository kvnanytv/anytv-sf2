<?php

namespace Anytv\MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Anytv\MainBundle\Entity\FaqCategory;

class LoadFaqCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $faq_categories = array('any.TV', 'Dashboard', 'Marketing', 'Partnership', 'Payments');
        
        foreach($faq_categories as $faq_category_item)
        {
          $faq_category = new FaqCategory();
          $faq_category->setName($faq_category_item);

          $manager->persist($faq_category);
          
          $this->addReference('faq_category_'.$faq_category_item, $faq_category);
        }

        $manager->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 51; // the order in which fixtures will be loaded
    }
}

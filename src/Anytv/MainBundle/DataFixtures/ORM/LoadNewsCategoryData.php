<?php

namespace Anytv\MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Anytv\MainBundle\Entity\NewsCategory;

class LoadNewsCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $news_categories = array();
        
        $news_categories[] = array('name'=>'Games',
                        'description'=>'Any.TV Games'
                       );
        
        $news_categories[] = array('name'=>'Music',
                        'description'=>'Any.TV Music'
                       );
        
        $news_categories[] = array('name'=>'Travel',
                        'description'=>'Any.TV Travel'
                       );
        
        $news_categories[] = array('name'=>'Sports',
                        'description'=>'Any.TV Sports'
                       );
       
        $news_categories[] = array('name'=>'Entertainment',
                        'description'=>'Any.TV Entertainment'
                       );
        
        foreach($news_categories as $news_category_item)
        {
          $news_category = new NewsCategory();
          $news_category->setName($news_category_item['name']);
          $news_category->setDescription($news_category_item['description']);

          $manager->persist($news_category);
          
          $this->addReference('news_category_'.$news_category_item['name'], $news_category);
        }

        $manager->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 49; // the order in which fixtures will be loaded
    }
}

<?php

namespace Anytv\MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Anytv\MainBundle\Entity\News;

class LoadNewsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $news = array();
        
        $news[] = array('title'=>'Welcome to Any.TV',
                        'excerpt'=>'Believe in you!',
                        'body'=>'A new kind of YouTube Network',
                        'category'=>'Entertainment'
                       );
        $news[] = array('title'=>'Welcome to Dashboard.TM',
                        'excerpt'=>'Be a Partner!',
                        'body'=>'Earn about $1.00 every time someone new plays a game after watching your video or live stream!',
                        'category'=>'Games'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        $news[] = array('title'=>'Welcome to Community.TM',
                        'excerpt'=>'Welcome to the family!',
                        'body'=>'Get Official News and Announcements here.',
                        'category'=>'Sports'
                       );
        
        foreach($news as $news_element)
        {
          $news_item = new News();
          $news_item->setTitle($news_element['title']);
          $news_item->setExcerpt($news_element['excerpt']);
          $news_item->setBody($news_element['body']);
          
          if($this->hasReference('news_category_'.$news_element['category']))
          {
            $news_item->setCategory($this->getReference('news_category_'.$news_element['category'])); 
          }
          
          $news_item->setViewCount(0);
          $news_item->setCommentCount(0);

          $manager->persist($news_item);
        }

        $manager->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 50; // the order in which fixtures will be loaded
    }
}

<?php

namespace Anytv\MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Anytv\MainBundle\Entity\Page;

class LoadPageData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $pages = array();
        
        $pages[] = array('page_key'=>'about_anytv',
                         'title'=>'What is any.TV?'
                        );
        
        $pages[] = array('page_key'=>'branding_kit',
                         'title'=>'Branding Kit'
                        );
        
        $pages[] = array('page_key'=>'live_stream_handbook',
                         'title'=>'Live Stream Handbook'
                        );
        
        $pages[] = array('page_key'=>'recruiter_handbook',
                         'title'=>'Recruiter Handbook'
                        );
        
        $pages[] = array('page_key'=>'join_our_twitch_team',
                         'title'=>'Join our Twitch Team!'
                        );
        
        $pages[] = array('page_key'=>'staff',
                         'title'=>'Staff'
                        );
        
        $pages[] = array('page_key'=>'terms_and_conditions',
                         'title'=>'Terms & Conditions'
                        );
        
        $pages[] = array('page_key'=>'privacy_policy',
                         'title'=>'Privacy Policy'
                        );
        
        $pages[] = array('page_key'=>'faq_spreadsheet',
                         'title'=>'FAQ Spreadsheet'
                        );
        
        $pages[] = array('page_key'=>'upload',
                         'title'=>'Get paid $5 per video submitted to any.TV!'
                        );
        
        $pages[] = array('page_key'=>'emotionvfx',
                         'title'=>'EmotionVFX'
                        );
        
        foreach($pages as $page_item)
        {
          $page = new Page();
          $page->setPageKey($page_item['page_key']);
          $page->setTitle($page_item['title']);
          
          $manager->persist($page);
        }

        $manager->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 40; // the order in which fixtures will be loaded
    }
}

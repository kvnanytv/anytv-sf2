<?php

namespace Anytv\DashboardBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Anytv\DashboardBundle\Entity\OfferGroup;

class LoadOfferGroupData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $offerGroup = new OfferGroup();
        $offerGroup->setName('Divine Souls Group');
        $offerGroup->setStatus('active');
        $offerGroup->setOfferCount(1);

        $manager->persist($offerGroup);
        $manager->flush();
        
        $this->addReference('ds-og', $offerGroup);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}

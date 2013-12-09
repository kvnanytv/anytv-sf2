<?php

namespace Anytv\DashboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Anytv\DashboardBundle\Entity\Conversion;

class UpdateConversionsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('anytv:update_conversions')
            ->setDescription('Updating Conversions from Hasoffers to database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = 'Updating Conversions from Hasoffers to database.';
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $repository = $doctrine->getRepository('AnytvDashboardBundle:Conversion');
        $affiliate_repository = $doctrine->getRepository('AnytvDashboardBundle:Affiliate');
        $offer_repository = $doctrine->getRepository('AnytvDashboardBundle:Offer');
        $manager = $doctrine->getManager();
        
        $max_conversion_id = $repository->getMaxConversionId();
          
        $hasoffers = $container->get('hasoffers');
        $conversions_data = $hasoffers->getConversions($max_conversion_id);
        
        $new_conversions = 0;
        foreach($conversions_data as $conversion_data)
        {
          $conversion_object = $conversion_data->Stat;
          
          $affiliate = $affiliate_repository->findOneBy(array('affiliateId'=>$conversion_object->affiliate_id));
          $offer = $offer_repository->findOneBy(array('offerId'=>$conversion_object->offer_id));
          
          if($affiliate && $offer)
          {   
            $conversion = new Conversion();
            $conversion->setConversionId($conversion_object->id);
            $conversion->setIp($conversion_object->ip);
            $conversion->setTransactionId($conversion_object->ad_id);
            $conversion->setStatus($conversion_object->status);
            $conversion->setPayout($conversion_object->payout);
            $conversion->setRevenue($conversion_object->revenue);
            if($conversion_object->source)
            {
              $conversion->setSource($conversion_object->source);
            }
            if($conversion_object->refer)
            {
              $conversion->setRefer($conversion_object->refer);
            }
            if($conversion_object->pixel_refer)
            {
              $conversion->setPixelRefer($conversion_object->pixel_refer);
            }
            $conversion->setSaleAmount($conversion_object->sale_amount);
            $conversion->setIsAdjustment($conversion_object->is_adjustment);
            $conversion->setCreatedAt(new \DateTime($conversion_object->datetime));
            $conversion->setAffiliate($affiliate);    
            $conversion->setOffer($offer);
            
            $manager->persist($conversion);
          
            $new_conversions++;
          }
        }

        $manager->flush();
                
        $output->writeln($text);
        $output->writeln($new_conversions.' new Conversions added.');
    }
}

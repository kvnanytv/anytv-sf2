<?php

namespace Anytv\DashboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Anytv\DashboardBundle\Entity\Affiliate;
use Anytv\DashboardBundle\Entity\AffiliateUser;

class UpdateAffiliatesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('anytv:update_affiliates')
            ->setDescription('Updating Affiliates from Hasoffers to database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = 'Updating Affiliates from Hasoffers to database.';
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $repository = $doctrine->getRepository('AnytvDashboardBundle:Affiliate');
        $country_repository = $doctrine->getRepository('AnytvDashboardBundle:Country');
        $manager = $doctrine->getManager();
        
        $max_affiliate_id = $repository->getMaxAffiliateId();
          
        $hasoffers = $container->get('hasoffers');
        $affiliates_data = $hasoffers->getAffiliates($max_affiliate_id);
        
        $new_affiliates = 0;
        foreach($affiliates_data as $affiliate_data)
        {
          $affiliate_object = $affiliate_data->Affiliate;
          $affiliate_users_object = $affiliate_data->AffiliateUser;
              
          $affiliate = new Affiliate();
          $affiliate->setAffiliateId($affiliate_object->id);
          $affiliate->setCompany($affiliate_object->company);
          $affiliate->setAddress1($affiliate_object->address1);
          $affiliate->setAddress2($affiliate_object->address2);
          $affiliate->setCity($affiliate_object->city);
               
          if($country = $country_repository->findOneByCode($affiliate_object->country))
          {
            $affiliate->setCountry($country); 
          } 
          
          $affiliate->setOther($affiliate_object->other);
          $affiliate->setZipcode($affiliate_object->zipcode);
          $affiliate->setPhone($affiliate_object->phone);
          $affiliate->setFax($affiliate_object->fax);
          $affiliate->setSignupIp($affiliate_object->signup_ip);
          $affiliate->setDateAdded(new \DateTime($affiliate_object->date_added));
          $affiliate->setStatus($affiliate_object->status);
          $affiliate->setWantsAlerts($affiliate_object->wants_alerts);
          $affiliate->setPaymentMethod($affiliate_object->payment_method);
          $affiliate->setPaymentTerms($affiliate_object->payment_terms);
          $affiliate->setReferralId($affiliate_object->referral_id);
          
          if($affiliate_object->referral_id && ($referrer = $repository->findOneBy(array('affiliateId'=>$affiliate_object->referral_id))))
          {
            $affiliate->setReferrer($referrer);
          }
          $affiliate->setReferrerRequested(true);
               
          $affiliate->setAffiliateTierId($affiliate_object->affiliate_tier_id);
          
          $manager->persist($affiliate); 
          
          $new_affiliates++;
                
          foreach($affiliate_users_object as $affiliate_user_object)
          {
         
            $affiliate_user = new AffiliateUser(); 
            $affiliate_user->setAffiliateUserId($affiliate_user_object->id);
            $affiliate_user->setEmail($affiliate_user_object->email);     
            $affiliate_user->setTitle($affiliate_user_object->title);
            $affiliate_user->setFirstName($affiliate_user_object->first_name);
            $affiliate_user->setLastName($affiliate_user_object->last_name);
            $affiliate_user->setPhone($affiliate_user_object->phone);
            $affiliate_user->setCellPhone($affiliate_user_object->cell_phone);
            $affiliate_user->setStatus($affiliate_user_object->status);
            $affiliate_user->setIsCreator($affiliate_user_object->is_creator);
            $affiliate_user->setJoinDate(new \DateTime($affiliate_user_object->join_date));
            $affiliate_user->setModified(new \DateTime($affiliate_user_object->modified));
            $affiliate_user->setLastLogin(new \DateTime($affiliate_user_object->last_login));
            $affiliate_user->setWantsAlerts($affiliate_user_object->wants_alerts);
          
            $affiliate_user->setAffiliate($affiliate); 
                    
            if($affiliate_object->status != 'active')
            {
              $affiliate_user->setIsActive(false);    
            }
             
            $manager->persist($affiliate_user);        
          } 
        }

        $manager->flush();
                
        $output->writeln($text);
        $output->writeln($new_affiliates.' new Affiliates added.');
    }
}

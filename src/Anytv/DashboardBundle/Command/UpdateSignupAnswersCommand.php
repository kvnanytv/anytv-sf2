<?php

namespace Anytv\DashboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Anytv\DashboardBundle\Entity\SignupAnswer;

class UpdateSignupAnswersCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('anytv:update_signup_answers')
            ->setDescription('Updating SignupAnswers from Hasoffers to database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = 'Updating SignupAnswers from Hasoffers to database.';
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $repository = $doctrine->getRepository('AnytvDashboardBundle:SignupAnswer');
        $affiliate_repository = $doctrine->getRepository('AnytvDashboardBundle:Affiliate');
        $question_repository = $doctrine->getRepository('AnytvDashboardBundle:SignupQuestion');
        $manager = $doctrine->getManager();
         
        $hasoffers = $container->get('hasoffers');
        
        $new_signup_answers = 0;
        $answers_request_batch = 50;
            
        $signup_answers_wo_answers = $affiliate_repository->findBy(array('status'=>'active', 'signupAnswersRequested'=>false), null, $answers_request_batch);
        
        if($signup_answers_wo_answers)
        {
          foreach($signup_answers_wo_answers as $affiliate)
          {
            $signup_answers_response = $hasoffers->getSignupAnswers($affiliate->getAffiliateId());
                
            if(($signup_answers_response->status == 1) && $signup_answers_response->data)
            {
              $signup_answers_data = (array) $signup_answers_response->data;
                  
              if($signup_answers_data)
              {
                foreach($signup_answers_data as $signup_answer_data)
                {
                  $signup_answer_object = $signup_answer_data->SignupAnswer;
                      
                  $signup_answer = new SignupAnswer();
                  $signup_answer->setAnswerId($signup_answer_object->id);
                  $signup_answer->setAnswer($signup_answer_object->answer);
                      
                  if($question = $question_repository->findOneByQuestionId($signup_answer_object->question_id))
                  {
                    $signup_answer->setQuestion($question);  
                  } 
                      
                  if($affiliate = $affiliate_repository->findOneByAffiliateId($signup_answer_object->responder_id))
                  {
                    $signup_answer->setAffiliate($affiliate);
                  } 
                      
                  $manager->persist($signup_answer); 
                  
                  $new_signup_answers++;
                }
              }
            }
                
            $affiliate->setSignupAnswersRequested(true);   
          }
            
          $manager->flush();  
               
        }
                
        $output->writeln($text);
        $output->writeln($new_signup_answers.' new SignupAnswers added.');
    }
}

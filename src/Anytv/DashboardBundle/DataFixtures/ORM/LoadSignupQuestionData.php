<?php

namespace Anytv\DashboardBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Anytv\DashboardBundle\Entity\SignupQuestion;

class LoadSignupQuestionData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $base = 'https://api.hasoffers.com/Api?';
 
        $params = array(
	  'Format' => 'json'
	  ,'Target' => 'Affiliate'
	  ,'Method' => 'getSignupQuestions'
	  ,'Service' => 'HasOffers'
	  ,'Version' => 2
	  ,'NetworkId' => 'mmotm'
	  ,'NetworkToken' => 'NETjE4MoLg7NarETCDruHecVmgLHbN'
        );
 
        $url = $base . http_build_query( $params );
 
        $result = file_get_contents( $url );
        
        $signup_questions_result = (array) json_decode( $result );
        $signup_questions_response = (array) $signup_questions_result['response'];
        $signup_questions_data = (array) $signup_questions_response['data'];
        
        foreach($signup_questions_data as $signup_question_data)
        {
          $signup_question_object = $signup_question_data->SignupQuestion;
          
          $signup_question = new SignupQuestion();
          $signup_question->setQuestionId($signup_question_object->id);
          $signup_question->setType($signup_question_object->type);
          $signup_question->setQuestion($signup_question_object->question);
          $signup_question->setStatus($signup_question_object->status);
          $signup_question->setRequired($signup_question_object->required);
          $signup_question->setClass($signup_question_object->class);
          $signup_question->setTypeId($signup_question_object->type_id);
          $signup_question->setClassData($signup_question_object->class_data);

          $manager->persist($signup_question);
          
        }

        $manager->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 6; // the order in which fixtures will be loaded
    }
}

<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Anytv\DashboardBundle\Entity\SignupQuestion;
use Anytv\DashboardBundle\Entity\SignupAnswer;

class SignupAnswerController extends Controller
{
    public function indexAction(Request $request, $page)
    {
        $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:SignupAnswer');
        $question_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:SignupQuestion');
        $affiliate_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Affiliate');
        $translator = $this->get('translator');
        $session = $this->get('session');
        
        $form = $this->createFormBuilder()
        ->add('signup_answer_update', 'submit', array('label'=>$translator->trans('update')))
        ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isValid()) 
        {
          if($form->get('signup_answer_update')->isClicked())
          {
            $manager = $this->getDoctrine()->getManager();
          
            $hasoffers = $this->get('hasoffers');
            
            $affiliate_count = 0;
            $answers_request_batch = 10;
            
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
                    }
                    
                    $affiliate_count++;
                  }
                }
                
                $affiliate->setSignupAnswersRequested(true);   
              }
            
              $manager->flush();
            
              $session->getFlashBag()->add('flash_message', $affiliate_count.'/'.$answers_request_batch.' affiliate signup answers set.');  
            }
            else
            {
              $session->getFlashBag()->add('flash_message', 'All affiliate signup answers are set.');  
            }
          
            return $this->redirect($this->generateUrl('signup_answers'));
          } 
        }
        
        $items_per_page = 30;
        $order_by = 'id';
        $order = 'DESC';
        
        $signup_answers = $repository->findAllSignupAnswers($page, $items_per_page, $order_by, $order);
        $total_signup_answers = $repository->countAllSignupAnswers();
        $total_pages = ceil($total_signup_answers / $items_per_page);
        
        return $this->render('AnytvDashboardBundle:SignupAnswer:index.html.twig', array('title'=>$translator->trans('Signup Answers'), 'signup_answers'=>$signup_answers, 'form'=>$form->createView(), 'total_pages'=>$total_pages, 'total_signup_answers'=>$total_signup_answers, 'page'=>$page));
    }
    
    
}

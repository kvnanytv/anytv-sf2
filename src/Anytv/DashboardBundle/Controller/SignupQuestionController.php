<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Anytv\DashboardBundle\Entity\SignupQuestion;

class SignupQuestionController extends Controller
{
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:SignupQuestion');
        $translator = $this->get('translator');
        
        $form = $this->createFormBuilder()
        ->add('signup_question_update', 'submit', array('label'=>$translator->trans('update')))
        ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isValid()) 
        {
          if($form->get('signup_question_update')->isClicked())
          {
            $manager = $this->getDoctrine()->getManager();
          
            $hasoffers = $this->get('hasoffers');
            $signup_questions_data = $hasoffers->getSignupQuestions();
            
            foreach($signup_questions_data as $signup_question_data)
            {
              $signup_question_object = $signup_question_data->SignupQuestion;
              
              $signup_question = $repository->findOneBy(array('questionId'=>$signup_question_object->id));
              
              if($signup_question)
              {
                $signup_question->setType($signup_question_object->type);
                $signup_question->setQuestion($signup_question_object->question);
                $signup_question->setStatus($signup_question_object->status);
                $signup_question->setRequired($signup_question_object->required);
                $signup_question->setClass($signup_question_object->class);
                $signup_question->setTypeId($signup_question_object->type_id);
                $signup_question->setClassData($signup_question_object->class_data);
              }
              else
              {
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
            }
            
            $manager->flush();
          
            return $this->redirect($this->generateUrl('signup_questions'));
          } 
        }
        
        $order_by = 'id';
        $order = 'ASC';
        
        $signup_questions = $repository->findAllSignupQuestions($order_by, $order);
        
        return $this->render('AnytvDashboardBundle:SignupQuestion:index.html.twig', array('title'=>$translator->trans('Signup Questions'), 'signup_questions'=>$signup_questions, 'form'=>$form->createView()));
    }
    
    
}

<?php

namespace Anytv\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FaqType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('question', 'textarea', array('label'=>'Question (English)'))
                ->add('answer', 'textarea', array('label'=>'Answer (English)'))
                ->add('questionZh', 'textarea', array('label'=>'Question (Chinese)', 'required'=>false))
                ->add('answerZh', 'textarea', array('label'=>'Answer (Chinese)', 'required'=>false))
                ->add('questionNl', 'textarea', array('label'=>'Question (Dutch)', 'required'=>false))
                ->add('answerNl', 'textarea', array('label'=>'Answer (Dutch)', 'required'=>false))
                ->add('questionDe', 'textarea', array('label'=>'Question (German)', 'required'=>false))
                ->add('answerDe', 'textarea', array('label'=>'Answer (German)', 'required'=>false))
                ->add('isActive', 'choice', array('choices' => array(0 => 'no', 1 => 'yes')))
                ->add('isVisibleEn', 'choice', array('choices' => array(0 => 'no', 1 => 'yes'), 'label'=>'Visible in English'))
                ->add('isVisibleZh', 'choice', array('choices' => array(0 => 'no', 1 => 'yes'), 'label'=>'Visible in Chinese'))
                ->add('isVisibleNl', 'choice', array('choices' => array(0 => 'no', 1 => 'yes'), 'label'=>'Visible in Dutch'))
                ->add('isVisibleDe', 'choice', array('choices' => array(0 => 'no', 1 => 'yes'), 'label'=>'Visible in German'))
                ->add('categories', null)
                ->add('save', 'submit');
    }

    public function getName()
    {
        return 'faq';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
      $resolver->setDefaults(array(
        'data_class' => 'Anytv\MainBundle\Entity\Faq',
      ));
    }
}

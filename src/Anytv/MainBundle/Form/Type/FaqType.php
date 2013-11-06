<?php

namespace Anytv\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FaqType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('question')
                ->add('answer')
                ->add('questionZh')
                ->add('answerZh')
                ->add('questionNl')
                ->add('answerNl')
                ->add('questionDe')
                ->add('answerDe')
                ->add('isActive', 'choice', array('choices' => array(0 => 'no', 1 => 'yes')))
                ->add('isVisibleEn', 'choice', array('choices' => array(0 => 'no', 1 => 'yes')))
                ->add('isVisibleZh', 'choice', array('choices' => array(0 => 'no', 1 => 'yes')))
                ->add('isVisibleNl', 'choice', array('choices' => array(0 => 'no', 1 => 'yes')))
                ->add('isVisibleDe', 'choice', array('choices' => array(0 => 'no', 1 => 'yes')))
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

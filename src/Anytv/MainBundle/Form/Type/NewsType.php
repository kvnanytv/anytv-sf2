<?php

namespace Anytv\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')
            ->add('excerpt')
            ->add('body')
            ->add('category')
            ->add('file')
            ->add('check', 'checkbox', array('mapped' => false))
            ->add('save', 'submit');
        
        // embed in another form
        //$builder->add('someNews', new NewsType());
    }

    public function getName()
    {
        return 'news';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
      $resolver->setDefaults(array(
        'data_class' => 'Anytv\MainBundle\Entity\News',
      ));
    }
}

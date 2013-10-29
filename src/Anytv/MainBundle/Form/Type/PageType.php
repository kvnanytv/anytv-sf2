<?php

namespace Anytv\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content')
                ->add('contentZh')
                ->add('save', 'submit');
    }

    public function getName()
    {
        return 'page';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
      $resolver->setDefaults(array(
        'data_class' => 'Anytv\MainBundle\Entity\Page',
      ));
    }
}

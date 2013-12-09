<?php

namespace Anytv\DashboardBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')
            ->add('firstName')
            ->add('lastName')
            ->add('phone')
            ->add('cellPhone')
            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'profile';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
      $resolver->setDefaults(array(
        'data_class' => 'Anytv\DashboardBundle\Entity\AffiliateUser',
      ));
    }
}

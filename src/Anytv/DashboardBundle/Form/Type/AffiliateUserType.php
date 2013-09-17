<?php

namespace Anytv\DashboardBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AffiliateUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('status', 'choice', array('choices' => array('active' => 'active', 'blocked' => 'blocked', 'deleted' => 'deleted')))
            ->add('phone')
            ->add('cellPhone')
            ->add('file')
            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'affiliateUser';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
      $resolver->setDefaults(array(
        'data_class' => 'Anytv\DashboardBundle\Entity\AffiliateUser',
      ));
    }
}

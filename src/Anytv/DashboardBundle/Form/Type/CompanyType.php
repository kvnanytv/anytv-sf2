<?php

namespace Anytv\DashboardBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('company')
            ->add('address1')
            ->add('address2')
            ->add('city')
            ->add('country')
            ->add('other')
            ->add('zipcode')
            ->add('file')
            ->add('phone')
            ->add('fax')
            ->add('paypalEmail', 'email', array('required'=>false))
            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'company';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
      $resolver->setDefaults(array(
        'data_class' => 'Anytv\DashboardBundle\Entity\Affiliate',
      ));
    }
}

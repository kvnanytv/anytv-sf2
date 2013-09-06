<?php

namespace Anytv\DashboardBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AffiliateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('company')
            ->add('address1')
            ->add('address2')
            ->add('city')
            ->add('region')
            ->add('country')
            ->add('other')
            ->add('zipcode')
            ->add('phone')
            ->add('fax')
            ->add('status')
            ->add('payment_method')
            ->add('payment_terms')
            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'affiliate';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
      $resolver->setDefaults(array(
        'data_class' => 'Anytv\DashboardBundle\Entity\Affiliate',
      ));
    }
}

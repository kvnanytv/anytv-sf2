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
            ->add('file')
            ->add('phone')
            ->add('fax')
            ->add('status', 'choice', array('choices' => array('active' => 'active', 'pending' => 'pending', 'deleted' => 'deleted', 'blocked' => 'blocked', 'rejected' => 'rejected')))
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

<?php

namespace Anytv\DashboardBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('description')
            ->add('advertiser')
            ->add('offerUrl')
            ->add('previewUrl')
            ->add('status')
            ->add('expirationDate')
            ->add('is_private')
            ->add('require_approval')
            ->add('require_terms_and_conditions')
            ->add('terms_and_conditions')
            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'offer';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
      $resolver->setDefaults(array(
        'data_class' => 'Anytv\DashboardBundle\Entity\Offer',
      ));
    }
}

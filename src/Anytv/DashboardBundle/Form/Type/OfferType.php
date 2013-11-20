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
            ->add('status', 'choice', array('choices' => array('active' => 'active', 'paused' => 'paused', 'pending' => 'pending', 'expired' => 'expired', 'deleted' => 'deleted')))
            ->add('expirationDate')
            ->add('isFeatured')
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

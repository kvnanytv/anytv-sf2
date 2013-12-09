<?php

namespace Anytv\DashboardBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OfferGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$builder->add('name')
            //->add('status', 'choice', array('choices' => array('active' => 'active', 'deleted' => 'deleted')))
            $builder->add('file')
            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'offer_group';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
      $resolver->setDefaults(array(
        'data_class' => 'Anytv\DashboardBundle\Entity\OfferGroup',
      ));
    }
}

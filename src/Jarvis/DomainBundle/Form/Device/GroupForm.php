<?php

namespace Jarvis\DomainBundle\Form\Device;

use Jarvis\DomainBundle\Entity\Device\Group;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GroupForm
 * @package Jarvis\DomainBundle\Form\Device
 */
class GroupForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Group::class,
            'csrf_protection' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('devices', TextType::class)
        ;
    }
}
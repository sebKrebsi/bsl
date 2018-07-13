<?php

namespace AppBundle\Admin\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('position', null, ['label' => 'team.fields.position'])
            ->add('name', null, ['label' => 'team.fields.name'])
            ->add('linkToPage', null, ['label' => 'team.fields.linkToPage'])
            ->add('needPlayers', null, ['label' => 'team.fields.needPlayers'])
            ->add('needCoaches', null, ['label' => 'team.fields.needCoaches'])
            ->add('image', FileType::class, ['label' => 'team.fields.image', 'mapped' => false, 'required' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Team'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_team';
    }

}

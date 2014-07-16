<?php

namespace JKP\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class FileImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file', array(
                'label' => 'Obraz',
                'constraints' => array(
                    new Assert\Image(array('mimeTypesMessage' => 'Załącznik musi być obrazem.'))
                )
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JKP\CoreBundle\Entity\File'
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'jkp_file_image';
    }
} 
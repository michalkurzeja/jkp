<?php

namespace JKP\AdminBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMInvalidArgumentException;
use JKP\AdminBundle\DependencyInjection\Translations;
use JKP\CoreBundle\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Translations $translations */
        $translations = $options['translations'];

        try {
            $transArray = $translations->getTranslations($builder->getData());
        } catch (ORMInvalidArgumentException $e) {
            $transArray = null;
        }

        foreach (Product::getValidLocale() as $locale) {
            $localeUpper = strtoupper($locale);

            $params = array(
                'label' => "Nazwa ($localeUpper)",
                'mapped' => false,
                'constraints' => array(
                    new NotBlank(array('message' => 'Ta wartość nie powinna być pusta.'))
                )
            );

            if (null !== $transArray) {
                $params['data'] = $transArray[$locale]['name'];
            }

            $builder->add("name{$localeUpper}", 'text', $params);

            $params = array(
                'label' => "Opis ($localeUpper)",
                'mapped' => false,
                'attr' => array(
                    'rows' => 10
                ),
                'constraints' => array(
                    new NotBlank(array('message' => 'Ta wartość nie powinna być pusta.'))
                )
            );

            if (null !== $transArray) {
                $params['data'] = $transArray[$locale]['description'];
            }

            $builder->add("description{$localeUpper}", 'textarea', $params);
        }

        $builder
            ->add('category', 'entity', array(
                'label' => 'Kategoria',
                'required' => 'false',
                'class' => 'JKPCoreBundle:Category',
                'empty_value' => '-- Brak --',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name');
                }
            ))
            ->add('slug', 'text', array(
                'label' => 'Adres'
            ))
            ->add('featured', 'checkbox', array(
                'label' => 'Na główną?',
                'required' => false
            ))
            ->add('active', 'checkbox', array(
                'label' => 'Aktywny?',
                'required' => false
            ))
            ->add('image', new FileImageType(), array(
                'cascade_validation' => true,
                'required' => false,
                'data_class' => 'JKP\CoreBundle\Entity\File'
            ));

        $builder->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $event) use ($translations) {
            $translations->setTranslations($event->getForm()->getData(), $event->getForm());
        });
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'JKP\CoreBundle\Entity\Product'
            ))
            ->setRequired(array(
                'translations'
            ))
            ->setAllowedTypes(array(
                'translations' => 'JKP\AdminBundle\DependencyInjection\Translations'
            ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'jkp_product';
    }
} 
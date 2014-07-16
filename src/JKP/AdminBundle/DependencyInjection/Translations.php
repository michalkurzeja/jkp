<?php

namespace JKP\AdminBundle\DependencyInjection;

use Doctrine\ORM\EntityManager;
use JKP\CoreBundle\Entity\Product;
use Symfony\Component\Form\Form;

class Translations
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function setTranslations($entity, Form $translations)
    {
        $translations = $this->prepareTranslationsArray($translations);

        $repository = $this->em->getRepository('Gedmo\Translatable\Entity\Translation');

        foreach (Product::getValidLocale() as $locale) {
            $localeUpper = strtoupper($locale);

            $repository->translate($entity, 'name', $locale, $translations["name{$localeUpper}"])
                ->translate($entity, 'description', $locale, $translations["description{$localeUpper}"]);
        }
    }

    public function getTranslations($entity)
    {
        $translations = array();

        foreach (Product::getValidLocale() as $locale) {
            $entity->setTranslatableLocale($locale);
            $this->em->refresh($entity);

            $translations[$locale] = array(
                'name' => $entity->getName(),
                'description' => $entity->getDescription()
            );
        }

        return $translations;
    }

    private function prepareTranslationsArray(Form $form)
    {
        $translations = array();

        foreach ($form as $key => $value) {
            $translations[$key] = $form[$key]->getData();
        }

        return $translations;
    }
}
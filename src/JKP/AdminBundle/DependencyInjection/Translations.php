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

    public function setProductTranslations(Product $product, Form $translations)
    {
        $translations = $this->prepareTranslationsArray($translations);

        $repository = $this->em->getRepository('Gedmo\Translatable\Entity\Translation');

        foreach (Product::getValidLocale() as $locale) {
            $localeUpper = strtoupper($locale);

            $repository->translate($product, 'name', $locale, $translations["name{$localeUpper}"])
                ->translate($product, 'description', $locale, $translations["description{$localeUpper}"]);
        }
    }

    public function getProductTranslations(Product $product)
    {
        $translations = array();

        foreach (Product::getValidLocale() as $locale) {
            $product->setTranslatableLocale($locale);
            $this->em->refresh($product);

            $translations[$locale] = array(
                'name' => $product->getName(),
                'description' => $product->getDescription()
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
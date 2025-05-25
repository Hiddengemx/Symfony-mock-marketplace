<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product;
        $product->setName('Product 1');
        $product->setDescription('This is the 1st product');
        $product->setPrice(100);

        $manager->persist($product);

        $product = new Product;
        $product->setName('Product 2');
        $product->setDescription('This is the 2nd product');
        $product->setPrice(200);

        $manager->persist($product);

        $product = new Product;
        $product->setName('Product 3');
        $product->setDescription('This is the 3rd product');
        $product->setPrice(300);

        $manager->persist($product);

        $manager->flush();
    }
}

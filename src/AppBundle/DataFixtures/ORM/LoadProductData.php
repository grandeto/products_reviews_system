<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Product;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface{


    private $productContent = array(
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut a est elit, id tempus elit. Nulla facilisi.
        Suspendisse tristique sagittis auctor. Donec consequat, nisl sed mollis ullamcorper, elit erat lobortis est,
        non mollis est nulla sed metus.',

        'Aliquam quam libero, condimentum ac dapibus vitae, posuere ac velit. Nulla nunc nunc, congue vel rutrum a,
        ultricies a sem. Sed vehicula justo at magna bibendum at tempor metus scelerisque.',

        'Vestibulum dui arcu, molestie a sodales non, volutpat vel nisi. Mauris in nisi id odio feugiat adipiscing at sit
        amet neque. Sed rhoncus leo imperdiet diam consectetur nec imperdiet erat condimentum.'
    );

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager){
        for($i = 0; $i < 3; $i++){
            $product = new Product();
            $product->setTitle('Product'.$i+1);
            $product->setContent($this->productContent[$i]);
            $product->setAuthor($this->getReference('user'));

            $manager->persist($product);

            // Reference added once
            if($i == 0) {
                $this->addReference('product', $product);
            }
        }

        $manager->flush();
    }

    public function getOrder(){
        return 3;
    }
}
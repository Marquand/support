<?php
namespace PointWeb\ProductBundle\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PointWeb\ProductBundle\Entity\Category;
use PointWeb\ProductBundle\Entity\Product;

class ProductData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        for($i=0; $i<10; $i++)
        {
            $product = new Product();
            $product->setTitle('Mon produit qui est long en titre et on va voir ce que ça donne'.$i);
            $product->setDescription('description description description description description description '.$i);
            $cat = $manager->getRepository('PointWebProductBundle:Category')->find(rand(1,6));
            $product->setCategory($cat);
            $manager->persist($product);
        }
        $manager->flush();
    }
}
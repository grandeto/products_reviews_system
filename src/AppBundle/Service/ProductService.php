<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Product;

class ProductService{
    /** @var EntityManager */
    private $em;

    /** @var \Doctrine\ORM\EntityRepository */
    private $productRepository;

    /**
     * @param EntityManager $entityManager
     */
    function __construct(EntityManager $entityManager){
        $this->em = $entityManager;
        $this->productRepository = $this->em->getRepository('AppBundle:Product');
    }

    /**
     * Return an Product by id
     * @param $id integer
     * @return Product|null
     */
    public function getProductById($id){
        return $this->productRepository->find($id);
    }

    /**
     * Return published product sorted by ASC date
     * @return Product array
     */
    public function getPublishedProducts(){
        $products = $this->productRepository->findBy(
            array('published' 	=> 1),
            array('date' 		=> 'DESC')
        );

        return $products;
    }

    /**
     * Return all products sorted by ASC date
     * @return Product array
     */
    public function getProducts(){
        return $this->productRepository->findBy(
            array(),
            array('date' => 'ASC')
        );
    }

    /**
     * Returns top 5 rated products sorted by DESC avarage rating
     * @return Product array
     */
    public function getTopFiveRatedProducts(){

        $RAW_QUERY = 'SELECT product_id, avg(rating) as rate
                        FROM review
                        GROUP BY product_id
                        ORDER BY rate DESC
                        LIMIT 5';
        
        $connection = $this->em->getConnection();
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();

        $result = $statement->fetchAll();
        return $result;
    }

    /**
     * Save an Product object
     * @param Product $product
     */
    public function save(Product $product){
        $this->em->persist($product);
        $this->em->flush();
    }

    /**
     * Delete an Product object
     * @param Product $product
     */
    public function delete(Product $product){
        $this->em->remove($product);
        $this->em->flush();
    }
}

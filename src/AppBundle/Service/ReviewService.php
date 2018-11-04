<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Review;
use AppBundle\Entity\Product;

class ReviewService{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $reviewRepository;

    /**
     * @param EntityManager $entityManager
     */
    function __construct(EntityManager $entityManager){
        $this->em = $entityManager;
        $this->reviewRepository = $this->em->getRepository('AppBundle:Review');
    }

    /**
     * Return an Review by id
     * @param $id integer
     * @return Review|null
     */
    public function getReviewById($id){
        return $this->reviewRepository->find($id);
    }

    /**
     * Returns a list of approved reviews by an product sorted by DESC
     * @param Product $product
     * @return Review array
     */
    public function getReviewsByProduct(Product $product){
        return $this->reviewRepository->findBy(
            array('product' => $product->getId(), 'approved' => 1),
            array('date'    => 'DESC')
        );
    }

    /**
     * Returns a list of unapproved reviews by an product sorted by DESC
     * @param Product $product
     * @return Review array
     */
    public function getUnapprovedReviews(){
        return $this->reviewRepository->findBy(
            array('approved' => 0),
            array('date'    => 'DESC')
        );
    }

    /**
     * Approve a Review object
     * @param Review $review
     */
    public function approve(Review $review){
        $review->setApproved(true);
        $this->em->persist($review);
        $this->em->flush();
    }

    /**
     * Delete a Review object
     * @param Review $review
     */
    public function delete(Review $review){
        $this->em->remove($review);
        $this->em->flush();
    }

    /**
     * Save a Review object
     * @param Review $review
     */
    public function save(Review $review){
        $this->em->persist($review);
        $this->em->flush();
    }
}

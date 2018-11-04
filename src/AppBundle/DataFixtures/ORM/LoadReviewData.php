<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Review;

class LoadReviewData extends AbstractFixture implements OrderedFixtureInterface{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager){
        $review = new Review();
        $review->setAuthor($this->getReference('user'));
        $review->setRating(5);
        $review->setContent('Review');
        $review->setApproved(false);
        $review->setProduct($this->getReference('product'));

        $manager->persist($review);
        $manager->flush();

        $this->addReference('review', $review);
    }

    public function getOrder(){
        return 4;
    }
}

<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Product;
use AppBundle\Entity\Review;
use AppBundle\Form\ReviewType;
use AppBundle\Service\ReviewService;

class ReviewController extends Controller
{
    /**
     * Returns a list of reviews by an product
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewsAction(Product $product){
        $reviewService = $this->container->get('ReviewService');
        $reviews = $reviewService->getReviewsByProduct($product);

        if (!empty($reviews) && count($reviews) > 1) {
            $ratings = [];
            $avarageRaging = 1;
    
            foreach ($reviews as $review) {
                array_push($ratings, $review->getRating());
            }
    
            $ratings = array_filter($ratings);
            $avarageRaging = array_sum($ratings)/count($ratings);
        } elseif (!empty($reviews) && count($reviews) == 1) {
            $avarageRaging = $reviews[0]->getRating();
        } else {
            $avarageRaging = null;
        }

        return $this->render('AppBundle:Review:views.html.twig', array(
            'reviews' => $reviews,
            'avarageRaging' => $avarageRaging
        ));
    }

    /**
     * Add a review
     * @param Product $product
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Product $product, Request $request){
        $review = new Review();

        $form = $this->createForm(new ReviewType(), $review);
        $form->handleRequest($request);

        if($form->isValid()){
            $review->setAuthor($this->getUser());
            $review->setApproved(false);
            $review->setProduct($product);

            /** @var ReviewService reviewService */
            $reviewService = $this->container->get('ReviewService');
            $reviewService->save($review);

            return $this->redirect($this->generateUrl('product_view', array(
                'id' => $product->getId(),
            )));
        }

        return $this->render('AppBundle:Review:add.html.twig', array(
            'form'      => $form->createView(),
            'product'   => $product
        ));
    }

    /**
     * Returns a list of unapproved reviews
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardReviewsAction(){
        $reviewService = $this->container->get('ReviewService');
        $reviews = $reviewService->getUnapprovedReviews();

        return $this->render('AppBundle:Admin:reviews.html.twig', array(
            'reviews' => $reviews
        ));
    }

    /**
     * Returns a list of unapproved reviews
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function approveAction($id){
        $reviewService = $this->container->get('ReviewService');
        $review = $reviewService->getReviewById($id);
        $reviewService->approve($review);

        return $this->redirect($this->generateUrl('review_dashboard'));
    }
}

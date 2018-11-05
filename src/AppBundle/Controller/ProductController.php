<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ProductType;
use AppBundle\Entity\Product;
use AppBundle\Service\ProductService;

class ProductController extends Controller
{
    /** @var ProductService $productService */
    private $productService;
    /** @var  Request $request */
    private $request;

    public function preExecute(Request $request){
        $this->productService   = $this->container->get('ProductService');
        $this->request          = $request;
    }

    /**
     * Returns a list of all published Products
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewsAction(){
        $products = $this->productService->getPublishedProducts();

        return $this->render('AppBundle:Product:views.html.twig', array(
            'products' => $products
        ));
    }

    /**
     * Return one product view (product content)
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id){
        $product = $this->productService->getProductById($id);
        return $this->render('AppBundle:Product:view.html.twig', array(
            'product'           => $product
        ));
    }

    /**
     * Show all products in admin dashboard
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardProductAction(){
        $products = $this->productService->getProducts();

        return $this->render('AppBundle:Product:product.html.twig', array(
            'products' => $products
        ));
    }

    public function dashboardTopFiveProductsAction(){
        $products = $this->productService->getTopFiveRatedProducts();

        return $this->render('AppBundle:Product:topfive.html.twig', array(
            'products' => $products
        ));
    }

    /**
     * Add a new Product or edit an existing Product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(){
        $id = $this->request->get('id');

        if($id === null){
            $product = new Product();
        }
        else{
            $product = $this->productService->getProductById($id);

            if(empty($product)){
                return $this->redirect($this->generateUrl('product_dashboard'));
            }
        }

        $form = $this->createForm(new ProductType(), $product);

        if($this->request->isMethod('POST')){
            $form->handleRequest($this->request);

            if($form->isValid()){

                $product->setAuthor($this->getUser());
                $this->productService->save($product);

                return $this->redirect($this->generateUrl('product_view', array(
                    'id' => $product->getId()
                )));
            }
        }

        return $this->render('AppBundle:Product:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Delete an product
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Product $product){
        $this->productService->delete($product);

        return $this->redirect($this->generateUrl('product_dashboard'));
    }
}

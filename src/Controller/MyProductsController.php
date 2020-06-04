<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class MyProductsController extends AbstractController
{
    /**
     * @Route("/my/products", name="my_products")
     */
    public function index()
    {
        $products = [];
        $products = $this->getUser()->getProductsProprio();
        /*echo '<pre>';
        var_dump($products);
        echo '</pre>';*/

        return $this->render('my_products/index.html.twig', [
            'userproducts' => $products,
        ]);
    }
}

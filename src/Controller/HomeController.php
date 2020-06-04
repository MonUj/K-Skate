<?php
// src/Controller/AdvertController.php

namespace App\Controller;
use Twig\Environment;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Repository\CategoryRepository;


class HomeController extends AbstractController
{

  /**
     * @Route("/home", name="app_home")
     */
 
  public function home(Environment $twig, Request $request, ProductRepository $productRepository, CategoryRepository $categoryRepository)
  {
    

    $user = $this->getUser();
    
    //var_dump($this->getUser()->getId());

    //$this->addProduct($request);
    $product = new Product();
    $formaddPro = $this->createForm(ProductType::class, $product);

    $formaddPro->handleRequest($request);

    if ($formaddPro->isSubmitted() && $formaddPro->isValid()) 
    {
      $product->setUserProprio($user);
      $product->setDatecreated(new \Datetime);
      $em = $this->getDoctrine()->getManager();
      $em->persist($product);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Produit bien enregistré.');

      //return $this->redirectToRoute('sc_shop_view', array('id' => $product->getId())) ajoute l'id du produit à la vue shop view
      return $this->redirectToRoute('app_home');

    }

    $productRepository = $this->getDoctrine()->getRepository(Product::class)->findBy([],['datecreated' => 'desc']);

    $content = $twig->render('home.html.twig',array('formAddPro' => $formaddPro->createView(), 'products' => $productRepository, 'categorys' => $categoryRepository->findAll()), ['mainNavHome'=>true, 'title'=>'K-Skate']); //, 'formAddPro' => $formaddPro->createView()
    //return $this->render('product/index.html.twig', ['products' => $productRepository->findAll()]);

    return new Response($content);
  }

  public function header()
  {
    return $this->render('header.html.twig');
  }

  /*private function addProduct(Request $request)
  {
    $product = new Product();
    $formaddPro = $this->createForm(ProductType::class, $product);

    $formaddPro->handleRequest($request);

    if ($formaddPro->isSubmitted() && $formaddPro->isValid()) 
    {
      $em = $this->getDoctrine()->getManager();
      $em->persist($product);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Produit bien enregistré.');

      //return $this->redirectToRoute('sc_shop_view', array('id' => $product->getId())) ajoute l'id du produit à la vue shop view
      return $this->redirectToRoute('home.html.twig');

    }

    return $this->render('home.html.twig', array(
      'form2' => $formaddPro->createView(),
    ));


  }*/

}

?>
<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use App\Form\ProductForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_index')]
    #[IsGranted('ROLE_USER')]
    public function index(ProductRepository $repository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $repository->findAll()
        ]);
    }

    #[Route('/products/{id<\d+>}', name: 'product_show')]
    #[IsGranted('ROLE_USER')]
    public function show(Product $product, ProductRepository $repository): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }

    #[Route('/products/create', name: 'product_create')]
    #[IsGranted('ROLE_USER')]
    public function create(Request $req, EntityManagerInterface $manager): Response
    { 
        $product = new Product;

        $form = $this->createForm(ProductForm::class, $product);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($product);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Product created successfully!'
            );

            return $this->redirectToRoute('product_show', [
                'id' => $product->getId(),
            ]);
        }

        return $this->render('product/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/product/{id<\d+>}/edit', name: 'product_edit')]
    #[IsGranted('ROLE_USER')]
    public function edit(Product $product, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ProductForm::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();

            $this->addFlash(
                'notice',
                'Product updated successfully!'
            );

            return $this->redirectToRoute('product_show', [
                'id' => $product->getId(),
            ]);

        }

        return $this->render('product/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/product/{id<\d+>}/delete', name: 'product_delete')]
    #[IsGranted('ROLE_USER')]
    public function delete(Request $req, Product $product, EntityManagerInterface $manager): Response
    {
        if($req->isMethod('POST')) {
            $manager->remove($product);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Product deleted successfully!'
            );

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/delete.html.twig', [
            'id' => $product->getId(),
        ]);
    }
}

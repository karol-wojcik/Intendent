<?php
/**
 * Created by PhpStorm.
 * User: Karol
 * Date: 2015-12-30
 * Time: 14:40
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Product;
use AppBundle\Entity\Warehouse;
use AppBundle\Form\Type\ProductType;
use AppBundle\Form\Type\WarehouseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
	public function listAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$products = $em->getRepository('AppBundle:Product')
			->findAllOrderedByName();

		return $this->render('AppBundle:Product:list.html.twig', array(
			'products' => $products,
		));
	}

	public function newAction(Request $request)
	{
		$product = new Product();
		$form = $this->createForm(new ProductType(), $product);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($product);
			$em->flush();

			return $this->redirectToRoute('productList');
		}

		return $this->render('AppBundle:Product:new.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
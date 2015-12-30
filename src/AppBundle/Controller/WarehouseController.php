<?php
/**
 * Created by PhpStorm.
 * User: Karol
 * Date: 2015-12-30
 * Time: 14:40
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Warehouse;
use AppBundle\Form\Type\WarehouseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WarehouseController extends Controller
{
	public function listAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$warehouses = $em->getRepository('AppBundle:Warehouse')
			->findAllOrderedByName();

		return $this->render('AppBundle:Warehouse:list.html.twig', array(
			'warehouses' => $warehouses,
		));
	}

	public function getAction($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$wh = $em->getRepository('AppBundle:Warehouse')->find($id);

		return $this->render('AppBundle:Warehouse:details.html.twig', array(
			'warehouse' => $wh,
		));
	}

	public function newAction(Request $request)
	{
		$wh = new Warehouse();
		$form = $this->createForm(new WarehouseType(), $wh);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($wh);
			$em->flush();

			return $this->redirectToRoute('warehouseList');
		}

		return $this->render('AppBundle:Warehouse:new.html.twig', array(
			'form' => $form->createView(),
		));
	}

	public function editAction($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$wh = $em->getRepository('AppBundle:Warehouse')->find($id);

		return $this->render('AppBundle:Warehouse:details.html.twig', array(
			'warehouse' => $wh,
		));
	}
}
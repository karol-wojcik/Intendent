<?php
/**
 * Created by PhpStorm.
 * User: Karol
 * Date: 2015-12-30
 * Time: 14:40
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Contractor;
use AppBundle\Form\Type\ContractorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContractorController extends Controller
{
	public function listAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$contractors = $em->getRepository('AppBundle:Contractor')
			->findAllOrderedByName();

		return $this->render('AppBundle:Contractor:list.html.twig', array(
			'contractors' => $contractors,
		));
	}

	public function newAction(Request $request)
	{
		$contractor = new Contractor();
		$form = $this->createForm(new ContractorType(), $contractor);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($contractor);
			$em->flush();

			return $this->redirectToRoute('contractorList');
		}

		return $this->render('AppBundle:Contractor:new.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
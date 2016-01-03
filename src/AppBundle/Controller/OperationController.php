<?php
/**
 * Created by PhpStorm.
 * User: Karol
 * Date: 2015-12-30
 * Time: 14:40
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Contractor;
use AppBundle\Entity\Operation;
use AppBundle\Entity\OperationElement;
use AppBundle\Form\Type\ContractorType;
use AppBundle\Form\Type\OperationType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OperationController extends Controller
{
	public function incomeListAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$operations = $em->getRepository('AppBundle:Operation')
			->findAllIncomeByDate();

        dump($operations);
		return $this->render('AppBundle:Operation:listIncome.html.twig', array(
			'operations' => $operations,
		));
	}

	public function incomeNewAction(Request $request)
	{
		return $this->newAction(Operation::TYPE_INCOME, $request);
	}

    public function incomeEditAction($operationId, Request $request)
	{
        return $this->editAction(Operation::TYPE_INCOME, $operationId, $request);
	}


	public function outcomeListAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$operations = $em->getRepository('AppBundle:Operation')
				->findAllOutcomeByDate();

		return $this->render('AppBundle:Operation:listOutcome.html.twig', array(
			'operations' => $operations,
		));
	}

	public function outcomeNewAction(Request $request)
	{
        return $this->newAction(Operation::TYPE_OUTCOME, $request);
	}

    public function outcomeEditAction($operationId, Request $request)
    {
        return $this->editAction(Operation::TYPE_OUTCOME, $operationId, $request);
    }

    private function newAction($type, Request $request)
    {
        $operation = $this->prepareOperationObject($type);
        $form = $this->createForm(new OperationType(), $operation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($operation);
            $em->flush();

            $total = 0;
            /** @var OperationElement $element */
            foreach($operation->getElements() as $element) {
                $element->setOperation($operation);
                $em->persist($element);
                $total += $element->getValue();
            }
            $operation->setTotalAmount($total);
            $em->flush();

            return $this->redirectToRoute($type . 'List');
        }

        return $this->render('AppBundle:Operation:new' . ucfirst($type) . '.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    private function editAction($type, $operationId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $operation = $em->getRepository('AppBundle:Operation')->find($operationId);
        if (!$operation) {
            throw $this->createNotFoundException('Nie znaleziono dokumentu dla wybranego id: '.$operationId);
        }
        $originalElements = new ArrayCollection();
        foreach ($operation->getElements() as $element) {
            $originalElements->add($element);
        }

        $form = $this->createForm(new OperationType(), $operation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // remove elements
            foreach ($originalElements as $element) {
                if (false === $operation->getElements()->contains($element)) {
                    $operation->removeElement($element);
                    $em->remove($element);
                }
            }

            $total = 0;
            /** @var OperationElement $element */
            foreach($operation->getElements() as $element) {
                $element->setOperation($operation);
                $em->persist($element);
                $total += $element->getValue();
            }

            $operation->setTotalAmount($total);
            $em->persist($operation);
            $em->flush();

            return $this->redirectToRoute($type . 'List');
        }

        return $this->render('AppBundle:Operation:edit'.ucfirst($type).'.html.twig', array(
            'form' => $form->createView(),
        ));
    }

	private function prepareOperationObject($type)
	{
		if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
			throw $this->createAccessDeniedException();
		}
		$user = $this->getUser();
		$em = $this->getDoctrine()->getManager();
		$warehouse = $em->getRepository('AppBundle:Warehouse')->getDefault();

		$operation = new Operation();
		$operation->setOperationDate(new \DateTime());
		$operation->setType($type);
		$operation->setOperator($user);
		$operation->setWarehouse($warehouse);

		return $operation;
	}
}
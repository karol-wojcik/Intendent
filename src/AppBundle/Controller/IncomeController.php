<?php
/**
 * Created by PhpStorm.
 * User: Karol
 * Date: 2015-12-30
 * Time: 14:40
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Income;
use AppBundle\Entity\IncomeElement;
use AppBundle\Entity\ProductStock;
use AppBundle\Form\Type\IncomeType;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IncomeController extends Controller
{
	public function listAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
        $incomes = $em->getRepository('AppBundle:Income')->findAllByDate();

        dump($incomes);
		return $this->render('AppBundle:Income:list.html.twig', array(
			'incomes' => $incomes,
		));
	}

	public function newAction(Request $request)
	{
        $income = $this->prepareIncomeObject();
        $form = $this->createForm(new IncomeType(), $income);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();
            try {
                $total = 0;
                /** @var IncomeElement $element */
                foreach($income->getElements() as $element) {
                    $element->setIncome($income);
                    $total += $element->getValue();
                }
                $income->setTotalAmount($total);
                $em->persist($income);
                $em->flush();

                $this->updateStock($income);

                $em->getConnection()->commit();

                return $this->redirectToRoute('incomeList');
            } catch (Exception $exc) {
                $em->getConnection()->rollBack();
                throw $exc;
            }
        }

        return $this->render('AppBundle:Income:new.html.twig', array(
            'form' => $form->createView(),
        ));
	}

    public function editAction($id, Request $request)
	{
        $em = $this->getDoctrine()->getManager();

        $income = $em->getRepository('AppBundle:Income')->find($id);
        if (!$income) {
            throw $this->createNotFoundException('Nie znaleziono dokumentu dla wybranego id: '.$income);
        }
        $originalElements = new ArrayCollection();
        foreach ($income->getElements() as $element) {
            $originalElements->add($element);
        }

        $form = $this->createForm(new IncomeType(), $income);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->getConnection()->beginTransaction();
            try {
                // remove elements
                foreach ($originalElements as $element) {
                    if (false === $income->getElements()->contains($element)) {
                        $income->removeElement($element);
                        $em->remove($element);
                    }
                }

                $total = 0;
                /** @var IncomeElement $element */
                foreach ($income->getElements() as $element) {
                    $element->setIncome($income);
                    $em->persist($element);
                    $total += $element->getValue();
                }

                $income->setTotalAmount($total);
                $em->persist($income);
                $em->flush();

                $this->updateStock($income);

                $em->getConnection()->commit();

                return $this->redirectToRoute('incomeList');
            } catch (Exception $exc) {
                $em->getConnection()->rollBack();
                throw $exc;
            }
        }

        return $this->render('AppBundle:Income:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

	private function prepareIncomeObject()
	{
		if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
			throw $this->createAccessDeniedException();
		}
		$user = $this->getUser();
		$em = $this->getDoctrine()->getManager();
		$warehouse = $em->getRepository('AppBundle:Warehouse')->getDefault();

		$operation = new Income();
		$operation->setIncomeDate(new \DateTime());
		$operation->setOperator($user);
		$operation->setWarehouse($warehouse);

		return $operation;
	}

    private function updateStock(Income $income)
    {
        $em = $this->getDoctrine()->getManager();
        $stockRepo = $em->getRepository('AppBundle:ProductStock');
        $elements = $income->getElements();
        $productsStock = array();
        /** @var IncomeElement $element */
        foreach($elements as $element) {
            $pId = $element->getProduct()->getId();
            if (!isset($productsStock[$pId])) {
                $productsStock[$pId] = 0;
            }
            $productsStock[$pId] += $element->getQuantity();
        }

        $currentProducts = $stockRepo->findCurrentForMany(array_keys($productsStock));
        foreach($elements as $element) {
            $pId = $element->getProduct()->getId();

            // prevent saving stock if there are multiple elements for one product
            if (!isset($productsStock[$pId]))
                continue;

            if (isset($currentProducts[$pId])) {
                /** @var ProductStock $oldStock */
                $oldStock = $currentProducts[$pId];
                $newStockValue = $oldStock->getStock() + $productsStock[$pId];
            } else {
                $newStockValue = $productsStock[$pId];
            }

            $newStock = new ProductStock();
            $newStock
                ->setProduct($element->getProduct())
                ->setStock($newStockValue);

            $em->persist($newStock);
            unset($productsStock[$pId]);
        }
        $em->flush();
    }
}
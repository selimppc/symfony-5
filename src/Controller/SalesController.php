<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Sales;
use App\Form\SalesType;
use App\Repository\ProductRepository;
use App\Repository\SalesRepository;
use App\Service\FifoProductSalesService;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sales")
 */
class SalesController extends AbstractController
{
    /**
     * @Route("/", name="sales_index", methods={"GET"})
     * @param SalesRepository $salesRepository
     * @return Response
     */
    public function index(SalesRepository $salesRepository): Response
    {
        return $this->render('sales/index.html.twig', [
            'sales' => $salesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sales_new", methods={"GET","POST"})
     * @param Request $request
     * @param FifoProductSalesService $fifoProductSalesService
     * @return Response
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function new(Request $request, FifoProductSalesService $fifoProductSalesService): Response
    {
        $sale = new Sales();
        $form = $this->createForm(SalesType::class, $sale);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $postSales = $request->request->get('sales');
            $productsAsFifo = $fifoProductSalesService->getFifoItem($postSales);

            foreach ($productsAsFifo as $item){
                $sale = new Sales();
                $sale->setItemId($this->getDoctrine()->getRepository(Product::class)->find($item['item_id']));
                $sale->setOrderQty($item['order_qty']);
                $sale->setBatchSequence($item['batch_sequence']);
                $sale->setCostPrice($item['cost_price']);
                $sale->setSellPrice($postSales['sell_price']);
                $entityManager->persist($sale);
            }
            $entityManager->flush();
            return $this->redirectToRoute('sales_index');
        }

        return $this->render('sales/new.html.twig', [
            'sale' => $sale,
            'form' => $form->createView(),
        ]);
    }

}

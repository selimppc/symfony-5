<?php

namespace App\Controller;

use App\Repository\SalesRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalController extends AbstractController
{
    /**
     * @Route("/", name="profit_cal")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $profit = $request->get('profit');
        return $this->render('cal/index.html.twig', [
            'profit' => $profit
        ]);
    }


    /**
     * @Route("/get-profit", name="get_profit")
     * @param SalesRepository $salesRepository
     * @return RedirectResponse
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getProfit(SalesRepository $salesRepository)
    {
        $profit = $salesRepository->profitAnalyze();
        return $this->redirectToRoute('profit_cal', ['profit' => $profit]);
    }
}

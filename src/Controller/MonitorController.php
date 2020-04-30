<?php

namespace App\Controller;

use App\Entity\Flow;
use App\Repository\CoinRepository;
use App\Service\BinanceCoinHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonitorController extends AbstractController
{
    /**
     * @var BinanceCoinHandler
     */
    private $binanceCoinHandler;

    public function __construct(BinanceCoinHandler $binanceCoinHandler)
    {
        $this->binanceCoinHandler = $binanceCoinHandler;
    }

    /**
     * @Route("/", name="monitor")
     */
    public function index()
    {
        /*$prices = $this->binanceCoinHandler->getPrices();
        dump($prices);
        $prices = $this->binanceCoinHandler->getValuesByPeriod($prices, 15);
        dump($prices);*/
        return $this->render('monitor/index.html.twig', [
            'controller_name' => 'MonitorController',
        ]);
    }

    /**
     * @Route("/save", name="coin_save", methods={"GET"})
     * @param CoinRepository $coinRepository
     * @return Response
     */
    public function save(CoinRepository $coinRepository)
    {
        $prices = $this->binanceCoinHandler->getPrices();
        $prices = $this->binanceCoinHandler->getValuesByPeriod($prices, 15);

        if ($prices) {
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($prices as $coinShortName => $values) {
                $coin = $coinRepository->findOneBy(['shortName' => $coinShortName]);
                $flow = new Flow();
                $flow
                    ->setCoin($coin)
                    ->setPrice($values['price'])
                    ->setVolume($values['value'])
                    ->setInterval($values['interval'])
                    ->setReceivedAt($values['receivedAt'])
                    ->setEndOfInterval($values['endOfInterval'])
                    ->setNumberTrades($values['numberOfTrades']);

                $entityManager->persist($flow);
            }
            $entityManager->flush();
        }
        return $this->render('monitor/index.html.twig', [
            'controller_name' => 'MonitorController',
        ]);
    }
}

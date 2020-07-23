<?php

namespace App\Controller;

use App\Entity\Coin;
use App\Entity\Flow;
use App\Repository\CoinRepository;
use App\Service\BinanceCoinHandler;
use App\Service\TelegramBotHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonitorController extends AbstractController
{
    /**
     * @var BinanceCoinHandler
     */
    private $binanceCoinHandler;
    /**
     * @var TelegramBotHandler
     */
    private $telegramBotHandler;


    public function __construct(BinanceCoinHandler $binanceCoinHandler, TelegramBotHandler $telegramBotHandler)
    {
        $this->binanceCoinHandler = $binanceCoinHandler;
        $this->telegramBotHandler = $telegramBotHandler;
    }

    /**
     * @Route("/", name="monitor")
     */
    public function index()
    {

        return $this->render('monitor/index.html.twig', [
            'controller_name' => 'MonitorController',
        ]);
    }

    /**
     * @Route("/test", name="test")
     */
    public function test()
    {
        $this->telegramBotHandler->test();

        return new Response('test');
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

    /**
     * @Route("/getAllCurrency", name="get_all_currency", methods={"GET", "POST"}, options={"expose"=true})
     * @param Request $request
     * @param CoinRepository $coinRepository
     * @return JsonResponse|\Symfony\Component\HttpFoundation\JsonResponse
     */

    public function getAllCurrency(Request $request, CoinRepository $coinRepository)
    {

        try {
            $coins = $coinRepository->findAll();

            if (!$coins) {
                return $this->json(['message' => 'Виникла помилка, вибачте за незручності!'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return new JsonResponse($coins, Response::HTTP_OK);

        } catch (\Exception $exception) {
            return $this->json(['message' => 'Виникла помилка, вибачте за незручності!'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}

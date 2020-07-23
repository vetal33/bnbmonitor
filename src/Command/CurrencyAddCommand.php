<?php


namespace App\Command;


use App\Entity\Flow;
use App\Repository\CoinRepository;
use App\Service\BinanceCoinHandler;
use App\Service\TelegramBotHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CurrencyAddCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'app:currency:add';
    /**
     * @var BinanceCoinHandler
     */
    private $binanceCoinHandler;
    /**
     * @var CoinRepository
     */
    private $coinRepository;
    /**
     * @var EntityManager
     */
    private $entityManager;

    const POINT_MAX = 1.1;
    /**
     * @var TelegramBotHandler
     */
    private $telegramBotHandler;

    public function __construct(BinanceCoinHandler $binanceCoinHandler,
                                CoinRepository $coinRepository,
                                EntityManagerInterface $entityManager,
                                TelegramBotHandler $telegramBotHandler)
    {
        parent::__construct();
        $this->binanceCoinHandler = $binanceCoinHandler;
        $this->coinRepository = $coinRepository;
        $this->entityManager = $entityManager;
        $this->telegramBotHandler = $telegramBotHandler;
    }

    protected function configure()
    {
        $this->setDescription('add currency to the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $countCurrency = count($this->coinRepository->findBy(['isActive' => true]));

        $lastPrices = $this->binanceCoinHandler->getLastPrices($countCurrency);
        $prices = $this->binanceCoinHandler->getPrices();

        $diff = $this->diffPrices($prices, $lastPrices);
        $this->telegramBotHandler->send($diff);

        $prices = $this->binanceCoinHandler->getValuesByPeriod($prices, 15);

        if ($prices) {
            foreach ($prices as $coinShortName => $values) {
                $coin = $this->coinRepository->findOneBy(['shortName' => $coinShortName]);
                $flow = new Flow();
                $flow
                    ->setCoin($coin)
                    ->setPrice($values['price'])
                    ->setVolume($values['value'])
                    ->setInterval($values['interval'])
                    ->setReceivedAt($values['receivedAt'])
                    ->setEndOfInterval($values['endOfInterval'])
                    ->setNumberTrades($values['numberOfTrades']);

                $this->entityManager->persist($flow);
            }
            $this->entityManager->flush();
            $output->writeln([
                'Дані збережено',
                '============',
                '',
            ]);
            return 0;
        }
    }

    private function diffPrices(array $currentPrices, array $lastPrices)
    {
        $interestArr = [];
        foreach ($lastPrices as $currency => $price) {
            if (array_key_exists($currency, $currentPrices)) {
                $point = $currentPrices[$currency]['price'] / $price;
                if ($point > self::POINT_MAX) {
                    $interestArr[$currency] = round($point - 1, 2);
                }
            }
        }

        return $interestArr;
    }

}
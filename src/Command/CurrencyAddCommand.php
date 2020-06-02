<?php


namespace App\Command;


use App\Entity\Flow;
use App\Repository\CoinRepository;
use App\Service\BinanceCoinHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CurrencyAddCommand extends Command
{
    /** @var string  */
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

    public function __construct(BinanceCoinHandler $binanceCoinHandler, CoinRepository $coinRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->binanceCoinHandler = $binanceCoinHandler;
        $this->coinRepository = $coinRepository;
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this->setDescription('add currency to the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $prices = $this->binanceCoinHandler->getPrices();
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

}
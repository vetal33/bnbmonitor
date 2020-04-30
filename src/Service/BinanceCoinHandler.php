<?php


namespace App\Service;


use App\Repository\CoinRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class BinanceCoinHandler
{
    /**
     * @var CoinRepository
     */
    private $coinRepository;
    /**
     * @var HttpClientInterface
     */
    private $client;

    public function __construct(CoinRepository $coinRepository, HttpClientInterface $client)
    {
        $this->coinRepository = $coinRepository;
        $this->client = $client;
    }

    private function getAllCoins(): array
    {
        return $this->coinRepository->findBy(['isActive' => true]);
    }

    public function getPrices()
    {
        $prices = [];
        $coins = $this->getAllCoins();

        foreach ($coins as $coin) {
            $symbol = $coin->getShortName() . 'USDT';
            $res = $this->client->request('GET', 'https://api.binance.com/api/v3/ticker/price', [
                'query' => [
                    'symbol' => $symbol,
                ]
            ]);

            if ($res->getStatusCode() === 200) {
                $price = $res->toArray();
                $symbolCut = rtrim($price['symbol'], 'USDT');
                $prices[$symbolCut]['price'] = $price['price'];
            }
        }

        return $prices;
    }

    public function getValuesByPeriod(array $coins, int $interval)
    {
        $intervalStr = $interval . 'm';
        //$client = new Client();

        foreach ($coins as $coinShortName => $values) {
            $symbol = $coinShortName . 'USDT';
            $res = $this->client->request('GET', 'https://api.binance.com/api/v3/klines', [
                'query' => [
                    'symbol' => $symbol,
                    'interval' => $intervalStr,
                    'limit' => 1,
                ]
            ]);

            if ($res->getStatusCode() === 200) {
                $price =$res->toArray();
                $coins[$coinShortName]['value'] = $price[0][7];
                $coins[$coinShortName]['numberOfTrades'] = $price[0][8];
                $coins[$coinShortName]['interval'] = $interval;

                $timeEnd = mb_substr($price[0][6], 0, 10);

                $currentTime = new \DateTime();
                $currentTime->setTimezone(new \DateTimeZone('Europe/Kiev'));
                $coins[$coinShortName]['receivedAt'] = $currentTime;

                $endIntervalTime = new \DateTime();
                $endIntervalTime->setTimestamp($timeEnd);
                $endIntervalTime->setTimezone(new \DateTimeZone('Europe/Kiev'));
                $coins[$coinShortName]['endOfInterval'] = $endIntervalTime;
            }
        }

        return $coins;
    }

}
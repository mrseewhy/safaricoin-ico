<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Entities\Currency;
use GuzzleHttp\Client;

class RefreshCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates currency rates';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client();
        $response = $client->get('https://api.coinbase.com/v2/exchange-rates?currency=BTC');
        $body = $response->getBody();
        $bodyArray = json_decode($body, true);

        if (isset($bodyArray['data'])) {
            $currency = Currency::firstOrCreate([
                'currency_name_short' => Currency::CURRENCY_BTC
            ], [
                'currency_name' => 'Bitcoin',
                'rate' => 0
            ]);
            $currency->rate = $bodyArray['data']['rates']['USD'];
            $currency->save();
        }
    }
}

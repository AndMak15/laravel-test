<?php

namespace App\Console\Commands;

use App\Gift;
use App\Models\Banks\PrivateBank;
use App\Models\Gift\GiftRandom;
use App\Models\Gift\Gifts\MoneyGift;
use Illuminate\Console\Command;

class BankCommand extends Command
{
    const SIZE_CHUNK = 10;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bank:send-money';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send money for users';

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
     * @return int
     */
    public function handle()
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        Gift::query()->where(['type' => MoneyGift::TYPE_GIFT, 'is_send' => Gift::SEND])->chunk(self::SIZE_CHUNK,
            function ($gifts) use ($out){
                foreach ($gifts as $gift) {
                    $giftRand = new GiftRandom();
                    /** @var MoneyGift $giftModel */
                    $giftModel = $giftRand->getItem($gift->type, $gift->data_type);

                    /** @var $gift Gift */
                    $money = $giftModel->getMoney();
                    if ( !PrivateBank::sendMoney($gift->id_user, $money) ) {
                        $out->writeln("Error: for user id:{$gift->id_user} money not send");
                        continue;
                    }
                    $gift->update(['is_send' => Gift::SEND_MONEY]);
                    $out->writeln("For user id:{$gift->id_user} send money {$money}$");
                }
            }
        );

        return 0;
    }
}

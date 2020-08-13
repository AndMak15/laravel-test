<?php

namespace Tests\Unit;

use App\Models\Gift\Convert\GiftConvert;
use App\Models\Gift\Convert\GiftConvertToPoints;
use App\Models\Gift\GiftRandom;
use App\Models\Gift\Gifts\GiftItem;
use App\Models\Gift\Gifts\MoneyGift;
use App\Models\Gift\Gifts\PointsGift;
use PHPUnit\Framework\TestCase;

class GiftTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $type = MoneyGift::TYPE_GIFT;
        $data_type = '{"money":100}';
        $giftRand = new GiftRandom();
        /** @var GiftConvertToPoints $gift */
        $gift = $giftRand->getItem($type, $data_type);

        $coefficient = MoneyGift::COEFFICIENT_CONVERT_TO_POINT;
        /** @var PointsGift $newGift */
        $newGift = GiftConvert::toPoints($gift);
        $this->assertEquals($newGift->getPoints(), round($coefficient * 100));
    }
}

<?php


namespace App\Models\Gift\Convert;


use App\Models\Gift\GiftRandom;
use App\Models\Gift\Gifts\PointsGift;

class GiftConvert
{
    public static function toPoints(GiftConvertToPoints $gift) {
        $giftRand = new GiftRandom();
        return $giftRand->getItem(PointsGift::TYPE_GIFT, '{"points":' . $gift->convertGiftToPoints() . '}');
    }
}

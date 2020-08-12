<?php


namespace App\Models\Gift;


use App\Models\Gift\Gifts\GiftItem;
use App\Models\Gift\Gifts\MoneyGift;
use App\Models\Gift\Gifts\ObjectGift;
use App\Models\Gift\Gifts\PointsGift;

class GiftRandom
{
    const MAX_TRY = 5;
    /** @var $items GiftItem[] */
    private $items = [
        MoneyGift::TYPE_GIFT => MoneyGift::class,
        PointsGift::TYPE_GIFT => PointsGift::class,
        ObjectGift::TYPE_GIFT => ObjectGift::class
    ];

    /**
     * @param $type
     * @param $dataType
     * @return null|GiftItem
     */
    public function getItem($type, $dataType)
    {
        if (!isset($this->items[$type])) {
            return null;
        }
        /** @var GiftItem $model */
        $model = new $this->items[$type];
        $model->setData($dataType);
        return $model;
    }

    public function run(): GiftItem
    {
        $size = count($this->items) - 1;
        $cntTry = 0;
        do {
            $index = rand(0, $size);
            $item_object = $this->items[$index];
            $cntTry += 1;
            $object = $item_object::run();
        } while ($object === null || $cntTry < self::MAX_TRY);
        if ($cntTry > self::MAX_TRY) {
            $object = PointsGift::run();
        }

        return $object;
    }
}

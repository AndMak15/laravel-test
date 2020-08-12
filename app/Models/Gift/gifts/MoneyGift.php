<?php


namespace App\Models\Gift\Gifts;


use App\Models\Gift\Convert\GiftConvertToPoints;

class MoneyGift implements GiftItem, GiftConvertToPoints
{
    const TYPE_GIFT = 0;
    const MAX_VALUE_MONEY = 100;
    const MIN_VALUE_MONEY = 10;
    const COEFFICIENT_CONVERT_TO_POINT = 2.5;

    private $money;



    /**
     * Get title about gift
     *
     * @return string
     */
    public function getTitle(): string
    {
        return "Грошова винагорода у розмірі: {$this->money}$";
    }

    /**
     * Can be converted to points
     *
     * @return bool
     */
    public function isConvertToPoint(): bool
    {
        return true;
    }

    /**
     * Title for button action
     *
     * @return string
     */
    public function actionTitleButton(): string
    {
        return 'Відправити на банківський рахунок';
    }

    /**
     * Title after success action
     *
     * @return string
     */
    public function actionTitleSuccess(): string
    {
        return 'Запит на відправлення надіслано! Протягом певного часу гроші будуть нараховані!';
    }

    /**
     * Try get gift
     *
     * @return GiftItem|null
     */
    public static function run()
    {
        $allMoney = 1000; // TODO get with DB

        if ($allMoney <= 0) {
            return null;
        }

        if ($allMoney < self::MAX_VALUE_MONEY) {
            $money = $allMoney;
        } else {
            $money = rand(self::MIN_VALUE_MONEY, self::MAX_VALUE_MONEY);
        }

        $model = new MoneyGift();
        $model->setMoney($money);

        return $model;
    }

    /**
     * @return mixed
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * @param mixed $money
     */
    public function setMoney($money): void
    {
        $this->money = $money;
    }

    /**
     * Set data for gift
     *
     * @param $dataType
     */
    public function setData($dataType): void
    {
        $dataType = json_decode($dataType, true);
        $this->money = $dataType['money']??0;
    }

    /**
     * Get data for gift
     *
     * @return string
     */
    public function getData(): string
    {
        return json_encode([
            'money' => $this->money
        ]);
    }

    public function convertGiftToPoints()
    {
        return round($this->getMoney() * self::COEFFICIENT_CONVERT_TO_POINT);
    }
}

<?php


namespace App\Models\Gift\Gifts;


class PointsGift implements GiftItem
{
    const TYPE_GIFT = 2;
    const MIN_POINT = 1;
    const MAX_POINT = 10;

    private $points;

    public function __construct()
    {
        $this->points = rand(self::MIN_POINT, self::MAX_POINT);
    }

    /**
     * Get title about gift
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->points . ' балів лояльності';
    }

    /**
     * Can be converted to points
     *
     * @return bool
     */
    public function isConvertToPoint(): bool
    {
        return false;
    }

    /**
     * Title for button action
     *
     * @return string
     */
    public function actionTitleButton(): string
    {
        return 'Перерахувати на рахунок лояльності';
    }

    /**
     * Title after success action
     *
     * @return string
     */
    public function actionTitleSuccess(): string
    {
        return 'Бали лояльності перераховано';
    }

    /**
     * Try get gift
     *
     * @return GiftItem|null
     */
    public static function run()
    {
        return new self();
    }

    /**
     * Set data for gift
     *
     * @param $dataType
     */
    public function setData($dataType): void
    {
        $dataType = json_decode($dataType, true);
        $this->points = $dataType['points']??0;
    }

    /**
     * Get data for gift
     *
     * @return string
     */
    public function getData(): string
    {
        return json_encode([
            'points' => $this->points
        ]);
    }
}

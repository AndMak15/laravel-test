<?php


namespace App\Models\Gift\Gifts;


interface GiftItem
{
    /**
     * Get title about gift
     *
     * @return string
     */
    public function getTitle():string;

    /**
     * Can be converted to points
     *
     * @return bool
     */
    public function isConvertToPoint():bool;

    /**
     * Title for button action
     *
     * @return string
     */
    public function actionTitleButton():string;

    /**
     * Title after success action
     *
     * @return string
     */
    public function actionTitleSuccess():string;

    /**
     * Try get gift
     *
     * @return GiftItem|null
     */
    public static function run();

    /**
     * Set data for gift
     *
     * @param $dataType
     */
    public function setData($dataType):void;

    /**
     * Get data for gift
     *
     * @param $dataType
     * @return string
     */
    public function getData():string;
}

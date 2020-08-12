<?php


namespace App\Models\Gift\Gifts;


class ObjectGift implements GiftItem
{
    const TYPE_GIFT = 1;

    private $object;
    private $id;

    /**
     * Get title about gift
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->object;
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
        return 'Приняти подарунок';
    }

    /**
     * Title after success action
     *
     * @return string
     */
    public function actionTitleSuccess(): string
    {
        return 'Найблищим часом з Вами з\'яжуться для відправлення подарунку поштою';
    }

    /**
     * Try get gift
     *
     * @return GiftItem|null
     */
    public static function run()
    {
        // TODO get data with DB
        $all_gifts = [1 => 'Іграшка', 'Машина', 'Дерево', 'Пів мішка нічого']; // [ id => name]

        if (empty($all_gifts)) {
            return null;
        }

        $key = array_rand($all_gifts);

        $model = new self();
        $model->setObject($all_gifts[$key]);
        $model->setId($key);

        return $model;
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param mixed $object
     */
    public function setObject($object): void
    {
        $this->object = $object;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * Set data for gift
     *
     * @param $dataType
     */
    public function setData($dataType): void
    {
        $dataType = json_decode($dataType, true);
        $this->id = $dataType['id']??0;
        $this->object = $dataType['object']??'';
    }

    /**
     * Get data for gift
     *
     * @return string
     */
    public function getData(): string
    {
        return json_encode([
            'id' => $this->id,
            'object' => $this->object
        ]);
    }
}

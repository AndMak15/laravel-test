<?php

namespace App\Http\Controllers;

use App\Gift;
use App\Models\Gift\Convert\GiftConvert;
use App\Models\Gift\Convert\GiftConvertToPoints;
use App\Models\Gift\GiftRandom;
use App\Models\Gift\Gifts\GiftItem;
use App\Models\Gift\Gifts\PointsGift;
use Illuminate\Support\Facades\Auth;

class GiftController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     */
    public function index()
    {
        $idUser = Auth::id();
        $giftTable = Gift::query()->where(['id_user' => $idUser, 'is_send' => Gift::NOT_SEND])->first();
        if (!$giftTable) {
            return null;
        }

        $giftRand = new GiftRandom();
        $gift = $giftRand->getItem($giftTable->type, $giftTable->data_type);

        return [
            'title' => $gift->getTitle(),
            'actionTitleButton' => $gift->actionTitleButton(),
            'isConvert' => $gift->isConvertToPoint(),
        ];
    }

    /**
     * Cancel gift for user
     *
     */
    public function cancel()
    {
        $idUser = Auth::id();
        $giftTable = Gift::query()->where(['id_user' => $idUser, 'is_send' => Gift::NOT_SEND])->first();
        if (!$giftTable) {
            return [
                'titleSuccess' => 'Подарунок не знайдено',
            ];
        }

        $giftTable->delete();

        return [
            'response' => true,
        ];
    }

    /**
     * Run action from gift
     *
     */
    public function action()
    {
        $idUser = Auth::id();
        $giftTable = Gift::query()->where(['id_user' => $idUser, 'is_send' => Gift::NOT_SEND])->first();
        if (!$giftTable) {
            return [
                'titleSuccess' => 'Подарунок не знайдено',
            ];
        }

        $giftTable->is_send = Gift::SEND;
        if ($giftTable->save()) {
            $giftRand = new GiftRandom();

            $gift = $giftRand->getItem($giftTable->type, $giftTable->data_type);
            return [
                'titleSuccess' => $gift->actionTitleSuccess(),
            ];
        }

        return [
            'titleSuccess' => 'Помилка обробки подарунку',
        ];
    }

    /**
     * Convert gift to points
     *
     */
    public function convert()
    {
        $idUser = Auth::id();
        $giftTable = Gift::query()->where(['id_user' => $idUser, 'is_send' => Gift::NOT_SEND])->first();
        if (!$giftTable) {
            return [
                'titleSuccess' => 'Подарунок не знайдено',
            ];
        }

        $giftRand = new GiftRandom();
        $gift = $giftRand->getItem($giftTable->type, $giftTable->data_type);

        if ( !( $gift instanceof GiftConvertToPoints ) ) {
            return [
                'titleSuccess' => 'Подарунок конвертувати неможливо',
            ];
        }

        /** @var GiftItem $newGift */
        $newGift = GiftConvert::toPoints($gift);
        $giftTable->type = PointsGift::TYPE_GIFT;
        $giftTable->data_type = $newGift->getData();
        $giftTable->is_send = Gift::SEND;

        if (!$giftTable->save()) {
            return [
                'titleSuccess' => 'Невдала спроба конвертувати подарунок',
            ];
        }

        return [
            'titleSuccess' => 'Конвертація успішна. Ви отримали ' . $newGift->getTitle(),
        ];
    }

    /**
     * Get gift for user
     *
     */
    public function create()
    {
        $giftRand = new GiftRandom();
        $gift = $giftRand->run();

        $idUser = Auth::id();
        $giftTable = Gift::query()->where(['id_user' => $idUser, 'is_send' => Gift::NOT_SEND])->first();
        if (!$giftTable) {
            $giftTable = new Gift();
            $giftTable->type = $gift::TYPE_GIFT;
            $giftTable->id_user = $idUser;
            $giftTable->is_send = Gift::NOT_SEND;
            $giftTable->data_type = $gift->getData();
            $giftTable->save();
        }

        return [
            'title' => $gift->getTitle(),
            'actionTitleButton' => $gift->actionTitleButton(),
            'isConvert' => $gift->isConvertToPoint(),
        ];
    }
}

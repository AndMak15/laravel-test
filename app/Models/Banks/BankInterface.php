<?php


namespace App\Models\Banks;


interface BankInterface
{
    public static function sendMoney($idUser, $money);
}

<?php

namespace App\Http\Controllers;

use App\Gift;
use Illuminate\Http\Request;
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
        return [
            'title' => 'Грошова винагорода у розмірі: 1001$',
            'actionTitle' => 'Відправити на банківський рахунок',
            'isConvert' => true,
        ];
    }

    /**
     * Cancel gift for user
     *
     */
    public function cancel()
    {
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
        return [
            'titleSuccess' => 'Перераховано',
        ];
    }

    /**
     * Convert gift to points
     *
     */
    public function convert()
    {
        return [
            'titleSuccess' => 'Конвертація успішна',
        ];
    }

    /**
     * Get gift for user
     *
     */
    public function create()
    {
        return [
            'title' => 'Грошова винагорода у розмірі: 1001$',
            'actionTitle' => 'Відправити на банківський рахунок',
            'isConvert' => true,
        ];
    }
}

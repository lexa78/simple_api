<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Transaction;
use Illuminate\Support\Facades\Auth;

class TotalInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TransactionResource::collection(Auth::user()->transactions);
    }

    /**
     * Display a listing of the resource with positive amount.
     *
     * @param string $from - date of start transactions
     * @param string $to - date of end transactions
     * @return string
     */
    public function positive($from, $to)
    {
        $user_id = Auth::user()->id;
        return Transaction::where('author_id', $user_id)->
        where('amount', '>=', 0)->
        whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:59'])->
        sum('amount');
    }

    /**
     * Display a listing of the resource with negative amount.
     *
     * @param string $from - date of start transactions
     * @param string $to - date of end transactions
     * @return string
     */
    public function negative($from, $to)
    {
        $user_id = Auth::user()->id;
        return Transaction::where('author_id', $user_id)->
        where('amount', '<', 0)->
        whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:59'])->
        sum('amount');
    }

    /**
     * Display a listing of the resource with both amount (positive and negative).
     *
     * @param string $from - date of start transactions
     * @param string $to - date of end transactions
     * @return string
     */
    public function total($from, $to)
    {
        $user_id = Auth::user()->id;
        return Transaction::where('author_id', $user_id)->
        whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:59'])->
        sum('amount');
    }
}

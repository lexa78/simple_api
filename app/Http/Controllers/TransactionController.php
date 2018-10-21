<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a filtered listing of the user transactions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        if( ! $user_id) {
            return response()->json(['error'=>'Пользователь не авторизирован']);
        } else {
            $query = Transaction::where('author_id', $user_id);
            if( ! empty($request->positive)) {
                $query = $query->where('amount','>=',0);
            }
            if( ! empty($request->negative)) {
                $query = $query->where('amount','<',0);
            }
            if( ! empty($request->amount)) {
                $query = $query->where('amount', $request->amount);
            }
            if( ! empty($request->date)) {
                $query = $query->whereBetween('created_at', [$request->date.' 00:00:00', $request->date.' 23:59:59']);
            }
            return response()->json($query->get());
        }
    }

    /**
     * Display the specified transaction.
     *
     * @param  Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        if((Auth::user()->id == $transaction->author_id) &&  ! $transaction->deleted_at) {
            return response()->json($transaction);
        } else {
            return response()->json(['error'=>'Нет доступа']);
        }
    }

    /**
     * Store a newly created transaction in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transaction = Transaction::create($request->all());
        return response()->json($transaction, 201);
    }

    /**
     * Remove the specified transaction from storage.
     *
     * @param  Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function delete(Transaction $transaction)
    {
        $transaction->delete();
        return response()->json(null, 204);
    }
}

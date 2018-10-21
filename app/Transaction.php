<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    /**
     * ��������, ������� ������ ���� ������������� � ����.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Получить юзера, которому принадлежат транзакции.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

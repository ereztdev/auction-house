<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $table = 'bids';
    protected $fillable = ['item_id','user_id','bid_amount'];

    public function user()
    {
        return $this->hasOne('App\User');
    }
}

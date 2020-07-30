<?php

namespace App\Http\Controllers;

use App\Bid;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Rules\BidIsKosher;
use Illuminate\Support\Facades\Validator;

class BidController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return Response::api_fail([], 'unauthorized');
        }
        $user = Auth::user();
        //validation using a validation Service Provider
        $item = Item::find($request->item_id);
        if (!$item) {
            return Response::api_fail([], 'item does not exist');
        }

        $validator = Validator::make($request->all(), [
            'bid' => new BidIsKosher($item),
            'item_id' => 'required'
        ]);

        //bid model will be created regardless of being kosher
        //would also need to treat duplicity of same-user+same-bid
        $bid = Bid::create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'bid_amount' => $request->bid,
        ]);
        $bid->save();

        if (!$validator->fails()) {
            $item->min_price = $request->bid;
            $item->save();
        }
        return Response::api_success($item, "your {$request->bid} bid has been successfully registered");
    }
}

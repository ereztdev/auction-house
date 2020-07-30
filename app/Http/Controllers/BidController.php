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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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
        $item =  Item::find($request->item_id);
        if (!$item){
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


    /**
     * Display the user with the highest bid.
     * @param Request $request
     * @param Bid $bid
     * @return
     */
    public function getItem(Request $request,Bid $bid)
    {
        if (!$request->info){
            $validator = Validator::make($request->all(), [
                'info' => 'required',
            ]);
            if ($validator->fails()) {
                return Response::api_fail($validator->errors(), '');
            }
        }
        $highestBid = Bid::where(['bid_amount' => Bid::max('bid_amount')])->with(['user','item'])->first();
        $item = $highestBid->item;
        $itemHighestBid =
        dd($highestBid->bid);
        $res = [
            'id' => $highestBid->id,
            'name' => $highestBid->item->name,
            'min_bid' =>$highestBid->bid_amount,
            'highest_bid' =>null,
            'highest_bid_user_id' =>null,


        ];

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function edit(Bid $bid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Bid $bid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bid $bid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Bid $bid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bid $bid)
    {
        //
    }
}

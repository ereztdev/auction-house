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

        if ($validator->fails()) {
            return Response::api_fail($validator->errors(), 'unauthorized');
        }

        $bid = Bid::create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'bid_amount' => $request->bid,
        ]);
        $bid->save();

        $item->min_price = $request->bid;
        $item->save();

        return Response::api_success($item, "your {$request->bid} bid has been successfully registered");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function show(Bid $bid)
    {
        //
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

<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ItemController extends Controller
{

    /**
     * The right and safer way to execute auth on API calls is with Auth2
     * email:joe_tester@gmail.com
     * password:password
     *
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return Response::api_fail([], 'not authorized');
        }

        $item = Item::create([
            'cat_id' => $request->cat_id,
            'name' => $request->name,
            'min_price' => $request->min_price,
        ]);
        $item->save();

        return Response::api_success($item,'success');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Item $item
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function show($id, Item $item, Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return Response::api_fail([], 'unauthorized');
        }

        $item = Item::find($id);
        $bids = $item->bids()->get();
        $minBid = $bids->min('bid_amount');
        $highestBid = $bids->where('bid_amount', $bids->max('bid_amount'))->first();

        $res = [
            'id' => $item->id,
            'name' => $item->name,
            'min_bid' => $minBid,
            'highest_bid' => $highestBid->bid_amount,
            'highest_bid_user_id' => $highestBid->user_id,
        ];
        return Response::api_success($res, 'fetched item successfully');
    }
}

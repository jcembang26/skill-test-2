<?php

namespace App\Http\Controllers;

use App\Models\WidgetProduct;
use Illuminate\Http\Request;

class WidgetProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $prodId = 0)
    {
        if($prodId === 0){
            return response()->json(['message' => 'Missing required parameter/s!'], 400);
        }

        return WidgetProduct::where('product_id', $prodId)->delete();
    }

    public function upsert(Request $request)
    {
        $prodId = intval($request->id) === 0 ? intval($request->lastInsertedId) : intval($request->id);

        return WidgetProduct::firstOrCreate([
            'widget_id' => 1, // force to 1
            'product_id' => $prodId
        ]);
    }

    public function countProduct(Request $request): object
    {

        $widgetId = $request->widgetId ? intval($request->widgetId) : 1; // force 1 for product of the day widget

        if($widgetId === 0){
            return response()->json(['message' => 'Missing required parameters!'], 400);
        }

        $res = WidgetProduct::where('widget_id', $widgetId)->count();


        return response()->json($res);
    }
}

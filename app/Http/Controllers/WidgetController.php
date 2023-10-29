<?php

namespace App\Http\Controllers;

use App\Models\Widget;
use App\Models\WidgetProduct;
use App\Models\WidgetSetting;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():object
    {
        $data = Widget::all();

        return response()->json($data);
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
    public function destroy(string $id)
    {
        //
    }

    public function handleWidgets(Request $request)
    {
        $res = [];
        $wList = Widget::all();

        if(empty($wList)) {
            return response()->json(['message' => 'Empty']);
        }

        foreach ($wList as $value) {
            
            $wSet = WidgetSetting::where('widget_id', $value->id)->first();
            $wProd = WidgetProduct::with('details')->where('widget_id', $value->id)->get();

            foreach ($wProd as &$value) {
                $path = 'storage/uploads/'.$value->details['image'];
                $value->details['image'] = asset($path);
            }

            $res[] = [
                'id' => $value->id,
                'name' => $value->name,
                'label' => $wSet->label ?? $value->name,
                'slot' => $wSet->page_slot_id ?? 1, // hero default slot,
                'products' => $wProd
            ];
        }

        return response()->json($res);
    }
}

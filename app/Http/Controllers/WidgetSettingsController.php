<?php

namespace App\Http\Controllers;

use App\Models\Widget;
use App\Models\WidgetSetting;
use Illuminate\Http\Request;

class WidgetSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $id = $request->id ? intval($request->id) : 0;

        if($id === 0) {
            return response()->json(['message' => 'Missing required params!'], 400);
        }

        $data = WidgetSetting::with('products')->where('widget_id', $id)->first();

        return response()->json($data->toArray());
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

    public function upsert(Request $request)
    {
        $widgetId = $request->id ? intval($request->id) : 0;

        if($widgetId === 0) return response()->json(['message' => 'Missing required parameters!'], 400);

        $q = WidgetSetting::updateOrCreate(
            [
                'widget_id' => $widgetId
            ],
            [
                'label' => $request->label,
                'email' => $request->email,
                'page_slot_id' => $request->slot
            ]
        );
    }
}

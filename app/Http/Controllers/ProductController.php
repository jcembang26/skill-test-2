<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\StoreProductrequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = Product::all();

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
    public function store(ProductRequest $request)
    {
        $q = Product::create([
            'name' => $request->name,
            'image' =>  $request->image ? $request->image->getClientOriginalName() : null,
            'summary' => $request->summary,
        ]);

        if($q){
            $this->upload($request);
            
            $wpc = new WidgetProductController();

            if(intval($request->pod)){
                $request->merge(['lastInsertedId' => $q->id]);
                $wpc->upsert($request);
            } else {
                $wpc->destroy($q->id);
            }
        }

        return response()->json('Product Created');
    }

    private function upload($request){
        if ($request->file() && $request->image) {
            $file_name = $request->image->getClientOriginalName();
            $request->file('image')->storeAs('uploads', $file_name, 'public');

            return response()->json(['success' => 'File uploaded successfully.']);
        }
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
    public function edit(int $id)
    {
        if($id === 0){
            return response()->json(['message' => 'Project does not exist!'], 404);
        }

        $data = Product::with('widget')->find($id)->toArray();
        
        $path = 'storage/uploads/' . $data['image'];
        $data['image'] = asset($path);

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request): bool
    {
        $find = Product::find($request->id);
        
        if(!$find) {
            return false;
        }

        $find->name = $request->name ?? '';
        $find->summary = $request->summary ?? '';

        if($request->image){
            $find->image = $request->image ? $request->image->getClientOriginalName() : null;
        }
        
        if(!$find->save()) {
            return false;
        }

        if ($request->image) {
            $this->upload($request);
        }

        $wpc = new WidgetProductController();
        if (intval($request->pod)) {
            $wpc->upsert($request);
        }else{
            $wpc->destroy($request->id);
        }

        return true;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function upsert(ProductRequest $request): object
    {
        if($request->id > 0){
            // update
            $res = $this->update($request);
        }else{
            // store
            $res = $this->store($request);
        }

        return response()->json($res);
    }
}

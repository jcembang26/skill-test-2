<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WidgetProduct extends Model
{
    use HasFactory;


    protected $fillable = ['id', 'product_id', 'widget_id'];


    /**
     * Get the details associated with the WidgetProduct
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function details()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

}

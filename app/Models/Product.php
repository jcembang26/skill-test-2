<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $fillable = ['id', 'name', 'image', 'summary', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * Get the widget associated with the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function widget()
    {
        return $this->hasOne(WidgetProduct::class, 'product_id', 'id');
    }
}

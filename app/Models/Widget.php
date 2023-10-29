<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use HasFactory;

    protected $table = 'widgets';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'name', 'label'];

    /**
     * Get all of the products for the Widget
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }
}

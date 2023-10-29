<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WidgetSetting extends Model
{
    use HasFactory;

    protected $table = 'widget_settings';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'widget_id', 'label', 'email', 'page_slot_id'];

    /**
     * Get all of the product for the WidgetSetting
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(WidgetProduct::class, 'widget_id', 'widget_id')->with('details');
    }
}

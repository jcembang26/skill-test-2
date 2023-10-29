<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    protected $table = 'widget_settings';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->integer('widget_id')->unsigned()->nullable()->default(12);
            $table->mediumText('label')->nullable()->default(null);
            $table->mediumText('email')->nullable()->default(null);
            $table->integer('page_slot_id')->unsigned()->nullable()->default(1); // hero
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('image', 2000)->nullable();
            $table->string('name', 20);
            $table->double('unit_price', 10, 2)->nullable(false);
            $table->integer('quantity_stock')->default(0)->nullable(false);
            $table->foreignIdFor(\App\Models\Category::class)->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Category::class);
        });
        Schema::dropIfExists('articles');
    }
};

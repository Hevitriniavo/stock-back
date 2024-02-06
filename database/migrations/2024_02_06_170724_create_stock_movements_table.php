<?php

use App\Models\Article;
use App\Models\Supplier;
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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->date('movement_date');
            $table->integer('quantity');
            $table->string('movement_type', 10);
            $table->foreignIdFor(Article::class)->constrained();
            $table->foreignIdFor(Supplier::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->dropForeignIdFor(Supplier::class);
            $table->dropForeignIdFor(Article::class);
        });
        Schema::dropIfExists('stock_movements');
    }
};

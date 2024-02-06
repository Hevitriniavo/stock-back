<?php

use App\Models\Article;
use App\Models\Purchase;
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
        Schema::create('purchase_lines', function (Blueprint $table) {
            $table->id();
            $table->double('buying_price', 10, 2)->default(0);
            $table->unsignedInteger('quantity');
            $table->foreignIdFor(Article::class)->constrained();
            $table->foreignIdFor(Purchase::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_lines', function (Blueprint $table) {
            $table->dropForeignIdFor(Article::class);
            $table->dropForeignIdFor(Purchase::class);
        });
        Schema::dropIfExists('purchase_lines');
    }
};

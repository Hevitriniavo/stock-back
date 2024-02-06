<?php

use App\Models\Article;
use App\Models\Delivery;
use App\Models\Order;
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
        Schema::create('delivery_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quantity_delivered');
            $table->foreignIdFor(Delivery::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Order::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Article::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('delivery_details', function (Blueprint $table) {
            $table->dropForeignIdFor(Delivery::class);
            $table->dropForeignIdFor(Order::class);
            $table->dropForeignIdFor(Article::class);
        });
        Schema::dropIfExists('delivery_details');
    }
};

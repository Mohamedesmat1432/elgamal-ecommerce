<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('grand_total', 10, 2);
            $table->decimal('shipping_amount', 10, 2)->default(0);
            $table->enum('shipping_method', ['fedex', 'ups', 'usps', 'hdl', 'none'])->default('none');
            $table->enum('payment_method', ['stripe', 'cod'])->default('cod');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('currency', ['inr', 'usd', 'eur'])->default('inr');
            $table->enum('status', ['new', 'processing', 'shipped', 'delivered', 'canceled'])->default('new');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

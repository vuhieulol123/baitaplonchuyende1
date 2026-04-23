<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('occasion')->nullable(); // dịp lễ, tháng sale...
            $table->text('description')->nullable();

            $table->enum('apply_type', ['all', 'category', 'product'])->default('all');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            $table->decimal('discount_percent', 5, 2)->default(0);

            $table->date('start_date');
            $table->date('end_date');

            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
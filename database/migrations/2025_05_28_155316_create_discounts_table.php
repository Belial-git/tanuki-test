<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table): void {
            $table->id();
            $table->string('type')
                ->comment('Тип скидки');
            $table->string('condition')
                ->comment('Условие');
            $table->integer('discount_sum')
                ->nullable()
                ->comment('Сумма скидки');
            $table->integer('discount_percent')
                ->nullable()
                ->comment('Процент скидки');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};

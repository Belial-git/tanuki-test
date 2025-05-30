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
        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            $table->string('title')
                   ->comment('Наименование товара');
            $table->string('description')
                ->comment('Описание товара');
            $table->decimal('price', 8, 2)
                ->comment('Цена');
            $table->boolean('is_stopped')
                ->default(false)
                ->comment('Остановлено');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

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
        Schema::create('baskets', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('user_id')
                ->nullable()
                ->default(null)
                ->comment('ИД пользователя');
            $table->jsonb('products')
                ->nullable()
                ->default(null)
                ->comment('Товары');
            $table->decimal('total_price')
                ->nullable()
                ->default(null)
                ->comment('Цена за все');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baskets');
    }
};

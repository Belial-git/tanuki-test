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
        Schema::create('orders', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('basket_id')
                ->comment('ИД корзины');
            $table->unsignedBigInteger('user_id')
                ->comment('ИД корзины');
            $table->string('address')
                ->comment('Адрес');
            $table->string('phone')
                ->comment('Телефон');
            $table->string('status')
                ->comment('Статус');
            $table->decimal('discount')
                ->default(0)
                ->comment('Скидка');
            $table->decimal('final_price')
                ->comment('Итоговая цена');

            $table->timestamps();

            $table->foreign('basket_id')
                ->references('id')
                ->on('baskets');
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
        Schema::dropIfExists('orders');
    }
};

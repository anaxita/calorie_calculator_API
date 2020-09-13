<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('product_num')->unsigned(); // количество продукта
            $table->integer('calorie_num')->unsigned(); // количество калорий продукта
            $table->boolean('counting_type'); // тип подсчета калорий
            $table->integer('calorie_total')->unsigned(); //  количество калорий фактическое
            $table->foreignId('user_id') // user id зависи от id таблицы users и удаляется если пропал user id (удалили юзера)
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

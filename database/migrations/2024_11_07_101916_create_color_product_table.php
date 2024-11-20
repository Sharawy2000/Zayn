<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateColorProductTable extends Migration {

	public function up()
	{
		Schema::create('color_product', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('color_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->decimal('price_adjustment')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('color_product');
	}
}
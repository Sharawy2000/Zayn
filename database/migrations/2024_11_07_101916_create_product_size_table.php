<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductSizeTable extends Migration {

	public function up()
	{
		Schema::create('product_size', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('product_id')->unsigned();
			$table->integer('size_id')->unsigned();
			$table->timestamps();
			$table->decimal('price_adjustment')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('product_size');
	}
}
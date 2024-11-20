<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->integer('category_id')->unsigned();
			$table->longText('description');
			$table->decimal('price');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('products');
	}
}
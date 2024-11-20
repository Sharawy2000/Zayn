<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCartsTable extends Migration {

	public function up()
	{
		Schema::create('carts', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('customer_id')->unsigned();
			$table->decimal('price');
			$table->decimal('price_after_offer')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('carts');
	}
}
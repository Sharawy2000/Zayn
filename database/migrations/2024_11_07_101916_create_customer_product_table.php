<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerProductTable extends Migration {

	public function up()
	{
		Schema::create('customer_product', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('customer_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('customer_product');
	}
}
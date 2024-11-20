<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('customer_id')->unsigned();
			$table->decimal('total_price');
			$table->decimal('price_after_offer')->nullable();
			$table->integer('payment_method_id')->unsigned();
			$table->decimal('shipping_fees')->default(0);
			$table->tinyInteger('status');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}
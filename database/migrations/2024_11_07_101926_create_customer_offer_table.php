<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerOfferTable extends Migration {

	public function up()
	{
		Schema::create('customer_offer', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('customer_id')->unsigned();
			$table->integer('offer_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('customer_offer');
	}
}
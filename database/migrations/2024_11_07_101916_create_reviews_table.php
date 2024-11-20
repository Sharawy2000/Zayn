<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReviewsTable extends Migration {

	public function up()
	{
		Schema::create('reviews', function(Blueprint $table) {
			$table->increments('id');
			$table->string('comment')->nullable();
			$table->tinyInteger('rate')->nullable();
			$table->integer('customer_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('reviews');
	}
}
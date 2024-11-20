<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('description');
			$table->integer('discount');
			$table->date('date_begin');
			$table->date('date_end');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}
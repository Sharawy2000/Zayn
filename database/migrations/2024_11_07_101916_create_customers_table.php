<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomersTable extends Migration {

	public function up()
	{
		Schema::create('customers', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('phone');
			$table->string('email');
			$table->string('password');
			$table->integer('neighborhood_id');
			$table->string('reset_code')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('customers');
	}
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHomeSlidesTable extends Migration {

	public function up()
	{
		Schema::create('home_slides', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->longText('description')->nullable();
			$table->string('image');
			$table->longText('alt_text')->nullable();
			$table->integer('order')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('home_slides');
	}
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->longText('about_us')->nullable();
			$table->string('app_title')->nullable();
			$table->string('android_link')->nullable();
			$table->string('ios_link')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
            $table->string('facebook');
            $table->string('twitter');
            $table->string('instagram');
            $table->float('commission');
            $table->longText('about_app');
            $table->longText('terms');
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->integer('phone');
			$table->integer('region_id')->unsigned();
			$table->text('description');
			$table->string('password');
			$table->string('image');
			$table->string('api_token',60)->nullable();
			$table->string('pin_code',6)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCardsTable extends Migration {

	public function up()
	{
		Schema::create('cards', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('order_id')->unsigned();
			$table->integer('client_id')->unsigned();
			$table->string('total_summation');
			$table->integer('item_id')->unsigned();
			$table->integer('price');
			$table->integer('quantity');
		});
	}

	public function down()
	{
		Schema::drop('cards');
	}
}
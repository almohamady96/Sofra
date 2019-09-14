<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title');
            $table->string('title_en');
            $table->text('content')->nullable();
            $table->text('content_en')->nullable();
			$table->integer('notifiable_id');
			$table->string('notifiable_type');
            $table->integer('client_id')->unsigned();
            $table->integer('order_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}
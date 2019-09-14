<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	public function up()
	{
		Schema::create('contacts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->string('notes');
			$table->enum('status', array('Complaint', 'Suggestion', 'Enquiry'));
		});
	}

	public function down()
	{
		Schema::drop('contacts');
	}
}
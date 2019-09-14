<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()

	{
        Schema::create('orders', function(Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->text('note')->nullable();
            $table->text('address');
            $table->integer('payment_id')->unsigned();
            $table->decimal('commission')->nullable();
            $table->decimal('net')->nullable();
            $table->decimal('cost')->default(0.00);
            $table->decimal('delivery_cost')->default(0.00);
            $table->decimal('total')->default(0.00);
            $table->integer('restaurant_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->datetime('delivered_at')->nullable();
           // $table->enum('status', array('pending', 'accepted', 'rejected','delivered','declined'));
            $table->enum('status', array('pending', 'accepted', 'rejected'));
            $table->string('orderable_type')->nullable();
            $table->integer('orderable_id')->nullable();


        });

	}

	public function down()
	{
		Schema::drop('orders');
	}
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('restaurants', function(Blueprint $table) {
			$table->foreign('region_id')->references('id')->on('regions')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('regions', function(Blueprint $table) {
			$table->foreign('city_id')->references('id')->on('cities')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('category_restaurant', function(Blueprint $table) {
			$table->foreign('category_id')->references('id')->on('categories')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('category_restaurant', function(Blueprint $table) {
			$table->foreign('restaurant_id')->references('id')->on('restaurants')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('offers', function(Blueprint $table) {
			$table->foreign('restaurant_id')->references('id')->on('restaurants')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('items', function(Blueprint $table) {
			$table->foreign('restaurant_id')->references('id')->on('restaurants')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('restaurant_id')->references('id')->on('restaurants')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
        Schema::table('orders', function(Blueprint $table) {
            $table->foreign('payment_id')->references('id')->on('payments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('orders', function(Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
		Schema::table('item_order', function(Blueprint $table) {
			$table->foreign('item_id')->references('id')->on('items')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('item_order', function(Blueprint $table) {
			$table->foreign('order_id')->references('id')->on('orders')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('cards', function(Blueprint $table) {
			$table->foreign('order_id')->references('id')->on('orders')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('cards', function(Blueprint $table) {
			$table->foreign('client_id')->references('id')->on('cities')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('cards', function(Blueprint $table) {
			$table->foreign('item_id')->references('id')->on('items')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('clients', function(Blueprint $table) {
			$table->foreign('region_id')->references('id')->on('regions')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('rates', function(Blueprint $table) {
			$table->foreign('client_id')->references('id')->on('clients')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('rates', function(Blueprint $table) {
			$table->foreign('restaurant_id')->references('id')->on('restaurants')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
        Schema::table('notifications', function(Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('notifications', function(Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

	}

	public function down()
	{
		Schema::table('restaurants', function(Blueprint $table) {
			$table->dropForeign('restaurants_region_id_foreign');
		});
		Schema::table('regions', function(Blueprint $table) {
			$table->dropForeign('regions_city_id_foreign');
		});
		Schema::table('category_restaurant', function(Blueprint $table) {
			$table->dropForeign('category_restaurant_category_id_foreign');
		});
		Schema::table('category_restaurant', function(Blueprint $table) {
			$table->dropForeign('category_restaurant_restaurant_id_foreign');
		});
		Schema::table('offers', function(Blueprint $table) {
			$table->dropForeign('offers_restaurant_id_foreign');
		});
		Schema::table('items', function(Blueprint $table) {
			$table->dropForeign('items_restaurant_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_restaurant_id_foreign');
		});
        Schema::table('orders', function(Blueprint $table) {
            $table->dropForeign('orders_payment_id_foreign');
        });
        Schema::table('orders', function(Blueprint $table) {
            $table->dropForeign('orders_client_id_foreign');
        });
		Schema::table('item_order', function(Blueprint $table) {
			$table->dropForeign('item_order_item_id_foreign');
		});
		Schema::table('item_order', function(Blueprint $table) {
			$table->dropForeign('item_order_order_id_foreign');
		});
		Schema::table('cards', function(Blueprint $table) {
			$table->dropForeign('cards_order_id_foreign');
		});
		Schema::table('cards', function(Blueprint $table) {
			$table->dropForeign('cards_client_id_foreign');
		});
		Schema::table('cards', function(Blueprint $table) {
			$table->dropForeign('cards_item_id_foreign');
		});
		Schema::table('clients', function(Blueprint $table) {
			$table->dropForeign('clients_region_id_foreign');
		});
		Schema::table('rates', function(Blueprint $table) {
			$table->dropForeign('rates_client_id_foreign');
		});
		Schema::table('rates', function(Blueprint $table) {
			$table->dropForeign('rates_restaurant_id_foreign');
		});
        Schema::table('notifications', function(Blueprint $table) {
            $table->dropForeign('notifications_client_id_foreign');
        });
        Schema::table('notifications', function(Blueprint $table) {
            $table->dropForeign('notifications_order_id_foreign');
        });

	}
}
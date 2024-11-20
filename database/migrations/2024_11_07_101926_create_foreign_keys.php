<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('products', function(Blueprint $table) {
			$table->foreign('category_id')->references('id')->on('categories')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('customer_id')->references('id')->on('customers')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('payment_method_id')->references('id')->on('payment_methods')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('customer_product', function(Blueprint $table) {
			$table->foreign('customer_id')->references('id')->on('customers')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('customer_product', function(Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('order_product', function(Blueprint $table) {
			$table->foreign('order_id')->references('id')->on('orders')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('order_product', function(Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('product_size', function(Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('product_size', function(Blueprint $table) {
			$table->foreign('size_id')->references('id')->on('sizes')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('color_product', function(Blueprint $table) {
			$table->foreign('color_id')->references('id')->on('colors')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('color_product', function(Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('images', function(Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('neighborhoods', function(Blueprint $table) {
			$table->foreign('city_id')->references('id')->on('cities')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('cities', function(Blueprint $table) {
			$table->foreign('country_id')->references('id')->on('countries')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('reviews', function(Blueprint $table) {
			$table->foreign('customer_id')->references('id')->on('customers')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('reviews', function(Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('carts', function(Blueprint $table) {
			$table->foreign('customer_id')->references('id')->on('customers')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('cart_items', function(Blueprint $table) {
			$table->foreign('cart_id')->references('id')->on('carts')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('cart_items', function(Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('cart_items', function(Blueprint $table) {
			$table->foreign('color_id')->references('id')->on('colors')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('cart_items', function(Blueprint $table) {
			$table->foreign('size_id')->references('id')->on('sizes')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('customer_offer', function(Blueprint $table) {
			$table->foreign('customer_id')->references('id')->on('customers')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('customer_offer', function(Blueprint $table) {
			$table->foreign('offer_id')->references('id')->on('offers')
						->onDelete('cascade')
						->onUpdate('cascade');
		});

	}

	public function down()
	{
		Schema::table('products', function(Blueprint $table) {
			$table->dropForeign('products_category_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_customer_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_payment_method_id_foreign');
		});
		Schema::table('customer_product', function(Blueprint $table) {
			$table->dropForeign('customer_product_customer_id_foreign');
		});
		Schema::table('customer_product', function(Blueprint $table) {
			$table->dropForeign('customer_product_product_id_foreign');
		});
		Schema::table('order_product', function(Blueprint $table) {
			$table->dropForeign('order_product_order_id_foreign');
		});
		Schema::table('order_product', function(Blueprint $table) {
			$table->dropForeign('order_product_product_id_foreign');
		});
		Schema::table('product_size', function(Blueprint $table) {
			$table->dropForeign('product_size_product_id_foreign');
		});
		Schema::table('product_size', function(Blueprint $table) {
			$table->dropForeign('product_size_size_id_foreign');
		});
		Schema::table('color_product', function(Blueprint $table) {
			$table->dropForeign('color_product_color_id_foreign');
		});
		Schema::table('color_product', function(Blueprint $table) {
			$table->dropForeign('color_product_product_id_foreign');
		});
		Schema::table('images', function(Blueprint $table) {
			$table->dropForeign('images_product_id_foreign');
		});
		Schema::table('neighborhoods', function(Blueprint $table) {
			$table->dropForeign('neighborhoods_city_id_foreign');
		});
		Schema::table('cities', function(Blueprint $table) {
			$table->dropForeign('cities_country_id_foreign');
		});
		Schema::table('reviews', function(Blueprint $table) {
			$table->dropForeign('reviews_customer_id_foreign');
		});
		Schema::table('reviews', function(Blueprint $table) {
			$table->dropForeign('reviews_product_id_foreign');
		});
		Schema::table('carts', function(Blueprint $table) {
			$table->dropForeign('carts_customer_id_foreign');
		});
		Schema::table('cart_items', function(Blueprint $table) {
			$table->dropForeign('cart_items_cart_id_foreign');
		});
		Schema::table('cart_items', function(Blueprint $table) {
			$table->dropForeign('cart_items_product_id_foreign');
		});
		Schema::table('cart_items', function(Blueprint $table) {
			$table->dropForeign('cart_items_color_id_foreign');
		});
		Schema::table('cart_items', function(Blueprint $table) {
			$table->dropForeign('cart_items_size_id_foreign');
		});
		Schema::table('customer_offer', function(Blueprint $table) {
			$table->dropForeign('customer_offer_customer_id_foreign');
		});
		Schema::table('customer_offer', function(Blueprint $table) {
			$table->dropForeign('customer_offer_offer_id_foreign');
		});
	}
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReviewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reviews', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('reviews_user_foreign');
			$table->char('name')->nullable();
			$table->char('contact')->nullable();
			$table->char('link_name')->nullable();
			$table->char('link_id')->nullable();
			$table->text('url_post')->nullable();
			$table->char('city')->nullable();
			$table->text('comment')->nullable();
			$table->text('answer')->nullable();
			$table->char('answer_author')->nullable();
			$table->integer('rating')->nullable();
			$table->integer('active')->nullable();
			$table->integer('public_in_feed')->nullable();
            $table->dateTime('date')->nullable();
			$table->timestamps();

            $table->index(['user_id', 'active']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('reviews');
	}

}

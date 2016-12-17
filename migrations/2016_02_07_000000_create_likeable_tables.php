<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLikeableTables extends Migration
{
	public function up()
	{
		Schema::create('likeable_likes', function(Blueprint $table) {
			$table->uuid('id');
			$table->uuid('likeable_id')->index();
			$table->string('likeable_type', 255)->index();
			$table->uuid('user_id')->index();
			$table->timestamps();
			$table->primary('id');
			$table->unique(['likeable_id', 'likeable_type', 'user_id'], 'likeable_likes_unique');
            $table->foreign('user_id')->references('id')->on('users');
		});
		
		Schema::create('likeable_like_counters', function(Blueprint $table) {
			$table->uuid('id');
			$table->uuid('likeable_id')->index();
			$table->string('likeable_type', 255)->index();
			$table->unsignedBigInteger('count')->default(0);
			$table->primary('id');
			$table->unique(['likeable_id', 'likeable_type'], 'likeable_counts');
		});
		
	}

	public function down()
	{
		Schema::drop('likeable_likes');
		Schema::drop('likeable_like_counters');
	}
}

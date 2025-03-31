<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
			$table->string('title')->nullable(false); 
			$table->string('name')->nullable(false); 
			$table->string('photo')->nullable(false); 
			$table->string('post_by_name')->nullable(false); 
			$table->string('post_by_phone')->nullable(false); 
			$table->string('post_by_email')->nullable(); 
			$table->string('related_to')->nullable(); 
			$table->string('condition')->nullable(); 
			$table->text('description')->nullable(); 
			$table->string('address')->nullable(); 
			$table->integer('city_id')->nullable(false); 
			$table->integer('township_id')->nullable(false); 
			$table->integer('country_id')->nullable(false); 
			$table->decimal('latitude')->nullable(); 
			$table->decimal('longitude')->nullable(); 
			$table->string('status')->nullable(false); 
			$table->string('severity')->nullable(false); 

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        
        Schema::drop('incidents');
    }
};
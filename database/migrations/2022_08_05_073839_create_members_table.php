<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->text('first_name');
            $table->text('last_name');
            $table->date('birthday');
            $table->string('report_subject');
            $table->text('country');
            $table->string('phone');
            $table->string('email');
            $table->string('company')->nullable();
            $table->string('position')->nullable();
            $table->string('about_me')->nullable();
            $table->string('photo')->default('default.png');
            $table->integer('is_shown')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}

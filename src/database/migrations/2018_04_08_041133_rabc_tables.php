<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RabcTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try{
            Schema::create('roles',function(Blueprint $table){
                $table->engine="InnoDB";
                $table->increments('id');
                $table->string('name')->unique();
                $table->string('display_name')->nullable(false)->defalult('');
                $table->string('description')->nullable(false)->defalult('');
                $table->timestamps();
            });
            Schema::create('role_user',function(Blueprint $table){
                $table->engine="InnoDB";
                $table->integer('user_id')->unsigned();
                $table->integer('role_id')->unsigned();

                $table->foreign('user_id')->references('id')->on('users')
                    ->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('role_id')->references('id')->on('roles')
                    ->onUpdate('cascade')->onDelete('cascade');
                $table->primary(['user_id','role_id']);
            });
            Schema::create('permissions',function(Blueprint $table){
                $table->engine="InnoDB";
                $table->increments('id');
                $table->string('name')->unique();
                $table->string('display_name')->nullable(false)->defalult('');
                $table->string('description')->nullable(false)->defalult('');
                $table->timestamps();
            });
            Schema::create('permission_role',function(Blueprint $table){
                $table->engine="InnoDB";
                $table->integer('permission_id')->unsigned();
                $table->integer('role_id')->unsigned();

                $table->foreign('permission_id')->references('id')->on('permissions')
                    ->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('role_id')->references('id')->on('roles')
                    ->onUpdate('cascade')->onDelete('cascade');
                $table->primary(['permission_id','role_id']);
            });



        }catch(Exception $err){
            $this->down();
            throw  $err;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('permissions');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('role_user');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('refer_code')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1= enable, 0=disable');
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });


        DB::table('users')->insert(
            array(
                array(
                    'name' => 'admin',
                    'email' => 'admin@test.com',
                    'refer_code' => '1s6gclEuUo',
                    'status' => 1,
                    'password' => '$2y$10$46Y2SPvnA.GIejLuevj5Q.x/oHV8.nAcv/pMNC6wWZ3Cjjq3iw9A2',
                    'created_at' => '2022-12-23 00:00:00',
                    'updated_at' => '2022-12-23 00:00:00'
                )
            )
        );
        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

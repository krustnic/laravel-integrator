<?php
namespace Krustnic\Integrator;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIntegratorTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integrator_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('token');
            $table->string('path')->nullable();
            // In seconds
            $table->integer('lifetime')->unsigned()->default(60);
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->index('token');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('integrator_tokens');
    }
}
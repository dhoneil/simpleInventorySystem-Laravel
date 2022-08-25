<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('appointment_id');
            $table->integer('customer_id')->nullable(true);
            $table->integer('beautician_id');
            $table->integer('service_id');
            $table->integer('product_id');
            $table->dateTime('schedule');
            $table->decimal('total_amount');
            $table->string('appointment_status'); //PENDING, ON-GOING, CANCELLED, DONE
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
        Schema::dropIfExists('appointments');
    }
}

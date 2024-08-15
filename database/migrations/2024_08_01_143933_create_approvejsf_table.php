<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovejsfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvejsf', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IDJobRequestForms')->constrained('jobrequestforms')->onDelete('cascade');
            $table->foreignId('IDMember')->constrained('users')->onDelete('cascade');
            $table->timestamp('TimeStamp')->nullable();
            $table->boolean('Status')->nullable(); // 1: Chấp thuận, 0: Từ chối
            $table->integer('No'); // Thứ tự approve
            $table->string('Note')->nullable();
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
        Schema::dropIfExists('approvejsf');
    }
}

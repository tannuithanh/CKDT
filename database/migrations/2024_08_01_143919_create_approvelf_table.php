<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovelfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvelf', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IDLeaveForms')->constrained('leaveforms')->onDelete('cascade');
            $table->foreignId('IDMember')->constrained('users')->onDelete('cascade');
            $table->timestamp('TimeStamp')->nullable();
            $table->string('Note')->nullable();
            $table->boolean('Status')->nullable(); // 1: Chấp thuận, 0: Từ chối
            $table->integer('No'); // Thứ tự approve
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
        Schema::dropIfExists('approvelf');
    }
}

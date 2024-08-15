<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaveforms', function (Blueprint $table) {
            $table->id();
            $table->string('CodeLeaveForm');
            $table->foreignId('IDMemberLeave')->constrained('users')->onDelete('cascade');
            $table->timestamp('TimeLeaveStart');
            $table->timestamp('TimeLeaveEnd');
            $table->text('Reason');
            $table->text('Note')->nullable();
            $table->foreignId('IDMemberReplace')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('IDMemberCreated')->constrained('users')->onDelete('cascade');
            $table->timestamp('DateCreated')->useCurrent();
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
        Schema::dropIfExists('leaveforms');
    }
}

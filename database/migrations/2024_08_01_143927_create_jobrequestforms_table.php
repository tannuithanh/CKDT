<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobrequestformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobrequestforms', function (Blueprint $table) {
            $table->id();
            $table->string('CodeJobRequestForms');
            $table->foreignId('IDDepartmentRequest')->constrained('departments')->onDelete('cascade');
            $table->foreignId('IDDepartmentPerforming')->constrained('departments')->onDelete('cascade');
            $table->text('Content');
            $table->timestamp('TimeFinish');
            $table->text('Note')->nullable();
            $table->timestamp('DateCreate')->useCurrent();
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
        Schema::dropIfExists('jobrequestforms');
    }
}

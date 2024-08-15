<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_members_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('MSNV');
            $table->string('FullName');
            $table->string('Pass');
            $table->string('MailAddress')->nullable();
            $table->string('Division')->nullable();
            $table->text('PositionDetail')->nullable();
            $table->foreignId('IDPosition')->constrained('positions')->onDelete('cascade');
            $table->foreignId('IDDepartment')->constrained('departments')->onDelete('cascade')->nullable();
            $table->string('Avatar')->nullable();
            $table->string('Signature')->nullable();
            $table->boolean('Admin')->default(0);
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
        Schema::dropIfExists('users');
    }
}

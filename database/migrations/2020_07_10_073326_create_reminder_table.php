<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReminderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reminder', function (Blueprint $table) {
            $table->id();
            $table->string('first_nama_tujuan');
            $table->string('last_nama_tujuan');
            $table->string('username_telegram_reminder', 100)->unique();
            $table->string('chat_id_reminder', 100)->unique();
            $table->string('no_hp_tujuan');
            $table->double('nominal');
            $table->string('notifikasi', 10);
            $table->string('status_iuran', 100)->nullable();
            $table->string('pesan_pengingat', 1000);
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
        Schema::dropIfExists('reminder');
    }
}

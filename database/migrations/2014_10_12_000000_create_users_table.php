<?php

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
            $table->string('npk')->unique();
            $table->string('name');
            $table->string('name_last');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('level')->default('user');
            $table->string('jk');
            $table->string('agama');
            $table->string('status_anggota');
            $table->string('username_telegram', 100)->unique()->nullable();
            $table->string('chat_id', 100)->unique()->nullable();
            $table->string('no_hp')->unique();
            $table->double('iuran_kas')->default('0');
            $table->string('status_kas')->nullable();
            $table->double('denda')->default('0');
            $table->rememberToken();
            $table->timestamps();
        });


        /**
         * Create Trigger.
         *
         * 
         */

        DB::unprepared('
        CREATE OR REPLACE FUNCTION iuran_update_kas()
        RETURNS TRIGGER AS 
        $BODY$
        BEGIN
            UPDATE kas_ph SET total_kas_ph = total_kas_ph + NEW.iuran_kas - old.iuran_kas
            WHERE id = 1;
            RETURN NEW;
        END;
        $BODY$ LANGUAGE plpgsql;
        
        CREATE TRIGGER iuran_update
        BEFORE UPDATE ON users
        FOR EACH ROW
        EXECUTE PROCEDURE iuran_update_kas()
        ');
        
        // DB::unprepared(
        //         'CREATE TRIGGER iuran_update BEFORE UPDATE ON users
        //         FOR EACH ROW 
        //         BEGIN
        //             IF (SELECT NEW.iuran_kas FROM users WHERE id = old.id) >= 0 THEN
        //                 UPDATE kas_ph SET kas_ph.total_kas_ph=kas_ph.total_kas_ph+NEW.iuran_kas-old.iuran_kas
        //                 WHERE id = 1;
        //             END IF;
        //         END'); LANGUAGE plpgsql;
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
            // $table->timestamp('email_verified_at')->nullable();

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->timestamps();
        });

        DB::table('contacts')->insert(
            [
                'name' => 'Test1',
                'email' => 'name@domain.com',
                'phone' => '+370 123 45678',
            ],
        );

        DB::table('contacts')->insert(
            [
                'name' => 'Test2',
                'email' => 'name2@domain.com',
                'phone' => '+370 123 45679',
            ],
        );

        DB::table('contacts')->insert(
            [
                'name' => 'Test3',
                'email' => 'name3@domain.com',
                'phone' => '+370 123 45670',
            ],
        );

        DB::table('contacts')->insert(
            [
                'name' => 'Test4',
                'email' => 'name4@domain.com',
                'phone' => '+370 123 45671',
            ],
        );

        DB::table('contacts')->insert(
            [
                'name' => 'Test5',
                'email' => 'name5@domain.com',
                'phone' => '+370 123 45672',
            ],
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}

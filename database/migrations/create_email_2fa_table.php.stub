<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $code_table = config('filament-email-2fa.code_table');

        Schema::create($code_table, function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->morphs('user');
            $table->string('code',12)->index();
            $table->dateTime('expiry_at');
        });




        $verify_table = config('filament-email-2fa.verify_table');

        Schema::create($verify_table, function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->morphs('user');
            $table->string('session_id')->index();
        });
    }
};

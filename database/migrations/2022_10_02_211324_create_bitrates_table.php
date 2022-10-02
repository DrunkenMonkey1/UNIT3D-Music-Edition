<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bitrates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->unique();
            $table->string('slug', 30)->unique();
            $table->string('icon')->default('none');
            $table->integer('num_torrent')->default(0)->unsigned();
            $table->tinyInteger('position')->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bitrates');
    }
};
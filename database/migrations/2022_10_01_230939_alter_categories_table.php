<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('movie_meta');
            $table->dropColumn('tv_meta');
            $table->dropColumn('music_meta');
            $table->dropColumn('no_meta');
            $table->dropColumn('game_meta');

        });
    }

};
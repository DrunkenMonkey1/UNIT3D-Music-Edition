<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('torrents', function (Blueprint $table) {
            $table->dropColumn(
                ['tmdb', 'imdb', 'mal', 'bdinfo', 'mediainfo', 'tvdb', 'season_number', 'episode_number', 'sd', 'region_id', 'resolution_id', 'distributor_id', 'igdb']
            );
        });
    }
};

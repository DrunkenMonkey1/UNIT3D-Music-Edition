<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        // The order in witch we drop the tables is important !

        Schema::drop('recommendations');
        Schema::drop('tv');
        Schema::drop('movie');
        Schema::drop('cast');
        Schema::drop('cast_tv');
        Schema::drop('cast_movie');
        Schema::drop('network_tv');
        Schema::drop('networks');
        Schema::drop('genre_movie');
        Schema::drop('genre_tv');
        Schema::drop('episode_guest_star');
        Schema::drop('episode_person');
        Schema::drop('episodes');
        Schema::drop('cast_episode');
        Schema::drop('crew_episode');
        Schema::drop('crew_movie');
        Schema::drop('crew_tv');
        Schema::drop('crew_season');
        Schema::drop('companies');
        Schema::drop('company_movie');
        Schema::drop('company_tv');
        Schema::drop('distributors');
        Schema::drop('person_movie');
        Schema::drop('person_tv');
        Schema::drop('person_season');
        Schema::drop('regions');
        Schema::drop('resolutions');
        Schema::drop('sessions');
        Schema::drop('subtitles');
        Schema::drop('collection_movie');
    }
};

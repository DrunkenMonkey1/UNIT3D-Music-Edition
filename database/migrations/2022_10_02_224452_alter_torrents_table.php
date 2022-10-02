<?php

declare(strict_types=1);

use App\Models\Bitrate;
use App\Models\Format;
use App\Models\RecordLabel;
use App\Models\ReleaseType;
use App\Models\Source;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('torrents', function (Blueprint $table) {
            $table->integer('discogs_mid')->nullable(); // discogs master id
            $table->string('Catalogue_number')->nullable();
            $table->tinyInteger('is_remastered')->default(0);
            $table->string('remaster_title',)->nullable();
            $table->string('remaster_catalogue_number',)->nullable();
            $table->tinyInteger('multi_disc')->default(0);
            $table->foreignIdFor(Source::class)->constrained();
            $table->foreignIdFor(Format::class)->constrained();
            $table->foreignIdFor(ReleaseType::class)->constrained();
            $table->foreignIdFor(RecordLabel::class)->constrained();
            $table->foreignIdFor(Bitrate::class)->constrained();
        });
    }

    public function down()
    {
        Schema::table('torrents', function (Blueprint $table) {
            //
        });
    }
};
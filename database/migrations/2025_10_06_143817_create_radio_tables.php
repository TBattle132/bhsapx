<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // codeplugs
        Schema::create('codeplugs', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('ws_url')->default('ws://127.0.0.1:5001');
            $t->string('auth_mode')->default('SIMPLE');
            $t->string('simple_key')->nullable();
            $t->string('default_room')->default('Dispatch');
            $t->unsignedTinyInteger('default_volume')->default(70);
            $t->string('default_hotkey')->default('F9');
            $t->timestamps();
        });

        // rooms for each codeplug
        Schema::create('codeplug_rooms', function (Blueprint $t) {
            $t->id();
            $t->foreignId('codeplug_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->unsignedInteger('sort')->default(0);
            $t->timestamps();
        });

        // access IDs (can be many per user/account)
        Schema::create('access_ids', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('access_id')->unique();
            $t->boolean('active')->default(true);
            $t->string('label')->nullable();
            $t->timestamps();
        });

        // which codeplugs an AccessID can use, with permissions
        Schema::create('access_id_codeplug', function (Blueprint $t) {
            $t->id();
            $t->foreignId('access_id_id')->constrained('access_ids')->cascadeOnDelete();
            $t->foreignId('codeplug_id')->constrained()->cascadeOnDelete();
            $t->json('permissions')->nullable(); // e.g. {"rooms":["Dispatch","Ops"],"tx":true}
            $t->timestamps();
            $t->unique(['access_id_id','codeplug_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('access_id_codeplug');
        Schema::dropIfExists('access_ids');
        Schema::dropIfExists('codeplug_rooms');
        Schema::dropIfExists('codeplugs');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('codeplugs')) {
            Schema::create('codeplugs', function (Blueprint $t) {
                $t->id();
                $t->string('name', 191);
                $t->string('ws_url', 191)->default('ws://127.0.0.1:5001');
                $t->string('auth_mode', 32)->default('SIMPLE');
                $t->string('simple_key', 191)->nullable();
                $t->string('default_room', 64)->default('Dispatch');
                $t->unsignedTinyInteger('default_volume')->default(70);
                $t->string('default_hotkey', 16)->default('F9');
                $t->timestamps();
            });
        }

        if (!Schema::hasTable('codeplug_rooms')) {
            Schema::create('codeplug_rooms', function (Blueprint $t) {
                $t->id();
                $t->foreignId('codeplug_id')->constrained()->cascadeOnDelete();
                $t->string('name', 128);
                $t->unsignedInteger('sort')->default(0);
                $t->timestamps();
            });
        }

        if (!Schema::hasTable('access_ids')) {
            Schema::create('access_ids', function (Blueprint $t) {
                $t->id();
                $t->foreignId('user_id')->constrained()->cascadeOnDelete();
                $t->string('access_id', 128)->unique();
                $t->boolean('active')->default(true);
                $t->string('label', 191)->nullable();
                $t->timestamps();
            });
        }

        if (!Schema::hasTable('access_id_codeplug')) {
            Schema::create('access_id_codeplug', function (Blueprint $t) {
                $t->id();
                $t->foreignId('access_id_id')->constrained('access_ids')->cascadeOnDelete();
                $t->foreignId('codeplug_id')->constrained()->cascadeOnDelete();
                $t->json('permissions')->nullable();
                $t->timestamps();
                $t->unique(['access_id_id','codeplug_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('access_id_codeplug');
        Schema::dropIfExists('access_ids');
        Schema::dropIfExists('codeplug_rooms');
        Schema::dropIfExists('codeplugs');
    }
};

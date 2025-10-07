<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('rooms')) {
            Schema::create('rooms', function (Blueprint $table) {
                $table->id();
                $table->foreignId('codeplug_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->string('slug')->unique();
                $table->unsignedInteger('order')->default(0);
                $table->timestamps();
            });
        } else {
            Schema::table('rooms', function (Blueprint $table) {
                if (!Schema::hasColumn('rooms', 'codeplug_id')) {
                    $table->foreignId('codeplug_id')->after('id')->constrained()->cascadeOnDelete();
                }
                if (!Schema::hasColumn('rooms', 'name')) {
                    $table->string('name')->after('codeplug_id');
                }
                if (!Schema::hasColumn('rooms', 'slug')) {
                    $table->string('slug')->unique()->after('name');
                }
                if (!Schema::hasColumn('rooms', 'order')) {
                    $table->unsignedInteger('order')->default(0)->after('slug');
                }
                if (!Schema::hasColumn('rooms', 'created_at')) {
                    $table->timestamps();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('rooms')) {
            Schema::drop('rooms');
        }
    }
};

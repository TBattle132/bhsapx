<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Ensure users table exists first (FK depends on it)
        $usersExists = Schema::hasTable('users');

        // --- codeplugs ---
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
                $t->index('name');
            });
        }

        // --- codeplug_rooms ---
        if (!Schema::hasTable('codeplug_rooms')) {
            Schema::create('codeplug_rooms', function (Blueprint $t) {
                $t->id();
                // create column first; add FK in a second pass
                $t->unsignedBigInteger('codeplug_id');
                $t->string('name', 128);
                $t->unsignedInteger('sort')->default(0);
                $t->timestamps();
                $t->index(['codeplug_id', 'sort']);
            });
        }

        // --- access_ids ---
        if (!Schema::hasTable('access_ids')) {
            Schema::create('access_ids', function (Blueprint $t) use ($usersExists) {
                $t->id();
                // create column first; add FK later if users exists
                $t->unsignedBigInteger('user_id');
                $t->string('access_id', 128)->unique();
                $t->boolean('active')->default(true);
                $t->string('label', 191)->nullable();
                $t->timestamps();
                $t->index('user_id');
            });
        }

        // --- access_id_codeplug ---
        if (!Schema::hasTable('access_id_codeplug')) {
            Schema::create('access_id_codeplug', function (Blueprint $t) {
                $t->id();
                // create columns first; add FKs in a second pass
                $t->unsignedBigInteger('access_id_id');
                $t->unsignedBigInteger('codeplug_id');
                $t->json('permissions')->nullable();
                $t->timestamps();
                $t->unique(['access_id_id','codeplug_id']);
                $t->index(['access_id_id', 'codeplug_id']);
            });
        }

        // Now add foreign keys where possible, guarding against duplicates
        // codeplug_rooms -> codeplugs
        if (Schema::hasTable('codeplug_rooms') && Schema::hasTable('codeplugs')) {
            Schema::table('codeplug_rooms', function (Blueprint $t) {
                // only add if not already present
                $this->addForeignIfMissing($t, 'codeplug_rooms', 'codeplug_id', 'codeplugs', 'id', 'codeplug_rooms_codeplug_id_foreign');
            });
        }

        // access_ids -> users
        if (Schema::hasTable('access_ids') && Schema::hasTable('users')) {
            Schema::table('access_ids', function (Blueprint $t) {
                $this->addForeignIfMissing($t, 'access_ids', 'user_id', 'users', 'id', 'access_ids_user_id_foreign');
            });
        }

        // access_id_codeplug -> access_ids, codeplugs
        if (Schema::hasTable('access_id_codeplug')) {
            if (Schema::hasTable('access_ids')) {
                Schema::table('access_id_codeplug', function (Blueprint $t) {
                    $this->addForeignIfMissing($t, 'access_id_codeplug', 'access_id_id', 'access_ids', 'id', 'access_id_codeplug_access_id_id_foreign');
                });
            }
            if (Schema::hasTable('codeplugs')) {
                Schema::table('access_id_codeplug', function (Blueprint $t) {
                    $this->addForeignIfMissing($t, 'access_id_codeplug', 'codeplug_id', 'codeplugs', 'id', 'access_id_codeplug_codeplug_id_foreign');
                });
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('access_id_codeplug');
        Schema::dropIfExists('access_ids');
        Schema::dropIfExists('codeplug_rooms');
        Schema::dropIfExists('codeplugs');
    }

    /**
     * Add a foreign key if it doesn't already exist.
     */
    private function addForeignIfMissing(Blueprint $t, string $table, string $col, string $refTable, string $refCol, string $constraintName): void
    {
        // Check if constraint exists
        $exists = DB::selectOne("
            SELECT CONSTRAINT_NAME
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = ?
              AND COLUMN_NAME = ?
              AND REFERENCED_TABLE_NAME = ?
              AND REFERENCED_COLUMN_NAME = ?
            LIMIT 1
        ", [$table, $col, $refTable, $refCol]);

        if (!$exists) {
            // Ensure column is unsigned big int and indexed
            $t->unsignedBigInteger($col)->change();
            $t->foreign($col, $constraintName)
              ->references($refCol)->on($refTable)
              ->cascadeOnDelete();
        }
    }
};

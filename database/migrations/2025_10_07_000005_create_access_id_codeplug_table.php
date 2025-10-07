<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('access_id_codeplug')) {
            Schema::create('access_id_codeplug', function (Blueprint $table) {
                $table->id();
                $table->foreignId('access_id')->constrained('access_ids')->cascadeOnDelete();
                $table->foreignId('codeplug_id')->constrained('codeplugs')->cascadeOnDelete();
                $table->boolean('can_tx')->default(false);
                $table->timestamps();

                $table->unique(['access_id', 'codeplug_id']);
            });
        } else {
            Schema::table('access_id_codeplug', function (Blueprint $table) {
                if (!Schema::hasColumn('access_id_codeplug', 'access_id')) {
                    $table->foreignId('access_id')->after('id')->constrained('access_ids')->cascadeOnDelete();
                }
                if (!Schema::hasColumn('access_id_codeplug', 'codeplug_id')) {
                    $table->foreignId('codeplug_id')->after('access_id')->constrained('codeplugs')->cascadeOnDelete();
                }
                if (!Schema::hasColumn('access_id_codeplug', 'can_tx')) {
                    $table->boolean('can_tx')->default(false)->after('codeplug_id');
                }
                if (!Schema::hasColumn('access_id_codeplug', 'created_at')) {
                    $table->timestamps();
                }
                // Unique pair may already exist; if not, Laravel can't easily check
                // for an existing index name here without DB::select on information_schema.
                // If you later see a duplicate error, we can add the unique manually.
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('access_id_codeplug')) {
            Schema::drop('access_id_codeplug');
        }
    }
};

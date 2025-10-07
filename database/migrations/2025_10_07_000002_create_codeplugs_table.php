<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('codeplugs')) {
            Schema::create('codeplugs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('account_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        } else {
            // Table exists: ensure required columns exist
            Schema::table('codeplugs', function (Blueprint $table) {
                if (!Schema::hasColumn('codeplugs', 'account_id')) {
                    $table->foreignId('account_id')->after('id')->constrained()->cascadeOnDelete();
                }
                if (!Schema::hasColumn('codeplugs', 'name')) {
                    $table->string('name')->after('account_id');
                }
                if (!Schema::hasColumn('codeplugs', 'notes')) {
                    $table->text('notes')->nullable()->after('name');
                }
                if (!Schema::hasColumn('codeplugs', 'created_at')) {
                    $table->timestamps();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('codeplugs')) {
            Schema::drop('codeplugs');
        }
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Create accounts table if it doesn't already exist
        if (!Schema::hasTable('accounts')) {
            Schema::create('accounts', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->timestamps();
            });
        }

        // Add users.account_id if missing
        if (!Schema::hasColumn('users', 'account_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('account_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('accounts')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        // Drop the FK if it exists on users
        if (Schema::hasColumn('users', 'account_id')) {
            Schema::table('users', function (Blueprint $table) {
                // dropConstrainedForeignId needs the column name
                $table->dropConstrainedForeignId('account_id');
            });
        }

        // Only drop accounts if it actually exists
        if (Schema::hasTable('accounts')) {
            Schema::drop('accounts');
        }
    }
};

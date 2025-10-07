<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('access_ids')) {
            Schema::create('access_ids', function (Blueprint $table) {
                $table->id();
                $table->foreignId('account_id')->constrained()->cascadeOnDelete();
                $table->string('label')->nullable();
                $table->string('id_value')->unique();
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        } else {
            Schema::table('access_ids', function (Blueprint $table) {
                if (!Schema::hasColumn('access_ids', 'account_id')) {
                    $table->foreignId('account_id')->after('id')->constrained()->cascadeOnDelete();
                }
                if (!Schema::hasColumn('access_ids', 'label')) {
                    $table->string('label')->nullable()->after('account_id');
                }
                if (!Schema::hasColumn('access_ids', 'id_value')) {
                    $table->string('id_value')->unique()->after('label');
                }
                if (!Schema::hasColumn('access_ids', 'active')) {
                    $table->boolean('active')->default(true)->after('id_value');
                }
                if (!Schema::hasColumn('access_ids', 'created_at')) {
                    $table->timestamps();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('access_ids')) {
            Schema::drop('access_ids');
        }
    }
};

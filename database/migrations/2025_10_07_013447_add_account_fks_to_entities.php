<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (Schema::hasTable('codeplugs')) {
            Schema::table('codeplugs', function (Blueprint $t) {
                $t->foreignId('account_id')->after('id')->nullable()->constrained()->nullOnDelete();
            });
        }
        if (Schema::hasTable('access_ids')) {
            Schema::table('access_ids', function (Blueprint $t) {
                $t->foreignId('account_id')->after('id')->nullable()->constrained()->nullOnDelete();
            });
        }
    }
    public function down(): void {
        if (Schema::hasTable('codeplugs')) {
            Schema::table('codeplugs', function (Blueprint $t) { $t->dropConstrainedForeignId('account_id'); });
        }
        if (Schema::hasTable('access_ids')) {
            Schema::table('access_ids', function (Blueprint $t) { $t->dropConstrainedForeignId('account_id'); });
        }
    }
};

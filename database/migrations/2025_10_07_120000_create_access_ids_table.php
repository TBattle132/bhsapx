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
                $table->unsignedBigInteger('account_id');
                $table->unsignedBigInteger('codeplug_id')->nullable();
                $table->string('label', 191);
                $table->string('token', 191)->unique(); // the “Access ID” string
                $table->boolean('tx_allowed')->default(false);
                $table->timestamp('expires_at')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->foreign('account_id')->references('id')->on('accounts')->cascadeOnDelete();
                $table->foreign('codeplug_id')->references('id')->on('codeplugs')->nullOnDelete();
            });
        } else {
            // Ensure required columns exist (safe adds)
            Schema::table('access_ids', function (Blueprint $table) {
                if (!Schema::hasColumn('access_ids', 'account_id'))   $table->unsignedBigInteger('account_id')->after('id');
                if (!Schema::hasColumn('access_ids', 'codeplug_id'))   $table->unsignedBigInteger('codeplug_id')->nullable()->after('account_id');
                if (!Schema::hasColumn('access_ids', 'label'))         $table->string('label', 191)->after('codeplug_id');
                if (!Schema::hasColumn('access_ids', 'token'))         $table->string('token', 191)->unique()->after('label');
                if (!Schema::hasColumn('access_ids', 'tx_allowed'))    $table->boolean('tx_allowed')->default(false)->after('token');
                if (!Schema::hasColumn('access_ids', 'expires_at'))    $table->timestamp('expires_at')->nullable()->after('tx_allowed');
                if (!Schema::hasColumn('access_ids', 'notes'))         $table->text('notes')->nullable()->after('expires_at');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('access_ids');
    }
};

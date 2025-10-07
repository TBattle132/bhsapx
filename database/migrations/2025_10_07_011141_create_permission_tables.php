<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';                     // ensure InnoDB
            $table->id();
            $table->string('name', 125);
            $table->string('guard_name', 125);
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        // roles
        Schema::create('roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('name', 125);
            $table->string('guard_name', 125);
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        // model_has_permissions
        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedBigInteger('permission_id');
            $table->string('model_type', 125);            // shorten!
            $table->unsignedBigInteger('model_id');
            $table->string('guard_name', 125)->nullable(); // if present in your version

            $table->index(['model_id', 'model_type']);    // now fits
            $table->foreign('permission_id')->references('id')->on('permissions')->cascadeOnDelete();
        });

        // model_has_roles
        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedBigInteger('role_id');
            $table->string('model_type', 125);            // shorten!
            $table->unsignedBigInteger('model_id');
            $table->string('guard_name', 125)->nullable(); // if present in your version

            $table->index(['model_id', 'model_type']);
            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();
        });

        // role_has_permissions
        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->primary(['permission_id', 'role_id']);
            $table->foreign('permission_id')->references('id')->on('permissions')->cascadeOnDelete();
            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('model_has_permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
    }
};

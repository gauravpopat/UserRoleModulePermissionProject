<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('module_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('permission_id');
            $table->boolean('list_access')->default(false);
            $table->boolean('show_access')->default(false);
            $table->boolean('create_access')->default(false);
            $table->boolean('update_access')->default(false);
            $table->boolean('delete_access')->default(false);
            $table->timestamps();

            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_permissions');
    }
};

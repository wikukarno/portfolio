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
        Schema::create('project_tech_stacks', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('project_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('tech_stack_id')->constrained()->onDelete('cascade');

            $table->unique(['project_id', 'tech_stack_id']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_tech_stacks');
    }
};

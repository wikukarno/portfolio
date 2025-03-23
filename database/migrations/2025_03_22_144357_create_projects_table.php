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
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('category_project_id')->nullable()->constrained('category_projects')->onDelete('set null');

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('short_summary');
            $table->text('description');

            $table->string('repository_url')->nullable();
            $table->string('live_url')->nullable();

            $table->boolean('is_featured')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

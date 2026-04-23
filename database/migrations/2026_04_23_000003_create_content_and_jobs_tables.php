<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->json('seo_meta')->nullable();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('vacancies', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('organization');
            $table->string('location')->nullable();
            $table->date('application_deadline')->nullable()->index();
            $table->string('source_url')->nullable();
            $table->enum('type', ['government', 'private'])->default('government')->index();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('government_orders', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('department')->nullable();
            $table->date('issued_on')->index();
            $table->string('document_path');
            $table->text('summary')->nullable();
            $table->timestamps();
        });

        Schema::create('educational_resources', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('class_level', 50)->index();
            $table->string('subject', 100)->index();
            $table->string('board', 100)->index();
            $table->enum('resource_type', ['note', 'pdf', 'video'])->index();
            $table->string('resource_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educational_resources');
        Schema::dropIfExists('government_orders');
        Schema::dropIfExists('vacancies');
        Schema::dropIfExists('blog_posts');
    }
};

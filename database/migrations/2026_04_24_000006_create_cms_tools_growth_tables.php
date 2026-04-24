<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ✅ UPDATED: WordPress-like CMS taxonomy + Tools marketplace + AI/design telemetry.
        Schema::table('blog_categories', function (Blueprint $table): void {
            $table->foreignId('parent_id')->nullable()->after('id')->constrained('blog_categories')->nullOnDelete();
            $table->boolean('is_active')->default(true)->after('description')->index();
        });

        Schema::create('tags', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 80);
            $table->string('slug', 120)->unique();
            $table->timestamps();
        });

        Schema::create('blog_post_tag', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('blog_post_id')->constrained('blog_posts')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['blog_post_id', 'tag_id']);
        });

        Schema::table('blog_posts', function (Blueprint $table): void {
            $table->string('featured_image_path')->nullable()->after('title');
            $table->boolean('is_featured')->default(false)->after('seo_meta')->index();
            $table->json('schema_meta')->nullable()->after('seo_meta');
        });

        Schema::create('tools', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 120);
            $table->string('slug', 140)->unique();
            $table->enum('tool_type', ['pdf', 'image', 'itr', 'social_creator'])->index();
            $table->json('settings')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('tool_usages', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('tool_id')->constrained()->cascadeOnDelete();
            $table->json('input_meta')->nullable();
            $table->json('output_meta')->nullable();
            $table->unsignedInteger('credits_used')->default(1);
            $table->timestamps();
            $table->index(['tool_id', 'created_at']);
        });

        Schema::create('designs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('category', 80)->index();
            $table->string('image_path')->nullable();
            $table->text('caption')->nullable();
            $table->text('quote')->nullable();
            $table->string('hashtags', 500)->nullable();
            $table->string('rendered_path')->nullable();
            $table->timestamps();
        });

        Schema::create('ai_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('context', 100)->index();
            $table->text('prompt');
            $table->longText('response')->nullable();
            $table->unsignedInteger('tokens_used')->default(0);
            $table->timestamps();
            $table->index(['context', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_logs');
        Schema::dropIfExists('designs');
        Schema::dropIfExists('tool_usages');
        Schema::dropIfExists('tools');

        Schema::table('blog_posts', function (Blueprint $table): void {
            $table->dropColumn(['featured_image_path', 'is_featured', 'schema_meta']);
        });

        Schema::dropIfExists('blog_post_tag');
        Schema::dropIfExists('tags');

        Schema::table('blog_categories', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('parent_id');
            $table->dropColumn('is_active');
        });
    }
};

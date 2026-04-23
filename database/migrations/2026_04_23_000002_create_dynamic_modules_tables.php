<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_enabled')->default(true)->index();
            $table->boolean('ai_enabled')->default(false);
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        Schema::create('module_fields', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('module_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->string('name');
            $table->string('field_type', 30);
            $table->json('validation_rules')->nullable();
            $table->json('options')->nullable();
            $table->boolean('is_required')->default(false);
            $table->unsignedInteger('sort_order')->default(1);
            $table->timestamps();

            $table->unique(['module_id', 'name']);
        });

        Schema::create('module_records', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('module_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->json('data');
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_records');
        Schema::dropIfExists('module_fields');
        Schema::dropIfExists('modules');
    }
};

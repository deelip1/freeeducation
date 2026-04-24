<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ✅ HIGHLIGHT: Altering the existing 'users' table created by Laravel's default migration.
        Schema::table('users', function (Blueprint $table): void {
            $table->string('locale', 5)->default('en')->after('password');
            $table->boolean('is_approved')->default(false)->index()->after('locale');
            $table->enum('role', ['admin', 'moderator', 'educator', 'student', 'user'])->default('user')->index()->after('is_approved');
            $table->enum('subscription_tier', ['free', 'premium', 'agency'])->default('free')->index()->after('role');
        });

        // Profiles table remains unchanged as it is a new table.
        Schema::create('profiles', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('phone', 20)->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar_path')->nullable();
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');

        // ✅ HIGHLIGHT: Safely rolling back only the custom SaaS columns.
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->dropColumn(['locale', 'is_approved', 'role', 'subscription_tier']);
            });
        }
    }
};
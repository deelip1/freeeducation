<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ✅ UPDATED: full ITR workflow schema with encrypted-sensitive fields + approvals.
        Schema::create('itr_profiles', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('pan', 10)->index();
            $table->string('aadhaar_encrypted')->nullable();
            $table->date('dob');
            $table->enum('residential_status', ['resident', 'nri'])->default('resident')->index();
            $table->enum('employment_type', ['salaried', 'business', 'professional', 'other'])->default('salaried')->index();
            $table->boolean('aadhaar_linked')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'pan']);
        });

        Schema::create('tax_rules', function (Blueprint $table): void {
            $table->id();
            $table->string('assessment_year', 20)->index();
            $table->enum('regime', ['old', 'new'])->index();
            $table->json('slabs');
            $table->decimal('standard_deduction', 12, 2)->default(0);
            $table->decimal('rebate_threshold', 12, 2)->default(0);
            $table->decimal('rebate_amount', 12, 2)->default(0);
            $table->decimal('cess_percent', 5, 2)->default(4.00);
            $table->boolean('is_active')->default(false)->index();
            $table->timestamps();

            $table->unique(['assessment_year', 'regime']);
        });

        Schema::create('itr_filings', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('itr_profile_id')->constrained()->cascadeOnDelete();
            $table->string('assessment_year', 20)->index();
            $table->json('income_payload');
            $table->json('deduction_payload')->nullable();
            $table->json('tax_credit_payload')->nullable();
            $table->json('computation_result')->nullable();
            $table->enum('itr_form', ['ITR-1', 'ITR-2', 'ITR-3', 'ITR-4'])->nullable();
            $table->enum('recommended_regime', ['old', 'new'])->nullable();
            $table->enum('approval_status', ['draft', 'pending', 'approved', 'rejected'])->default('draft')->index();
            $table->timestamp('submitted_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('itr_filings');
        Schema::dropIfExists('tax_rules');
        Schema::dropIfExists('itr_profiles');
    }
};

<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\NewsAnnouncement;
use App\Models\Tax\TaxRule;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->firstOrCreate(
            ['email' => 'admin@free-education.fun'],
            ['name' => 'Platform Admin', 'password' => 'Password@123', 'is_approved' => true]
        );

        $categories = collect(['Exams', 'Scholarships', 'Technology', 'Government Orders'])
            ->map(fn (string $name) => BlogCategory::query()->firstOrCreate([
                'slug' => Str::slug($name),
            ], [
                'name' => $name,
                'description' => $name . ' updates',
            ]));

        foreach ($categories as $category) {
            BlogPost::query()->firstOrCreate([
                'slug' => $category->slug . '-intro',
            ], [
                'author_id' => $author->id,
                'category_id' => $category->id,
                'title' => $category->name . ' Starter Guide',
                'excerpt' => 'Demo seeded content for UI and routing validation.',
                'content' => 'Structured demo content with headings, bullet points and educational context.',
                'approval_status' => 'approved',
                'published_at' => now(),
            ]);
        }

        NewsAnnouncement::query()->firstOrCreate([
            'slug' => 'platform-launch-announcement',
        ], [
            'title' => 'Platform Launch Announcement',
            'content' => 'Welcome to free-education.fun beta release with AI features.',
            'announcement_type' => 'announcement',
            'effective_from' => now(),
            'is_published' => true,
        ]);

        $this->seedItrRules();
    }

    private function seedItrRules(): void
    {
        TaxRule::query()->updateOrCreate([
            'assessment_year' => '2026-27',
            'regime' => 'old',
        ], [
            'slabs' => [
                ['from' => 0, 'to' => 250000, 'rate' => 0],
                ['from' => 250000, 'to' => 500000, 'rate' => 5],
                ['from' => 500000, 'to' => 1000000, 'rate' => 20],
                ['from' => 1000000, 'to' => null, 'rate' => 30],
            ],
            'standard_deduction' => 50000,
            'rebate_threshold' => 500000,
            'rebate_amount' => 12500,
            'cess_percent' => 4,
            'is_active' => true,
        ]);

        TaxRule::query()->updateOrCreate([
            'assessment_year' => '2026-27',
            'regime' => 'new',
        ], [
            'slabs' => [
                ['from' => 0, 'to' => 300000, 'rate' => 0],
                ['from' => 300000, 'to' => 700000, 'rate' => 5],
                ['from' => 700000, 'to' => 1000000, 'rate' => 10],
                ['from' => 1000000, 'to' => 1200000, 'rate' => 15],
                ['from' => 1200000, 'to' => 1500000, 'rate' => 20],
                ['from' => 1500000, 'to' => null, 'rate' => 30],
            ],
            'standard_deduction' => 75000,
            'rebate_threshold' => 700000,
            'rebate_amount' => 25000,
            'cess_percent' => 4,
            'is_active' => true,
        ]);
    }
}

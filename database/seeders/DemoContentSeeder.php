<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\NewsAnnouncement;
use App\Models\Tag;
use App\Models\Tax\TaxRule;
use App\Models\Tools\Tool;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->firstOrCreate(
            ['email' => 'admin@free-education.fun'],
            [
                'name' => 'Platform Admin',
                'password' => Hash::make((string) env('DEMO_ADMIN_PASSWORD', 'ChangeMe@1234')),
                'is_approved' => true,
            ]
        );

        $parent = BlogCategory::query()->firstOrCreate(['slug' => 'education'], [
            'name' => 'Education',
            'description' => 'Main education hub',
            'is_active' => true,
        ]);

        $categories = collect(['Exams', 'Scholarships', 'Technology', 'Government Orders'])
            ->map(fn (string $name) => BlogCategory::query()->firstOrCreate([
                'slug' => Str::slug($name),
            ], [
                'parent_id' => $parent->id,
                'name' => $name,
                'description' => $name . ' updates',
                'is_active' => true,
            ]));

        foreach ($categories as $category) {
            $post = BlogPost::query()->firstOrCreate([
                'slug' => $category->slug . '-intro',
            ], [
                'author_id' => $author->id,
                'category_id' => $category->id,
                'title' => $category->name . ' Starter Guide',
                'excerpt' => 'Demo seeded content for UI and routing validation.',
                'content' => 'Structured demo content with headings, bullet points and educational context.',
                'approval_status' => 'approved',
                'is_featured' => true,
                'published_at' => now(),
            ]);

            $tag = Tag::query()->firstOrCreate(['slug' => Str::slug($category->name)], ['name' => $category->name]);
            $post->tags()->syncWithoutDetaching([$tag->id]);
        }

        Tool::query()->firstOrCreate(['slug' => 'pdf-compressor'], [
            'name' => 'PDF Compressor',
            'tool_type' => 'pdf',
            'settings' => ['driver' => config('freeeducation.tools.pdf_compressor_driver', 'ghostscript')],
            'is_active' => true,
        ]);

        Tool::query()->firstOrCreate(['slug' => 'social-media-creator'], [
            'name' => 'Social Media Creator',
            'tool_type' => 'social_creator',
            'settings' => ['templates' => ['birthday', 'festival', 'motivation', 'cyber-awareness']],
            'is_active' => true,
        ]);

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

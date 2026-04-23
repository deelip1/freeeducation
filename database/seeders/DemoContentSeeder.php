<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\NewsAnnouncement;
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
    }
}

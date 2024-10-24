<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'title' => 'Muaz Munir',
            'meta_title' => 'Muaz Munir',
            'meta_description' => "Transform your online presence with our top-notch web services. From web development to SEO and digital marketing, we've got you covered. Boost your business today!",
            'meta_keywords' => 'Web development, Website design, E-commerce solutions, SEO optimization, Digital marketing, Responsive web design, Content management systems (CMS), Web hosting, Mobile app development, Social media marketing, Search engine marketing (SEM), User experience (UX) design,  Website maintenance, Online branding, Conversion rate optimization (CRO)',
            'facebook' => 'https://www.facebook.com/',
            'twitter' => 'https://twitter.com/',
            'linkedin' => 'https://www.linkedin.com/',
            'instagram' => 'https://www.instagram.com/',
            'github' => 'https://github.com/',
            'phone' => '+92 345 456 7890',
            'email' => 'admin@admin.com',
            'fax' => '0900 78601',
            'address' => 'Lahore, Punjab, Pakistan',
            'language' => 'English',
            'copyright_text' => 'All rights reserved',
        ]);
    }
}

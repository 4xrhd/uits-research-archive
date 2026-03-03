<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Domain;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Departments
        $departments = [
            'Computer Science & Engineering',
            'Electrical & Electronic Engineering',
            'Business Administration',
            'English',
            'Law',
            'Civil Engineering',
            'Architecture',
            'Electronics and Communication Engineering',
            'Pharmacy',
            'Public Health',
            'Environmental Science',
            'Mathematics',
            'Physics',
            'Chemistry',
            'Biotechnology'
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['name' => $dept]);
        }

        // Create Research Domains
        $domains = [
            'Artificial Intelligence',
            'Machine Learning',
            'Data Science',
            'Cybersecurity',
            'Internet of Things',
            'Cloud Computing',
            'Blockchain',
            'Software Engineering',
            'Web Development',
            'Mobile Development',
            'Network Engineering',
            'Database Systems',
            'Human-Computer Interaction',
            'Computer Vision',
            'Natural Language Processing',
            'Robotics',
            'Renewable Energy',
            'Sustainable Development',
            'Public Health',
            'Environmental Science',
            'Biotechnology',
            'Pharmaceutical Sciences',
            'Civil Engineering',
            'Architecture',
            'Business Administration',
            'Law',
            'English Literature'
        ];

        foreach ($domains as $domain) {
            Domain::firstOrCreate(['name' => $domain]);
        }

        // Create Sample Admin User
        User::firstOrCreate(
            ['email' => 'admin@uits.edu.bd'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create Sample Student User
        User::firstOrCreate(
            ['email' => 'student@uits.edu.bd'],
            [
                'name' => 'Student User',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );

        // Create Sample Faculty User
        User::firstOrCreate(
            ['email' => 'faculty@uits.edu.bd'],
            [
                'name' => 'Faculty User',
                'password' => Hash::make('password'),
                'role' => 'faculty',
            ]
        );

        $this->command->info('Database seeded successfully!');
        $this->command->info('');
        $this->command->info('Sample login credentials:');
        $this->command->info('Admin: admin@uits.edu / password');
        $this->command->info('Student: student@uits.edu / password');
        $this->command->info('Faculty: faculty@uits.edu / password');
    }
}

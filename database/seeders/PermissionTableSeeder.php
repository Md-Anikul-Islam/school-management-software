<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            //For roll and permission
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            //For Role and permission
            'role-and-permission-list',

            //For User
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',

            //Dashboard
            'card-list',


            //For Slider
            'slider-list',
            'slider-create',
            'slider-edit',
            'slider-delete',


            //student
            'student-list',
            'student-show',
            'student-create',
            'student-edit',
            'student-delete',

            //teacher
            'teacher-list',
            'teacher-show',
            'teacher-create',
            'teacher-edit',
            'teacher-delete',

            //academics
            'academics-module',

            //class
            'class-list',
            'class-create',
            'class-edit',
            'class-delete',

            //section
            'section-list',
            'section-create',
            'section-edit',
            'section-delete',

            //subject
            'subject-list',
            'subject-create',
            'subject-edit',
            'subject-delete',

            //syllabus
            'syllabus-list',
            'syllabus-download',
            'syllabus-create',
            'syllabus-edit',
            'syllabus-delete',

            //assignment
            'assignment-list',
            'assignment-show',
            'assignment-create',
            'assignment-edit',
            'assignment-delete',
            'assignment-download',
        ];
        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }
    }
}

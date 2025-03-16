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

            //exam module
            'exam-module',

            //exam
            'exam-list',
            'exam-create',
            'exam-edit',
            'exam-delete',

            //exam schedule
            'exam-schedule-list',
            'exam-schedule-create',
            'exam-schedule-edit',
            'exam-schedule-delete',

            //grade
            'grade-list',
            'grade-create',
            'grade-edit',
            'grade-delete',

            //guardian
            'guardian-list',
            'guardian-show',
            'guardian-create',
            'guardian-edit',
            'guardian-delete',

            //inventory-module
            'inventory-module',

            //category
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',

            //product
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',

            //warehouse
            'warehouse-list',
            'warehouse-create',
            'warehouse-edit',
            'warehouse-delete',

            //supplier
            'supplier-list',
            'supplier-create',
            'supplier-edit',
            'supplier-delete',

            //hostel-module
            'hostel-module',

            //hostel
            'hostel-list',
            'hostel-create',
            'hostel-edit',
            'hostel-delete',

            //hostel category
            'hostel-category-list',
            'hostel-category-create',
            'hostel-category-edit',
            'hostel-category-delete',

            //hostel room
            'hostel-room-list',
            'hostel-room-show',
            'hostel-room-create',
            'hostel-room-edit',
            'hostel-room-delete',
            'hostel-room-assign',

            //hostel member
            'hostel-member-list',
            'hostel-member-show',
            'hostel-member-create',
            'hostel-member-edit',

            //online exam
            'online-exam-module',

            //question group
            'question-group-list',
            'question-group-create',
            'question-group-edit',
            'question-group-delete',

            //question level
            'question-level-list',
            'question-level-create',
            'question-level-edit',
            'question-level-delete',

            //question bank
            'question-bank-list',
            'question-bank-show',
            'question-bank-create',
            'question-bank-edit',
            'question-bank-delete',

            //instruction
            'instruction-list',
            'instruction-show',
            'instruction-create',
            'instruction-edit',
            'instruction-delete',



            //mark module
            'mark-module',

            //mark
            'mark-list',
            'mark-create',
            'mark-edit',
            'mark-delete',

            //mark distribution & promotion
            'mark-distribution-list',
            'mark-promotion',

            //asset_management-module
            'asset-management-module',

            //vendor
            'vendor-list',
            'vendor-create',
            'vendor-edit',
            'vendor-delete',

            //location
            'location-list',
            'location-create',
            'location-edit',
            'location-delete',

        ];
        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }
    }
}

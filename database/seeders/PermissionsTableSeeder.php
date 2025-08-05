<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'category_management_create',
            ],
            [
                'id'    => 18,
                'title' => 'category_management_edit',
            ],
            [
                'id'    => 19,
                'title' => 'category_management_show',
            ],
            [
                'id'    => 20,
                'title' => 'category_management_delete',
            ],
            [
                'id'    => 21,
                'title' => 'category_management_access',
            ],
            [
                'id'    => 22,
                'title' => 'manage_examination_access',
            ],
            [
                'id'    => 23,
                'title' => 'course_create',
            ],
            [
                'id'    => 24,
                'title' => 'course_edit',
            ],
            [
                'id'    => 25,
                'title' => 'course_show',
            ],
            [
                'id'    => 26,
                'title' => 'course_delete',
            ],
            [
                'id'    => 27,
                'title' => 'course_access',
            ],
            [
                'id'    => 28,
                'title' => 'exam_pattern_create',
            ],
            [
                'id'    => 29,
                'title' => 'exam_pattern_edit',
            ],
            [
                'id'    => 30,
                'title' => 'exam_pattern_show',
            ],
            [
                'id'    => 31,
                'title' => 'exam_pattern_delete',
            ],
            [
                'id'    => 32,
                'title' => 'exam_pattern_access',
            ],
            [
                'id'    => 33,
                'title' => 'exam_management_create',
            ],
            [
                'id'    => 34,
                'title' => 'exam_management_edit',
            ],
            [
                'id'    => 35,
                'title' => 'exam_management_show',
            ],
            [
                'id'    => 36,
                'title' => 'exam_management_delete',
            ],
            [
                'id'    => 37,
                'title' => 'exam_management_access',
            ],
            [
                'id'    => 38,
                'title' => 'question_management_create',
            ],
            [
                'id'    => 39,
                'title' => 'question_management_edit',
            ],
            [
                'id'    => 40,
                'title' => 'question_management_show',
            ],
            [
                'id'    => 41,
                'title' => 'question_management_delete',
            ],
            [
                'id'    => 42,
                'title' => 'question_management_access',
            ],
            [
                'id'    => 43,
                'title' => 'student_create',
            ],
            [
                'id'    => 44,
                'title' => 'student_edit',
            ],
            [
                'id'    => 45,
                'title' => 'student_show',
            ],
            [
                'id'    => 46,
                'title' => 'student_delete',
            ],
            [
                'id'    => 47,
                'title' => 'student_access',
            ],
            [
                'id'    => 48,
                'title' => 'result_management_create',
            ],
            [
                'id'    => 49,
                'title' => 'result_management_edit',
            ],
            [
                'id'    => 50,
                'title' => 'result_management_show',
            ],
            [
                'id'    => 51,
                'title' => 'result_management_delete',
            ],
            [
                'id'    => 52,
                'title' => 'result_management_access',
            ],
            [
                'id'    => 53,
                'title' => 'setting_create',
            ],
            [
                'id'    => 54,
                'title' => 'setting_edit',
            ],
            [
                'id'    => 55,
                'title' => 'setting_show',
            ],
            [
                'id'    => 56,
                'title' => 'setting_delete',
            ],
            [
                'id'    => 57,
                'title' => 'setting_access',
            ],
            [
                'id'    => 58,
                'title' => 'seo_management_access',
            ],
            [
                'id'    => 59,
                'title' => 'seo_create',
            ],
            [
                'id'    => 60,
                'title' => 'seo_edit',
            ],
            [
                'id'    => 61,
                'title' => 'seo_show',
            ],
            [
                'id'    => 62,
                'title' => 'seo_delete',
            ],
            [
                'id'    => 63,
                'title' => 'seo_access',
            ],
            [
                'id'    => 64,
                'title' => 'head_script_create',
            ],
            [
                'id'    => 65,
                'title' => 'head_script_edit',
            ],
            [
                'id'    => 66,
                'title' => 'head_script_show',
            ],
            [
                'id'    => 67,
                'title' => 'head_script_delete',
            ],
            [
                'id'    => 68,
                'title' => 'head_script_access',
            ],
            [
                'id'    => 69,
                'title' => 'body_script_create',
            ],
            [
                'id'    => 70,
                'title' => 'body_script_edit',
            ],
            [
                'id'    => 71,
                'title' => 'body_script_show',
            ],
            [
                'id'    => 72,
                'title' => 'body_script_delete',
            ],
            [
                'id'    => 73,
                'title' => 'body_script_access',
            ],
            [
                'id'    => 74,
                'title' => 'home_content_create',
            ],
            [
                'id'    => 75,
                'title' => 'home_content_edit',
            ],
            [
                'id'    => 76,
                'title' => 'home_content_show',
            ],
            [
                'id'    => 77,
                'title' => 'home_content_delete',
            ],
            [
                'id'    => 78,
                'title' => 'home_content_access',
            ],
            [
                'id'    => 79,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}

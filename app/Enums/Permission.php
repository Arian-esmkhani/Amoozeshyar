<?php

namespace App\Enums;

// تعریف یک enum برای مجوزها
enum Permission: string
{
    // مجوز مشاهده کاربران
    case VIEW_USERS = 'view_users';

    // مجوز ایجاد کاربران جدید
    case CREATE_USERS = 'create_users';

    // مجوز ویرایش اطلاعات کاربران
    case EDIT_USERS = 'edit_users';

    // مجوز حذف کاربران
    case DELETE_USERS = 'delete_users';

    // مجوز مشاهده دوره‌ها
    case VIEW_TERMS = 'view_terms';

    // مجوز ایجاد دوره‌ها
    case CREATE_TERMS = 'create_terms';

    // مجوز ویرایش دوره‌ها
    case EDIT_TERMS = 'edit_terms';

    // مجوز حذف دوره‌ها
    case DELETE_TERMS = 'delete_terms';

    // مجوز مشاهده کلاس‌ها
    case VIEW_COURSES = 'view_courses';

    // مجوز ایجاد کلاس‌ها
    case CREATE_COURSES = 'create_courses';

    // مجوز ویرایش کلاس‌ها
    case EDIT_COURSES = 'edit_courses';

    // مجوز حذف کلاس‌ها
    case DELETE_COURSES = 'delete_courses';

    // مجوز مشاهده اطلاعات دانش‌آموزان
    case VIEW_STUDENTS = 'view_students';

    // مجوز ثبت دانش‌آموز جدید
    case CREATE_STUDENTS = 'create_students';

    // مجوز ویرایش اطلاعات دانش‌آموزان
    case EDIT_STUDENTS = 'edit_students';

    // مجوز حذف دانش‌آموزان
    case DELETE_STUDENTS = 'delete_students';

    // مجوز مشاهده اطلاعات معلمان
    case VIEW_TEACHERS = 'view_teachers';

    // مجوز ثبت معلم جدید
    case CREATE_TEACHERS = 'create_teachers';

    // مجوز ویرایش اطلاعات معلمان
    case EDIT_TEACHERS = 'edit_teachers';

    // مجوز حذف معلمان
    case DELETE_TEACHERS = 'delete_teachers';
}

<?php

namespace App\Enums;

enum Permission: string
{
    case VIEW_USERS = 'view_users';
    case CREATE_USERS = 'create_users';
    case EDIT_USERS = 'edit_users';
    case DELETE_USERS = 'delete_users';

    case VIEW_TERMS = 'view_terms';
    case CREATE_TERMS = 'create_terms';
    case EDIT_TERMS = 'edit_terms';
    case DELETE_TERMS = 'delete_terms';

    case VIEW_COURSES = 'view_courses';
    case CREATE_COURSES = 'create_courses';
    case EDIT_COURSES = 'edit_courses';
    case DELETE_COURSES = 'delete_courses';

    case VIEW_STUDENTS = 'view_students';
    case CREATE_STUDENTS = 'create_students';
    case EDIT_STUDENTS = 'edit_students';
    case DELETE_STUDENTS = 'delete_students';

    case VIEW_TEACHERS = 'view_teachers';
    case CREATE_TEACHERS = 'create_teachers';
    case EDIT_TEACHERS = 'edit_teachers';
    case DELETE_TEACHERS = 'delete_teachers';
}

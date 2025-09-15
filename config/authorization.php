<?php


return [
    'permissions'=>[
        // 'home'                          =>'Show Dashboard',
        // 'categories'                    =>'Managment Categories',
        'show_categories'               =>'Show All Categories',
        'create_category'               =>'Create Category',
        'edit_category'                 =>'Edit Category',
        // 'update_category'               =>'Update Category',
        'delete_category'               =>'Delete Category',
        'change_status_category'        =>'Change Status For Category',

        // 'posts'                         =>'Managment Posts',
        'show_posts'                    =>'Show All Posts',
        'create_post'                   =>'Create Post',
        'edit_post'                     =>'Edit Post',
        // 'update_post'                   =>'update Post',
        'delete_post'                   =>'Delete Post',
        'change_status_post'            =>'Change Status For Post',
        'show_post'                     =>'show Single Post',

        // 'users'                         =>'Managment Users',
        'show_users'                    =>'Show All Users',
        'create_user'                   =>'Create User',
        'delete_user'                   =>'Delete User',
        'change_status_user'            =>'Change Status For User',
        'show_user'                     =>'show Single User',

        // 'admins'                        =>'Managment Admins',
        'show_admins'                   =>'Show All Admins',
        'create_admin'                  =>'Create Admin',
        'delete_admin'                  =>'Delete Admin',
        'edit_admin'                    =>'Edit Admin',
        'change_status_admin'           =>'Change Status For Admin',
        // 'show_admin'                    =>'show Single Admin',

        // 'authorizations'                =>'Managment Authorizations',
        'show_roles'                    =>'Show All Roles',
        'create_role'                   =>'Create Role',
        'delete_role'                   =>'Delete Role',
        'edit_role'                     =>'Edit Role',
        // 'update_role'                   =>'Update Role',

        // 'settings'                      =>'Managment Settings',
        'show_settings'                 =>'Show All Settings',
        'show_rellated_sites'           =>'Show All Related Sites',
        'update_settings'               =>'Update Settings',
        'create_rellated_site'          =>'Create Rellated Site',
        'delete_rellated_site'          =>'Delete Rellated Site',
        'edit_rellated_site'            =>'Edit   Rellated Site',
        // 'update_rellated_site'          =>'Update Rellated Site',

        // 'contacts'                      =>'Managment Contacts',
        'show_contacts'                 =>'Show All Contacts',
        'show_contact'                  =>'show Single Contact',
        'replay_contact'                =>'Replay On Contact',
        'delete_contact'                =>'Delete  Contact',

        // 'notifications'                 =>'Managment notifications',
        'show_notifications'            =>'Show All Notifications',
        'delete_single_notification'    =>'Delete Silgle Notification',
        'delete_all_notification'       =>'Delete All Notification',
        'show_notifications_icon'       =>'Show  Notifications Icon',
    ],


    // 👇 هنا dependencies الكاملة
    'dependencies' => [
        // Categories
        'create_category'        => ['show_categories'],
        'edit_category'          => ['show_categories'],
        'delete_category'        => ['show_categories'],
        'change_status_category' => ['show_categories'],

        // Posts
        'create_post'            => ['show_posts'],
        'edit_post'              => ['show_posts'],
        'delete_post'            => ['show_posts'],
        'change_status_post'     => ['show_posts'],
        'show_post'              => ['show_posts'], // عشان يقدر يفتح بوست لازم يكون شايفهم

        // Users
        'create_user'            => ['show_users'],
        'delete_user'            => ['show_users'],
        'change_status_user'     => ['show_users'],
        'show_user'              => ['show_users'],

        // Admins
        'create_admin'          => ['show_admins'],
        'delete_admin'          => ['show_admins'],
        'change_status_admin'   => ['show_admins'],
        'edit_admin'             => ['show_admins'],

        // Roles
        'create_role'            => ['show_roles'],
        'delete_role'            => ['show_roles'],
        'edit_role'              => ['show_roles'],

        // Settings
        'update_settings'        => ['show_settings'],
        'create_rellated_site'   => ['show_rellated_sites'],
        'delete_rellated_site'   => ['show_rellated_sites'],
        'edit_rellated_site'     => ['show_rellated_sites'],

        // Contacts
        'show_contact'           => ['show_contacts'],
        'replay_contact'         => ['show_contacts'],
        'delete_contact'         => ['show_contacts'],

        // Notifications
        'delete_single_notification' => ['show_notifications'],
        'delete_all_notification'    => ['show_notifications'],
        'show_notifications_icon'    => ['show_notifications'],
    ]
];



<?php
/*
 * Menus with [$route, $label, $permission]
 * $route can be an array with [$routeName, $parameters]
 * $parameters can be a callback if needed (for auth() usage for example)
 * $label can be an array with [$label, $fontAwesomeClass]
 * $permission can be null : the entry will always be shown
 */

$auth_id = function () {
    return auth()->id();
};

return [
    'sidebar-menu'  => [
        [['admin.users.show', $auth_id], ['Mon compte', 'user']],
    ],
    'sidebar-admin' => [
        ['admin.users.index', ['Utilisateurs', 'users'], 'manage-users'],
        ['admin.roles.index', ['Roles et Permissions', 'wrench'], 'manage-roles'],
    ],

];

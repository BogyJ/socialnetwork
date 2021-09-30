<?php
    return [
        \App\Core\Route::get('|^user/register/?$|', 'Main', 'getRegister'),
        \App\Core\Route::post('|^user/register/?$|', 'Main', 'postRegister'),

        \App\Core\Route::get('|^user/login/?$|', 'Main', 'getLogin'),
        \App\Core\Route::post('|^user/login/?$|', 'Main', 'postLogin'),
        \App\Core\Route::get('|^user/logout/?$|', 'Main', 'getLogout'),

        \App\Core\Route::get('|^user/profile/?$|', 'UserProfile', 'index'),

        \App\Core\Route::get('|^user/friend/([0-9]+)/?$|', 'UserProfile', 'getSendRequest'),

        \App\Core\Route::get('|^user/notification/?$|', 'UserProfile', 'getNotification'),

        \App\Core\Route::get('|^user/accept/([0-9]+)/?$|', 'UserProfile', 'getAcceptFriendRequest'),

        /*\App\Core\Route::get('|^user/survey/show/?$|', 'Form', 'getForm'),
        \App\Core\Route::get('|^user/survey/show/all/?$|', 'Form', 'showForms'),
        \App\Core\Route::get('|^user/survey/show/([0-9]+)/?$|', 'Form', 'showFormData'),
        \App\Core\Route::get('|^user/survey/share/([a-zA-Z0-9]{32})/?$|', 'Form', 'getSharedForm'),
        \App\Core\Route::get('|^user/survey/delete/([0-9]+)/?$|', 'Form', 'deleteForm'),
        \App\Core\Route::post('|^user/survey/response/([a-zA-Z0-9]{32})/?$|', 'Form', 'response'),
        \App\Core\Route::post('|^user/survey/create/?$|', 'Form', 'postForm'),*/

        \App\Core\Route::any('|^.*/?$|', 'Main', 'home')
    ];

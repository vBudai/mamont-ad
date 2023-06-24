<?php

//[a-z]{1,}=[\da-z]{1,}
//[a-z]{1,}[\/?]

return [

    /**
     * Страница по умолчанию
     */

    [
        'route' => '/',
        'controller' => 'AdsController',
        'action' => 'ads'
    ],


    /**
     * Страницы с объявлениями
     */

    [
        'route' => '/ads',
        'controller' => 'AdsController',
        'action' => 'ads'
    ],

    [
        'route' => '/ads/search',
        'controller' => 'AdsController',
        'action' => 'searchAds'
    ],

    [
        'route' => '/ads/?(?<main_category>[a-zA-Z\'_]{1,})',
        'controller' => 'AdsController',
        'action' => 'ads'
    ],



    [
        'route' => '/ad/(?<id>[0-9]{1,})',
        'controller' => 'AdController',
        'action' => 'ad'
    ],


    /**
     * Создание и редактирование объявления
     */

    [
        'route' => '/create_ad',
        'controller' => 'CreateAdController',
        'action' => 'form'
    ],

    [
        'route' => '/create_ad/create',
        'controller' => 'CreateAdController',
        'action' => 'create'
    ],

    [
        'route' => '/create_ad/edit/(?<id>[0-9]{1,})',
        'controller' => 'CreateAdController',
        'action' => 'editForm'
    ],

    [
        'route' => '/create_ad/edit/(?<id>[0-9]{1,})/set',
        'controller' => 'CreateAdController',
        'action' => 'edit'
    ],


    /**
     * Логин и регистрация
     */

    [
        'route' => '/auth',
        'controller' => 'AuthController',
        'action' => 'form'
    ],

    [
        'route' => '/auth/login',
        'controller' => 'AuthController',
        'action' => 'login'
    ],

    [
        'route' => '/auth/registration',
        'controller' => 'AuthController',
        'action' => 'registration'
    ],


    /**
     * Профиль
     */

    [
        'route' => '/profile',
        'controller' => 'ProfileController',
        'action' => 'userAds'
    ],

    [
        'route' => '/profile/my_ads',
        'controller' => 'ProfileController',
        'action' => 'userAds'
    ],

    [
        'route' => '/profile/watched',
        'controller' => 'ProfileController',
        'action' => 'watchedAds'
    ],

    [
        'route' => '/profile/edit_ad',
        'controller' => 'ProfileController',
        'action' => 'editAd'
    ],

    [
        'route' => '/profile/favorites',
        'controller' => 'ProfileController',
        'action' => 'favorites'
    ],

    [
        'route' => '/profile/favorites/add/(?<id>[0-9]{1,})',
        'controller' => 'ProfileController',
        'action' => 'addFavoriteAd'
    ],

    [
        'route' => '/profile/favorites/delete/(?<id>[0-9]{1,})',
        'controller' => 'ProfileController',
        'action' => 'deleteFavoriteAd'
    ],

    [
        'route' => '/profile/archive',
        'controller' => 'ProfileController',
        'action' => 'archive'
    ],

    [
        'route' => '/profile/settings',
        'controller' => 'ProfileController',
        'action' => 'settings'
    ],

    [
        'route' => '/profile/settings/set',
        'controller' => 'ProfileController',
        'action' => 'setSettings'
    ],

    [
        'route' => '/profile/archiveAd/(?<id>[0-9]{1,})',
        'controller' => 'ProfileController',
        'action' => 'archiveAd'
    ],

    [
        'route' => '/profile/unarchiveAd/(?<id>[0-9]{1,})',
        'controller' => 'ProfileController',
        'action' => 'unarchiveAd'
    ],

    [
        'route' => '/profile/deleteWatched/(?<id>[0-9]{1,})',
        'controller' => 'ProfileController',
        'action' => 'deleteWatchedAds'
    ],

    [
        'route' => '/profile/deleteAd/(?<id>[0-9]{1,})',
        'controller' => 'ProfileController',
        'action' => 'deleteAd'
    ],

    [
        'route' => '/profile/exit',
        'controller' => 'ProfileController',
        'action' => 'exit'
    ],

    [
        'route' => '/comment/user=(?<id_user>[0-9]{1,})',
        'controller' => 'CommentUserController',
        'action' => 'userComment'
    ],

    [
        'route' => '/comment/edit=(?<id_comment>[0-9]{1,})',
        'controller' => 'CommentUserController',
        'action' => 'editForm'
    ],

    [
        'route' => '/comment/edit=(?<id_comment>[0-9]{1,})/set',
        'controller' => 'CommentUserController',
        'action' => 'edit'
    ],

    [
        'route' => '/comment/create/user=(?<id_user>[0-9]{1,})',
        'controller' => 'CommentUserController',
        'action' => 'createCommentForm'
    ],

    [
        'route' => '/comment/create/user=(?<id_user>[0-9]{1,})/create',
        'controller' => 'CommentUserController',
        'action' => 'createComment'
    ],

    [
        'route' => '/comment/delete=(?<id_comment>[0-9]{1,})',
        'controller' => 'CommentUserController',
        'action' => 'deleteComment'
    ],

];
<?php
return [
    /*****USER******/

    'user/register' => 'user/register',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    
    /*****DIALOGS******/
    'dialogs' => 'dialog/show',
     // ajax dialog routes
    'dialog/create' => 'dialog/createDialog',
    'dialog/clearunread' => 'dialog/clearUnreadCounter',
    'dialog/addunread' => 'dialog/addUnreadCounter',
    'dialog/user' => 'dialog/user',
    // Management users: (future)
    'admin/user/create' => 'adminUser/create',
    'admin/user/update/([0-9]+)' => 'adminUser/update/$1',
    'admin/user/delete/([0-9]+)' => 'adminUser/delete/$1',
    'admin/user' => 'adminUser/index',
    // Admin panel:
     'admin' => 'admin/index',
    //Managing the user profile

    /*****PROFILE******/

    'profile/show' => 'profile/show',
    'profile/edit' => 'profile/edit',
    'profile/update' => 'profile/update',
    'profile/input' => 'profile/input',
    'profile/insert' => 'profile/insert',
    'profile/delete' => 'profile/delete',
    'profile/upload' => 'profile/upload',

    /*****ALBUMS******/

    'albums/insert' => 'albums/insert',
    'albums/delete/([0-9]+)' => 'albums/deleteAlbum/$1',
    'albums' => 'albums/index',

    /*****ALBUM******/

    'album/([0-9]+)' => 'album/index/$1',
    'album/insert/([0-9]+)' => 'album/insertPhoto/$1',
    'album/update/([0-9]+)' => 'album/updateAlbum/$1',
    'album/delete/([0-9]+)' => 'album/deletePhoto/$1',

    /*****FRIENDS******/

    'friend/all' => 'friend/all',
    'friend/delete/([0-9]+)' => 'friend/delete/$1',
    'friend/add/([0-9]+)' => 'friend/add/$1',
    'friend/accept' => 'friend/accept',
    'friend/decline' => 'friend/decline',
    'friend/incoming' => 'friend/incoming',
    'friend' => 'friend/index',

    /*****MAIN PAGE******/

    //Managing the user groups
    'groups/page' => 'group/GroupPage',
    'groups/add' => 'group/MyGroupCreateJSON',
    'groups/mysearch' => 'group/MyGroupsJSON',
    'groups/search' => 'group/FindGroupsJSON',
    'groups/subscribe' => 'group/Subscribe',
    'groups/unsubscribe' => 'group/UnSubscribe',
    'groups/find' => 'group/find',
    'groups' => 'group/index',
    'group/subsribe/([0-9]+)' => 'group/subsribe/$1',
    'group/unsubsribe/([0-9]+)' => 'group/unsubsribe/$1',

    //News and comments
    'news/delete-news' => 'news/delete/$1',
    'news/add-news' => 'news/add/$1',
    'news/get-news' => 'news/get/$1',
    'comments/delete-comments' => 'comments/delete/$1',
    'comments/add-comments' => 'comments/add/$1',
    'comments/get-comments' => 'comments/get/$1',
    'news' => 'news/index',
//
//
//
    'group/edit/([0-9]+)' => 'group/edit/$1',
    'group/([0-9]+)' => 'group/show/$1',
    // Main page
    'index.php' => 'site/index', // actionIndex in SiteController
    '' => 'site/index', // actionIndex in SiteController
];

<?php 
session_start();
include ('database.php');
include (__DIR__.'/../content/util.php');
include (__DIR__.'/authentication.php');
include (__DIR__.'/work_controller.php');
include (__DIR__.'/notify_controller.php');
include (__DIR__.'/get_data.php');

//------find function-------
if(isset($_POST['func'])){
    switch($_POST['func']){
        case 'authen':
            Authentication::authen();
            break;
        case 'loginFb':
            Authentication::loginFb();
            break;            
        case 'logout':
            Authentication::logout();
            break;
        case 'addWork':
            Work::addWork();
            break;
        case 'delWork':
            Work::delWork();
            break;
        case 'editWork':
            Work::editWork();
            break;
        case 'doneWork':
            Work::doneWork();
            break;
        case 'cancelLineNotify':
            Notify::cancelLineNotify();
            break;
        case 'addLineToken':
            Notify::addLineToken();
            break;
    }   
}

?>
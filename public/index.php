<?php
session_start();
use \brands\vendor\core\Router;

require_once '../vendor/libs/function.php';
require dirname(__DIR__) .'/vendor/autoload.php';
require '../const/my_const.php';


if(!isset($_SESSION['user'])){  //проверка авторизации
    require '../app/controller/LoginController.php';
} else {
       try{
        $url=trim($_SERVER['QUERY_STRING'],'/'); // удаляем мусор
        Router::add('^$',['controller'=>'Main', 'action'=>'index']); //добавление маршрута в таблицу маршрутов
        Router::add('login',['controller'=>'Main', 'action'=>'index']);//добавление маршрута в таблицу маршрутов
        Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?');//добавление маршрута в таблицу маршрутов
        Router::dispactch($url); // подключение контролера
    }
    catch(Exception $e){
        echo $e->getMessage();	
    }    
}


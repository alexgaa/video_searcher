<?php
namespace brands\vendor\core;

class Router {
    /**
    * Таблица маршрутов
    *@array
    */
    protected static $routes=[];
    /**
    * текущий маршрут
    *@array
    */
    protected static $route=[];
    /**
    * добавление маршрута в таблицу маршрутов
    *@param string $regexp регулярное выражение маршрута
    *@param array $route маршрут ([controller, action, params])
     */
    
    public static function add($regexp, $route=[]){
        self::$routes[$regexp]=$route;       
    }
    /**
     * возращает таблицу маршрутов
     */
    public static function getRoutes(){
        return self::$routes;
    }
    /**
     * возращает маршрут
     */
    public static function getRoute(){
        return self::$route;
    }
    /**
     * ищет URL  в таблице маршрутов
     * @param string $url входящий URL
     * @return boolean
     */
    public static function matchRoute($url){
        foreach (self::$routes as $pattern => $route){
            if(preg_match("#$pattern#i", $url, $matches)){
                foreach ($matches as $temp =>$temp2){
                    if(is_string($temp)){
                        $route[$temp]=$temp2;
                    }
                }
                if(!isset($route['action'])){
                    $route['action']='index';
                }
                $route['controller']=  self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }
    
    /**
     * перенаправляет URl по корректному маршруту
     * @param string $url входящий URL
     * return void
     */
    
    public static function dispactch($url){
        if(self::matchRoute($url)){
            $controller=  self::$route['controller'];
            $controller=LOCATION_CONTROLLER.self::upperCamelCase($controller)."Controller";
            
            if(!class_exists($controller)){
                $controller=LOCATION_CONTROLLER."MainController";
            }
            $obj= new $controller(self::$route);
            
            $action=self::$route['action'];
            $action=self::lowerCamelCase($action);
            // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!добавить для продакшена
            if(!method_exists($obj, $action)){
                $action='index';  //добавить для продакшена
            }
            //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!end добавить для продакшена
            if(method_exists($obj, $action)){
                $obj->$action();
                $obj->getView();
            }
            else{
                echo "НЕТ метода ".$action;
            }
        }
        else {
            include '404.html';
        }
    }
    
    /**
     * преобразовывает линк с '-'. пример'/New-Post' контролер New-Post
     * @param string $name 
     * return string
     */    
    protected static function upperCamelCase($name){
        $name= str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
        return $name;
    }
    protected static function lowerCamelCase($name){
        $name= lcfirst(self::upperCamelCase($name));
        return $name;
    }
    
}

 
<?php
namespace brands\vendor\core\base;

/**
 * Описание контроллера
 *
 * @author aleksey.ga
 */
class Controller {
    public $route=[];
    public $view;
    public $layout;
    /**
     *  Пользоватльские данные
     * @var array
     */
    public $vars;

    public function __construct($route) {
        $this->route=$route;
        $this->view=$route['action'];
    }
    
    public function getView(){
        $vObject=new View($this->route, $this->layout, $this->view);
        $vObject->render($this->vars);
        //$vObject->render();
    }
    
    public function set($vars){
        $this->vars=$vars;
    }
}

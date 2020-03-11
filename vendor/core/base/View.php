<?php
namespace brands\vendor\core\base;

/**
 * Description of View
 *
 * @author aleksey.ga
 */
class View {
    /**
    * базовый класс вида
    *@array
    */
   public $route=[];
   /**
    * текущий вид
    *@array
    */
   public $view;
   /**
    * текущий шаблон
    *@array
    */
   public $layuot;
   
   public function __construct($route, $layuot="",$view="") {
       $this->route=$route;
       if($layuot===false){
           $this->layuot=false;
       }
       else{
           $this->layuot=$layuot ?: LAYOUT;
           $this->view=$view;
       }
    }
   
    public function render($vars){
        if(is_array($vars)){
            extract($vars);
        }
        $file_view="../app/views/{$this->route['controller']}/{$this->view}.php";
        ob_start();
        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!добавить для продакшена
        if(!is_file($file_view)){
            $file_view="../app/views/{$this->route['controller']}/index.php"; // добавить для продакшена
        }
        if(is_file($file_view)){
            require $file_view;
        }
        else {
            $file_view="../app/views/Main/index.php"; // добавить для продакшена
            require $file_view;
            //echo "<p>Ненайден вид <b>{$file_view}</b></p>";
        }
        $content=ob_get_clean();
        if(false!==$this->layuot){
            $file_layout="../app/views/layuots/{$this->layuot}.php";
            if(is_file($file_layout)){
                require $file_layout;
            } else{
                //echo "<p>Ненайден шаблон <b>{$file_layout}</b></p>";
            }
        }
    }
}

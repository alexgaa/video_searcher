<?php
namespace brands\app\controller;
use \brands\app\models\users\WorkOnUsers;
use \brands\vendor\core\file\FileWork;
use \brands\app\models\users\UsersReadFile;
use \brands\app\models\users\UserReadSite;
use \brands\app\models\users\SearchUser;
use \brands\app\models\users\UserSaveBd;


class UsersController extends App
{
    public $layout='users'; // переопределение шаблона для всего контроллера
    public $view='users'; // переопределение вида для всего контроллера
    private $name_title='Users'; //title по умолчанию
    
    /**
    * Проверка, что пользователь есть Администратор
    * @return если не Администратор возращаем на main
    */
    public function __construct($route)
    {
        parent::__construct($route);
        if (!isset($_SESSION) && !session_id()) {
            session_start();
        }
        self::adminCheck();
    }
    
    /**
    * Открываем страницу администрирования ппользователей
    * @return нет возращаемых данных
    */
    public function index()
    {
        $title=$this->name_title;
        $type_of_action="Выберите необходимое действие в меню!";
        $arr=compact('title','type_of_action'); 
        $this->set($arr);
    }
    /**
    * Выводим список всех пользователей на чтение из базы
    * @return нет возращаемых данных
    */
    public function all()
    {
        $users= new WorkOnUsers();
        $user_array=$users->get(); // получаем массив дааных
        //$title='Users';
        $title=$this->name_title;
        $type_of_action="Просмотр всех пользователей в базе";
        $arr=compact('title','type_of_action','user_array'); 
        $this->set($arr);
    }
    /**
    * Выводим список всех пользователей на редактирование из базы
    * @return нет возращаемых данных
    */
    public function edit()
    {
        $title=$this->name_title;
        $result='';
        $type_of_action="Выдача новых паролей пользователям";
        if(isset($_POST['search_user_edit'])){
            $search_users= new SearchUser();
            $result_array=$search_users->searchBd();
                       
            if($result_array){
                $result="<br>Результат поиска: ";
                $arr=compact('title','type_of_action','result','result_array'); 
            }
            else{
                $result="<br>Результат поиска: По указанным параментрам данные не найдены!";
                $arr=compact('title','type_of_action','result'); 
            } 
        }
        else{
            $arr=compact('title','type_of_action'); 
        }
        $this->set($arr);
    }
    
    /**
     * Удаление пользователей
     * @return нет возращаемых данных
     */
    public function delete()
    {
        $title=$this->name_title;
        $result='';
        $type_of_action="Удаление пользователей из базы.";
        if(isset($_POST['search_user_delete'])){
           $search_users= new SearchUser();
           $result_array=$search_users->searchBd();
            if($result_array){
                $result="<br>Результат поиска: ";
                $arr=compact('title','type_of_action','result','result_array'); 
            }
            else{
                $result="<br>Результат поиска: По указанным параментрам данные не найдены!";
                $arr=compact('title','type_of_action','result'); 
            } 
        }
        else{
            $arr=compact('title','type_of_action'); 
        }
        $this->set($arr);
    }

    
    /**
     * Редактирование данных / доступов пользователей 
     * @return нет возращаемых данных
     */
    public function search()
    {
        $title=$this->name_title;
        $result='';
        $type_of_action="Редактирование данных / доступов пользователей";
        if(isset($_POST['search_user'])){
            $search_users= new SearchUser();
            $result_array=$search_users->searchBd();
            if($result_array){
                $result="<br>Результат поиска: ";
                $arr=compact('title','type_of_action','result','result_array'); 
            }
            else{
                $result="<br>Результат поиска: По указанным параментрам данные не найдены!";
                $arr=compact('title','type_of_action','result'); 
            } 
        }
        else{
            $arr=compact('title','type_of_action'); 
        }
        $this->set($arr);
    }

    /**
     * Отработка AJAX запроса из формы Search
     * Внесение изменений по пользователям в БД
     */
    public function savedb()
    {
        if(isset($_POST['array_js'])){
            $this->layout=false; // отключение шаблона, для обработки Ajax запроса
            $edit_data= new UserSaveBd();
            if($edit_data->analysis()){
                echo "Обновление прошло успешно.";
            }
            else{
                echo "Ошибка обновления в БД.";
            }
        }
        else{
            $this->layout='users'; // подключение макета users
        }
    }

    
    /**
    * Добавление нового пользователя из формы
    * @return нет возращаемых данных
    */
    public function newUser()
    {
        $title=$this->name_title;
        $type_of_action="Добавление нового пользователя";
        $result='';
        if(isset($_POST['add_new_user'])){
            $new_user=new UserReadSite();
            if($new_user->userAddBase()){
                $result="Данные успешно добавлены добавлены! Логин: ".$_POST['username']." Пароль: ".$_POST['pass'];
            }
            else{
                $result=$new_user->error;
            }
        }
        $arr=compact('title','type_of_action','result'); 
        $this->set($arr);
    }

    /**
    * Форма для загрузки пользователей из файла
    * @return нет возращаемых данных
    */
    public function download()
    {
        $title=$this->name_title;
        $type_of_action="Добавление новых пользователей. Обновление доступов по существующим пользователям, загрузкой из файла.";
        if(!empty($_FILES)){
            $userFile=new UsersReadFile();
            if($userFile->addUsers('fileusers')){
                $result="Загрузка прошла успешно!";
            }
            else{
                $result=$userFile->error;
            }
            $arr=compact('title','type_of_action','result'); 
        }
        else{
            $arr=compact('title','type_of_action');
        }
        $this->set($arr);
    }

    /**
    * Проверка, что пользователь есть Администратор
    * @return если не Администратор возращаем на main
    */        
    private static function adminCheck()
    {
        if(!password_verify(ADMIN, $_SESSION['user'])){
            header ("Location: http://www.test.importer-tool.com");
        }
    }
}
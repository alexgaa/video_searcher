<?php
namespace brands\app\models\main;

use \brands\app\models\general\UserData;
use \brands\app\models\db\DbWork;
use \brands\app\models\general\UrlCheck;

/**
 * Description of InputData
 *
 * @author aleksey.ga
 */
class InputData {
    public $error='';
    /**
     * сохранение данный пользователя в базу
     * @return boolean
     */
    public function saveInputData(){
        //валидация входящего линка
        $linkInput=UrlCheck::inputUrl('linkUser');
        if(!$linkInput){
            $this->error=ERROR_TEXT."Введённый линк '".$_POST['linkUser']."' - Битый ";
            return false;
        }
        $ip=UserData::ip(); //получаем IP пользователя
        $browser=UserData::browser(); //получаем данные браузера
        if (DbWork::saveUserData($ip, $browser)){ //сохраняем данные в базу
        } else{
                $this->error="Ошибка добавления в Базу!";
                return false;
        }
        return $linkInput;
    }
}

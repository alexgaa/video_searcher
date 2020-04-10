<?php
namespace App\Models\db;

use App\Vendor\db\DB;
use Symfony\Component\HttpFoundation\Session\Session;

class DbWork
{

   /**
     * Сохранение данных в базу запросов линков
     * @param string $linkInput // входящий линк
     * @return boolean
     */
    public static function saveLinkUser($linkInput)
    {
        $db=DB::getDB(DB_SEARCH_VIDEO);
        //добавление в базу входящих линков
        $session = new Session();
        $data2['name']=$session->get('dir_user');
        $data2['url_key']=substr($linkInput, URL_KEY_START, URL_KEY_END);// формируем ключ из линка
        $data2['url']=$linkInput;
        $data2['date']=date('Y-m-d');
        $sql1="REPLACE INTO input_url (`user_id`, `url_key`,`url`, `date`)";
        $sql2=" VALUES ((SELECT `id` as `id_user` FROM `user_data` WHERE name_user=:name), :url_key, :url, :date)";
        $sql=$sql1.$sql2;
        if (!$db->send($sql, $data2)){
            return false;
        }
        return true;    
    }
    
    /**
     * Добавление информации по новому видео
     * @param string $link входящий линк
     * @param array $arrayData массив данных с информацией по видео
     */
    public static function addNewVideoData($link,$arrayData)
    {
        $db=DB::getDB(DB_SEARCH_VIDEO);
        $session = new Session();
        $data['name']=$session->get('dir_user');
        $data['url_key']=substr($link, URL_KEY_START, URL_KEY_END); // формируем ключ из линка
        $data['id_video']=$arrayData['id_video'];
        $data['img_site']=$arrayData['img_site'];
        $data['title']=$arrayData['title'];
        $data['description']=$arrayData['description'];
        $data['img_youtube']=$arrayData['img_youtube'];
        $data['valid']=$arrayData['valid'];
        $data['date']=date('Y-m-d');
        $sql1="(SELECT input_url.id as id_input_url FROM `input_url` INNER JOIN `user_data` ON input_url.user_id=user_data.id WHERE user_data.name_user=:name AND input_url.url_key=:url_key)";
        $sql="INSERT INTO `video_data` (input_url_id, id_video, img_site, title, description, img_youtube, valid, date) SELECT ".$sql1.", :id_video, :img_site,"
                . " :title, :description, :img_youtube, :valid, :date";
        if (!$db->send($sql, $data)){
            return false;
        } 
        return true;
    }
    
    /**
     * обновление данных в таблице video_data по id
     * @param string $id_dbData ID обновляемой записи в таблицу
     * @param array $arrayData  массив даннх для обновления
     * @return boolean результат true/ false 
     */
    public static function updateVideoData($id_dbData, $arrayData)
    {
        $db=DB::getDB(DB_SEARCH_VIDEO);
        $data['id']=$id_dbData;
        $data['id_video']=$arrayData['id_video'];
        $data['img_site']=$arrayData['img_site'];
        $data['title']=$arrayData['title'];
        $data['description']=$arrayData['description'];
        $data['img_youtube']=$arrayData['img_youtube'];
        $data['valid']=$arrayData['valid'];
        $data['date']=date('Y-m-d');
        $sql="UPDATE `video_data` SET id_video=:id_video, img_site=:img_site, title=:title, description=:description, img_youtube=:img_youtube, valid=:valid, date=:date  WHERE id=:id";
        if(!$db->send($sql, $data)){
            return false;
        }
        return true;
    }
    /**
     * Удаление данных из таблицы video_data по id
     * @param string $id_dbData ID удаляемой записи в таблице
     * @return boolean
     */
    public static function deleteVideoData($id_dbData)
    {
        $db=DB::getDB(DB_SEARCH_VIDEO);
        $data['id']=$id_dbData;
        $sql="DELETE FROM `video_data` WHERE id=:id";
        if(!$db->send($sql, $data)){
            return false;
        }
        return true; 
    }
    
    /**
     * Удаление массива данных из таблицы video_data по id
     * @param array $dataArray ID удаляемой записи в таблице
     * @return boolean
     */
    public static function deleteArrayVideo($dataArray)
    {
        if(empty($dataArray)){
            return false;
        }
        foreach ($dataArray as $temp){
            $temp=filter_var($temp,FILTER_VALIDATE_INT);
            if(!self::DeleteVideoData($temp)){
                return false;                
            }
        }
        return true;
    }

    /**
     * Получение всех данных из таблицы video_data
     * @return array / boolean возращаем массив данных или false
     */
    public static function selectAllData()
    {
        $db=DB::getDB(DB_SEARCH_VIDEO);
        $sql="SELECT input_url.url, user_data.name_user, video_data.* FROM `video_data` INNER JOIN input_url ON video_data.input_url_id=input_url.id INNER JOIN user_data ON user_data.id=input_url.user_id";
        $session = new Session();
        $typeuser=$session->get('dir_user');
        if ($typeuser!='admin'){
            $data['name']=$typeuser;
            $sql=$sql." WHERE user_id=(SELECT user_data.id FROM user_data WHERE user_data.name_user=:name)";
            $arrayDb=$db->get($sql, $data);
        } else {
            $arrayDb=$db->get($sql);
        }
        if(empty($arrayDb)){
            return false;
        } else {
            return $arrayDb;
        }
    }
    
}

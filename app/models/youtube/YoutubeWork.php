<?php
namespace brands\app\models\youtube;

use \brands\app\models\content\Analysis;
/**
 * Работа с данными Youtube
 *
 * @author aleksey.ga
 */
class YoutubeWork {
    
    /**
     * Получаем всю информацию по видеос с с Youtube по списку ID видео
     * @param type $linkArr
     * @return type
     */
    public function selectionData($linkArr)
    {
        if(!$linkArr){
            return false; // входящие данные пустые - выход
        }
        //Получение данных c Youtube
        $i=0;
        foreach ($linkArr as $temp){
            $result=$this->dataForYoutube($temp['id_video']); // получаем массив данных из google
            $linkArr[$i]['title']=$result['title'];
            $linkArr[$i]['description']=$result['description'];
            $linkArr[$i]['img_youtube']=$result['img_youtube'];
            $linkArr[$i]['valid']=$result['valid'];
            $i++;
        }
        return $linkArr;
    }
    
    /**
     * Получаем данные с Youtube
     * @param string ID видео
     * @return array массив данных
     */
    public function dataForYoutube($video_id){
        $order   = array("\r\n", "\n", "\r","|" ); // спецсимволы на удаление
        $replace = ' '; // на что заменяем спец символы
        //значения по умолчанию
        $result['title'] ="";
        $result['description'] ="";
        $result['img_youtube'] = "";
        $result['valid']="Link Error: Video Not Found";
        $api_key = API_KEY; // Google API key
        //получаем данные из google
        $json_result = file_get_contents ("https://www.googleapis.com/youtube/v3/videos?part=snippet&id=$video_id&key=$api_key");
        $obj = json_decode($json_result); //распарсиваем результат
        if ($obj->pageInfo->totalResults){ // проверям есть ли видео с таким ID
            $temp_result=$obj->items[0]->snippet->title; //получаем title
            if(!empty($temp_result)){
                $result['title'] =str_replace($order,$replace, $temp_result); //чистим от сцец символов title
            }
            $temp_result = $obj->items[0]->snippet->description; //получаем description
            if(!empty($temp_result)){
                $result['description'] = str_replace($order,$replace, $temp_result); //чистим от сцец символов description
            }
            if(isset($obj->items[0]->snippet->thumbnails->maxres)){
                $temp_result =$obj->items[0]->snippet->thumbnails->maxres->url; //получаем img_youtube
                if(!empty($temp_result)){
                    $result['img_youtube'] = str_replace($order,$replace, $temp_result); //чистим от сцец символов img_youtube
                }   
            }
            $result['valid']='';
        }
        return $result;
    }
}

    

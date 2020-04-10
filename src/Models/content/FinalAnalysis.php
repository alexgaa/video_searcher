<?php

namespace App\Models\content;

use App\Models\db\DbWork;
use App\Vendor\db\DB;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;


/**
 * Description of FinalAnalysis
 *
 * @author aleksey.ga
 */
class FinalAnalysis extends AbstractController
{
    public $error='';
    private $id_input_url;
    public function allDataCheck($link, $arrayAllData)
    {

 //       $this->chekOldOrNewData($link);

//        //проверяем запрашивал ли пользователь ранее информацию
       if ($this->chekOldOrNewData($link)){
//            //ранее не запрашивалась, записываем всю полученную информацию в базу
            DbWork::saveLinkUser($link); //Добавляем данные в базу запросов
           if(!$arrayAllData){
               return false; //входящие данные пустые - выход
           }
            foreach ($arrayAllData as $temp){
                $resultData=DbWork::addNewVideoData($link,$temp);
                if (!$resultData){
                    $this->error=ERROR_TEXT." Ошибка сохранения в базу данных ID видео: ".$temp['id_video'];
                    return false;
                }
            }
            return $arrayAllData;
       } else {
            //ранее запрашивалась
            $resultData=$this->ComparisonNewAndOldData($link, $arrayAllData);
            if(!$resultData){
                return false;
            } else{
                return $resultData;
            }
       }
    }
    
    /**
     * Проверка запрашивалась ли ранее этим пользователем такаяже информация
     * @param string $link
     * @return boolean результат проверки: false - запрашивалась, true - не запрашивалась
     */
    public function chekOldOrNewData($link)
    {
        $db=DB::getDB(DB_SEARCH_VIDEO);
        $session = new Session();
        $data['name']=$session->get('dir_user');
        $data['url_key']=substr($link, URL_KEY_START, URL_KEY_END);
       // проверка есть ли пользователь и линк  в базе
       $sql="SELECT input_url.id FROM `input_url` INNER JOIN `user_data` ON input_url.user_id=user_data.id WHERE user_data.name_user=:name AND input_url.url_key=:url_key";
       $temp=$db->get($sql,$data);
        if(!empty($temp)){
            $this->id_input_url=$temp[0]['id'];
            return false; // линк есть
        } else{
            return true; // линка нет
        }
    }
    
    /**
     * Сравнение входящих данных с данными из базы
     * @param string $link входящий линк
     * @param array $inputAllDataArray массив входящих данный с сайта
     * @return boolean
     * 
     */
    public function ComparisonNewAndOldData($link,$inputAllDataArray)
    {
        $resultData=[]; //массив с результатом
        $i=0; // счётчик массива с результатами
        $dbAllDataArray=$this->selectAllData(); //получаем все данные из DB таблицы video_data для пользователя и линка
        //var_dump($dbAllDataArray);
        if($inputAllDataArray){
            foreach ($inputAllDataArray as $inputData){
                $foundValueCounter=0; // обнуляем счётчик найденых совпадений
                $counterDbData=0; // обнуляем счётчик массива с данными из базы
                // добавляем все входящие данные в массив с результатом
                 //изначально считаем, что различий нет
                $resultData[$i]['id_video']=$inputData['id_video'];
                $resultData[$i]['img_site']=$inputData['img_site'];
                $resultData[$i]['old_img_site']='';
                $resultData[$i]['title']=$inputData['title'];
                $resultData[$i]['old_title']='';
                $resultData[$i]['description']=$inputData['description'];
                $resultData[$i]['old_description']='';
                $resultData[$i]['img_youtube']=$inputData['img_youtube'];
                $resultData[$i]['old_img_youtube']='';
                $resultData[$i]['valid']=$inputData['valid'];
                $resultData[$i]['old_valid']='';
                $resultData[$i]['old_date']='';
                if($dbAllDataArray){
                    foreach ($dbAllDataArray as $dbData){
                        if($inputData['id_video']==$dbData['id_video']){ // ID входящего  найдено в массиве из DB
                            $foundValueCounter++;  // срабатывает счётчик найденых совпадений
                            //сверяем входящую информацию с инфрорацией в базе, различия записываем в массив результата
                            if(strcmp($inputData['img_site'], $dbData['img_site']) !== 0){
                                if($dbData['img_site']){
                                    $resultData[$i]['old_img_site']=$dbData['img_site'];
                                }else{
                                    $resultData[$i]['old_img_site']="No images!";
                                }
                            }
                            if(strcmp($inputData['title'], $dbData['title']) !== 0){
                                if($dbData['title']) {
                                    $resultData[$i]['old_title'] = $dbData['title'];
                                }else{
                                    $resultData[$i]['old_title']="No data!";
                                }
                            }
                            if(strcmp($inputData['description'], $dbData['description']) !== 0){
                                if($dbData['description']) {
                                    $resultData[$i]['old_description']=$dbData['description'];
                                }else{
                                    $resultData[$i]['old_description']="No data!";
                                }
                            }
                            if(strcmp($inputData['img_youtube'], $dbData['img_youtube']) !== 0){
                                if($dbData['img_youtube']) {
                                    $resultData[$i]['old_img_youtube']=$dbData['img_youtube'];
                                }else{
                                    $resultData[$i]['old_img_youtube']="No images!";
                                }
                            }
                            if($inputData['valid']!=$dbData['valid']){
                                $resultData[$i]['old_valid']=$dbData['valid'];
                            }
                            $resultData[$i]['old_date']=$dbData['date'];  // добавляем дату прошлого обновления информации

                            array_splice($dbAllDataArray, $counterDbData, 1); // //удаляем найденное значение массива данных из масиива данных из базы
                            if(!DbWork::updateVideoData($dbData['id'], $inputData)){ //обновляем данные в базе данными из входящего массива
                                echo "Ошибка обновления ID:".$dbData['id'];
                                return false;
                            }
                            break; //прерываем поиск, переходим к следующему значению из входящего массива
                        }
                        $counterDbData++;  //увеличиваем счётчик  массива с данными из базы
                    }
                }
                if ($foundValueCounter==0){  // если совпадений ID из входящих данных нет в массиве DB
                    $resultData[$i]['old_valid']='New'; // добавляем пометку, что ранее видео небыло в базе
                    if(!DbWork::addNewVideoData($link, $inputData)){ // Добавляем информацию из входящего массива в базу
                        echo "Ошибка! Добавления новых данных в DB video_data<br>";
                        return false;
                    }
                }
                $i++;    //увеличиваем счётчик  массива с результатами
            }
        }
        if(!empty($dbAllDataArray)){
            foreach ($dbAllDataArray as $dbData){
                // добавляем все оставшиеся данные из массива DB в массив с результатом
                $resultData[$i]['id_video']=$dbData['id_video'];
                $resultData[$i]['img_site']='';
                $resultData[$i]['old_img_site']=$dbData['img_site'];
                $resultData[$i]['title']='';
                $resultData[$i]['old_title']=$dbData['title'];
                $resultData[$i]['description']='';
                $resultData[$i]['old_description']=$dbData['description'];
                $resultData[$i]['img_youtube']='';
                $resultData[$i]['old_img_youtube']=$dbData['img_youtube'];
                $resultData[$i]['valid']="ERROR: Video none in site ".$link;
                $resultData[$i]['old_valid']=$dbData['valid'];
                $resultData[$i]['old_date']=$dbData['date'];
                if(!DbWork::deleteVideoData($dbData['id'])){ // удаляем данные из базы
                    echo "Ошибка! Удаления данных в DB video_data<br>";
                    return false;
                }
                $i++;
            }
        }
        return $resultData;
    }

    /**
     * Получение всех данных из таблицы video_data
     * @param string $nameTable имя таблицы
     * @param string $fileConfigDB пусть к файлу с настройками DB
     * @return array / boolean возращаем массив данных или false
     */
    public function selectAllData()
    {
        $db=DB::getDB(DB_SEARCH_VIDEO);
        $sql="SELECT * FROM video_data WHERE input_url_id='".$this->id_input_url."'";
        $arrayDb=$db->get($sql);
        if(empty($arrayDb)){
            return false;
        } else {
            return $arrayDb;
        }
    }
    
}

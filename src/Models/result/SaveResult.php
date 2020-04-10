<?php
namespace App\Models\result;

use App\Vendor\file\FileWork;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Сохранение результатов в файлы
 *
 * @author aleksey.ga
 */
class SaveResult 
{
    /**
     * Сохранение результата в файл
     * @param array $arrayData данные для записи
     * @param string $nameFile имя записываемого файла
     * @param type $fileColumn имя файла с названием столбцов
     * @return boolean true если всё ок
     */
    public static function saveResultFile($arrayData, $nameFile, $fileColumn)
    {
        if(!empty($arrayData)){ //входящие данные пустые - выход
            $nameColumArrayResult=require_once $fileColumn; //  получаем названия столбцов
            $arrayData=self::formLink($arrayData, LINK_YOUTUBE); //формируем конечный линк по ID_video
            if(!empty($nameColumArrayResult)){
                array_unshift($arrayData, $nameColumArrayResult);//добавляем названия столбцов
            }
            FileWork::csvWriteFile($nameFile,$arrayData); //записываем данные в файл CSV
            return true;
        }
        return false;
    }
    /**
     * Сохраняет в файл ошибки по линкам
     * @param array $arrayData данные для записи
     * @param string $nameFile имя записываемого файла
     * @param type $fileColumn имя файла с названием столбцов
     * @return boolean true если всё ок
     */
    public static function saveErrorLink($arrayData, $nameFile, $fileColumn)
    {
        $resultArray=[];
        $i=0;
        if(!empty($arrayData)){
            foreach ($arrayData as $temp){
                if($temp['valid']!=''){
                    $resultArray[$i]['id_video']=$temp['id_video'];
                    $resultArray[$i]['valid']=$temp['valid'];
                    $i++;
                }
            }
            if(!empty($resultArray)){
                if(self::saveResultFile($resultArray, $nameFile, $fileColumn)){
                    return count($resultArray);
                }
            }
        }
        return false;
    }
    /**
     * Формируем конечный линк для пользователя для видео и картинки
     * @param string $arrayData //массив с данными
     * @param string $LinkPart // приписка к линку
     * @return string
     */
    public static function formLink($arrayData,$LinkPart)
    {
        $max=count($arrayData);
        for ($i=0; $i<$max; $i++){
            $arrayData[$i]['id_video']=$LinkPart.$arrayData[$i]['id_video'];
            if(isset($arrayData[$i]['img_site'])){
                if($arrayData[$i]['img_site']!=''){
                    $arrayData[$i]['img_site']=LINK_LEXANI_IMG.$arrayData[$i]['img_site'];
                }
            }
            if(isset($arrayData[$i]['old_img_site'])){
                if($arrayData[$i]['old_img_site']!='' or $arrayData[$i]['old_img_site']!='No images!'){
                 $arrayData[$i]['old_img_site']=LINK_LEXANI_IMG.$arrayData[$i]['old_img_site'];
                }
            }
        }
        return $arrayData;
    }
    /**
     * Удаление столбцов из массива
     * @param array $arrayData массив данных
     * @param array $arrKeyDel массив ключей для удаления столбцов
     * @return boolean/array возращаем очищеный массив
     */
    public static function delColumn($arrayData,$arrKeyDel)
    {
        if(!$arrayData){
            return false;
        }
        $i=0;
        foreach ($arrayData as $temp ) {
            foreach ($temp as $key=>$value ){
                if($key == $arrKeyDel[0] OR $key == $arrKeyDel[1]) {
                    unset($arrayData[$i][$key]);
                }
            }
            $i++;
        }
        return $arrayData;
    }
    
}

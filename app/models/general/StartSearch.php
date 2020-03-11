<?php
namespace brands\app\models\general;

use \brands\app\models\main\InputData;
use \brands\app\models\content\Analysis;
use \brands\app\models\youtube\YoutubeWork;
use \brands\app\models\content\FinalAnalysis;
use \brands\app\models\result\SaveResult;

/**
 * Поиск видео на входящем сайте
 *
 * @author aleksey.ga
 */
class StartSearch 
{
    /**
     * Поиск видео на сайте https://lexani.com/videos
     * @return array возращает массив данных для вывода в шаблон
     */
    public static function lexani()
    {
        $keyword= require_once KEYWORD_SEARCH_BLOCK; //ключевые слова для поиска блока с видео
        $result="";
        $summaryData=[];
        $inputData= new InputData();
        //открыть проверку!!!!!!!!!!!!!!!!!!1
        $inputLink= $inputData->saveInputData(); //валидируем и сохраняем полученный линк и данные о пользователе в DB
        if($inputLink){
            //поиск видео на сайте
            $content = file_get_contents($inputLink);//получам содержимое сайта в строку
            //$content = file_get_contents(DIR_TEMP.'temp_site_lexani.html');//получам содержимое файла сайта в строку
            $analysis= new Analysis();
            $arrayVideo=$analysis->searchVideo($content, $keyword); //поиск блоков с видео в строке с контентом
            $linkArr=$analysis->parsingArraStrVideo($arrayVideo); // разбираем массив и достаём id видео+ его img 
            $workYoutube=new YoutubeWork;
            $finish_array_data=$workYoutube->selectionData($linkArr); //получаем данные с Youtube
            //сохраняем результат поиска в файл файл
            SaveResult::saveResultFile($finish_array_data,NAME_FILE_RESULT,COLUM_NAME_RESULT);
            //анализ полученных данных
            $finalAnalysis= new FinalAnalysis();
            $resultArray=$finalAnalysis->allDataCheck($inputLink, $finish_array_data);//сравниваем новые данные с линками в DB
            if(!$resultArray){
                if($finalAnalysis->error){
                    $result=$finalAnalysis->error;
                }
            } else {
                if(isset($resultArray[0]['old_img_site'])){ //проверяем было ли сравнение
                    //сохраняем результат сравнени в файл файл
                    if(SaveResult::saveResultFile($resultArray, NAME_FILE_COMPARISON, COLUM_NAME_COMPARISON)){
                    }
                }
            } 
            $summaryData=Analysis::summaryData($resultArray,$finish_array_data);//Вычитываем кол-во: найдены, старых, новых и не актуаотных линков
            //сохраняем ошибки в файл если они есть
            $summaryData['error']=SaveResult::saveErrorLink($resultArray, NAME_FILE_LINK_ERROR, COLUM_NAME_LINK_ERROR);
        } else {
            $result=$inputData->error;
        }
        $arr=compact('result','keyStatus','inputLink','summaryData'); //пакуем результаты в массив
        return $arr;
    }
            
}

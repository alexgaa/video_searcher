<?php
namespace App\Models\content;

use App\Models\general\UrlCheck;

/**
 * Нахождение видео в строке c полученным контенсом сайта
 *
 * @author aleksey.ga
 */
class Analysis {
    
    /**
     * Проверяет есть ли на сайте видео 
     * @param string $content данные для проверки
     * @param array $keyword массив ключевых слов для поиска
     * @return array/boolean возращает найденое количество вхождений
     */
    public function searchVideo($content,$keyword)
    {
        $arrayLinkVideo=$this->searchAllString($content, $keyword['start'],$keyword['end']); //получаем массив строк с гипотетическим видео
        if(!$arrayLinkVideo){
            return false;  // если видео не найден выход
        }
        return $arrayLinkVideo;
    }
    
    /**
     * 
     * @param int $max длина сходящей строки
     * @param int $start позиция страта поиска
     * @param string $content строка для поиска
     * @return int возвращает конечную позицию относительно входяшей строки
     */
    public function searchEndStr($content,$start,$end)
    {
        $content=substr($content,$start);//  обрезает сроку до начала вхождения   
        $endStr=stripos($content,$end);
        return $endStr; 
    }
    
    /**
     * Выбирает из строки все подстроки похожие на видео (по ключевым словам)
     * @param string $content строка для поиска
     * @param array $keywordArr массив ключевых слов для поиска;
     * @return boolean/array массив строк похожих на линки видео или или фалзе если ничего не найдено
     */
    public function searchAllString($content,$keywordStart,$keywordEnd)
    {
        $max=strlen($content); //определяем длину строки
        $resultArr=[]; // массив для хранения найденных строк с гипотетич видео
        $startOffset=0; // начальное смещение для поиска в строке
        $endStr=0;
            while ($startOffset< $max){
                $start=stripos($content, $keywordStart,$startOffset); // находим начало строки похожей на видео
                if ($start){
                    $endStr=$this->searchEndStr($content, $start, $keywordEnd); // находим конец строки похожей на видео
                    if ($endStr){
                        $tempresult=substr($content, $start, $endStr); //добавляем найденую строку похожую на видео в массив
                        $resultArr[]=substr($tempresult, strlen($keywordStart)); //обрезаем ключевое слово
                        $startOffset=$start+$endStr; // делаем смещени начала поиска от последней найденой строки
                    } else { //если во всей строке не найдено начало вхождения -  выход
                        $startOffset=$max;
                    }
                } else { //если во всей строке не найден конец вхождения -  выход
                    $startOffset=$max;
                }            
            }
        if (!empty($resultArr)){
            return $resultArr;
        }
        return false;
    }
    
    /**
     * Поиск одной строки по ключевым словам
     * @param srting $content строка для поиска
     * @param srting $keywordStart ключь начала искомой строки
     * @param srting $keywordEnd ключь конца искомой строки
     * @param srting $startOffset смещение от начала строки
     * @return string / boolean возращате строку или false
     */
    public function searchSingleString($content, $keywordStart, $keywordEnd, $startOffset=0){
        $start=stripos($content, $keywordStart, $startOffset); // находим начало строки похожей на видео
        if ($start){
            $endStr=$this->searchEndStr($content, $start,$keywordEnd); // находим конец строки похожей на видео
            if ($endStr){
                $tempresult=substr($content, $start, $endStr); //добавляем найденую строку похожую на видео в массив
                return substr($tempresult, strlen($keywordStart)); //обрезаем ключевое слово
            } 
        } 
        return false;
    }

    /**
     * выбирает из строк id видео и формрует URL, выбирает и формирует URL IMG
     * @param array входящий массив строк с гипотетическим видео
     * @return boolean/array 2х массив строк видео + картинка
     */
    public function parsingArraStrVideo($arraySringVideo)
    {
        if(!$arraySringVideo){ // входящие данные пустые - выход
            return false;
        }
        $resultArra=[];
        $keywordArrUrl= require_once KEYWORD_SEARCH_VIDEO;   // ключевые слова для видео    
        $keywordArrImg =require_once KEYWORD_SEARCH_IMG;// ключевые слова для картинки
        $i=0; // счётчик
        foreach ($arraySringVideo as $temp){
            $url_ID=$this->searchAllString($temp, $keywordArrUrl['start'],$keywordArrUrl['end']); // получаем ID видео
            if ($url_ID){ // если ID получен
                $resultArra[$i]['id_video']=$url_ID[0]; // сохраняем ID в массив
                $url_Img=$this->searchAllString($temp,$keywordArrImg['start'],$keywordArrImg['end']); // получаем ID картинки
                if ($url_Img){ // если картинка получена
                    if(UrlCheck::checkLink(LINK_LEXANI_IMG.$url_Img[0])){ //валидируем найденую картинку
                        $resultArra[$i]['img_site']=$url_Img[0]; // сохраняем картинку в массив
                    } else {
                        //получаем альтернативную картинку
                        $url_Img=$this->searchAllString($temp,$keywordArrImg['start_alternative'],$keywordArrImg['end_alternative']); // получаем ID картинки
                        $resultArra[$i]['img_site']=$url_Img[0];                       
                    }
                }
                $i++;
            }
        }
        if (!empty($resultArra)){
            return $resultArra;
        }
        return false;
    }

    /**
     * Вычитываем кол-во: найдены, страрых, новых и не актуаотных линков
     * @param array $arrayData - массив линков сравнения
     * @param arry $newArrayData - массив найденых на сайте линков
     * @return array  массив подсчитанных значений
     */
    public static function summaryData($arrayData,$newArrayData)
    {
        $resultCount['new']=0; //кол-во новых линков
        $resultCount['old']=0;
        $resultCount['none']=0;
        $resultCount['all']=0;
        if($newArrayData){
         $resultCount['all']=count($newArrayData);// кол-во найденых линков
        }
        if(!isset($arrayData[0]['old_valid'])){ //если нет изменений данных выход
            return $resultCount;
        }
        foreach ($arrayData as $temp){
            if($temp['old_valid']=='New'){
                 $resultCount['new']++;
            }
        }
        $countLink=count($arrayData); //кол-во линков в файле сравнения
        if($resultCount['all']){
            
            $resultCount['old']=$resultCount['all'] - $resultCount['new'];//кол-во линков старых
        } else {
            $resultCount['old']=$countLink;
        }
        $resultCount['none']=$countLink-$resultCount['all']; //кол-во линков нет на сайте уже
        return $resultCount;
    }

    /**
     * Удаляем из строки блок, заголовок (HEAD)
     * @param string $content  входящая строка с содержимым сайта
     * @return string возращаем строку без HEAD 
     */    
    public function delHeadBlock($content){
        $start=stripos($content, "</head>");
        $content=substr($content,$start);
        return $content;
    }

}

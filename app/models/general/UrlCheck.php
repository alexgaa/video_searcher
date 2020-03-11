<?php
namespace brands\app\models\general;

/**
 * Валидация и проверка линка
 *
 * @author aleksey.ga
 */
class UrlCheck 
{
    /**
    * Валидация и проверка линка
    * @param string $url
    * @return string возращает корректный линк или false если не валидный
    */
    public static function inputUrl($name)
    {
        $linkUser=filter_input(INPUT_POST, $name); //получаем линк
        if ($linkUser){ // проверяем отправлен ли линк
            //валидирем линк на коррекность
         $linkValid=UrlCheck::validURL($linkUser);
            
            if ($linkValid){
                return $linkValid;
            }
        }
        return false;
    }
    
    /**
     * Валидирует и пытается привести линк к правильному виду
     * @param string $url 
     * @return boolean|string
     */
    public static function validURL($url)
    {   
       $patternUrl="~^(?:(?:https?|ftp|telnet)://(?:[a-z0-9_-]{1,32}(?::[a-z0-9_-]{1,32})?@)?)?(?:(?:[a-z0-9-]{1,128}\.)+"
               . "(?:ru|su|com|net|org|mil|edu|arpa|gov|biz|info|aero|inc|name|[a-z]{2})|(?!0)(?:(?!0[^.]|255)[0-9]{1,3}\.)"
               . "{3}(?!0|255)[0-9]{1,3})(?:/[a-z0-9.,_@%&?+=\~/-]*)?(?:#[^ '\"&]*)?$~i "; 
        if (!preg_match($patternUrl,$url)) { // первичная проверка через регулярное выраженеи URL
            return false;
        }
        if (self::checkLink($url)){  //проверяем лик как есть
            return $url;
        } elseif (!strstr($url,'https')){ // если у линка нет https
            $url=str_replace('http','https',$url); // если у линка есть http меняем на https
            if (self::checkLink($url)){
               return $url;
            } elseif (!strstr($url,'http')) { // у линка нет явного протокола, делаем приписку https
                $url="https://".$url;
                if (self::checkLink($url)){
                    return $url;
                } else {
                    $url=str_replace('https://','https://www.',$url); // Последняя попытка добавляяем www после https
                    if (self::checkLink($url)){
                        return $url;
                    }
                }  
            }
        }
        $url=str_replace('https://','https://www.',$url); // Последняя попытка добавляяем www после https
            if (self::checkLink($url)){
                return $url;
        }
        return false;  // линк не валидный возращем false
    }
    
    /**
     *  Провеска существует ли такой линк
     * @param string $url линк на сайт
     * @return boolean
     */
    public static function checkLink($url)
    {
        $headers = get_headers($url);
        if($headers){
            $err_flag = (strpos($headers[0], '200') ? '200' : '404');
            if ($err_flag==200){
                return true;
            }
        }
        return false;
    }
}

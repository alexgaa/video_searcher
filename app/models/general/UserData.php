<?php
namespace brands\app\models\general;

/**
 * Получение различной информации о пользователе
 *
 * @author aleksey.ga
 */
class UserData
{
    /** Определяет ip пользователя
     * 
     * @return string возращает ip пользователя
     */
    public static function ip()
    {
        if (filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP', FILTER_VALIDATE_IP)){
            $ip=filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP', FILTER_VALIDATE_IP);
        } elseif (filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR', FILTER_VALIDATE_IP)){
            $ip=filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR', FILTER_VALIDATE_IP);
        } elseif (filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP)){
            $ip=filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP);
        }
        else{ 
            $ip="0.0.0.0.0";
        }
        return $ip;
    }
    /**
     * определяем тип браузера пользователя
     * @return string возращает информацию о браузере
     */
    public static function browser()
    {
        if (filter_input(INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_SANITIZE_STRING)){
            $browser=filter_input(INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_SANITIZE_STRING);
            
        } else{
            $browser="Браузер не определён";
        }
        return $browser;
    }
}

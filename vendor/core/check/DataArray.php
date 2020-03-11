<?php
namespace brands\vendor\core\check;

/**
 * Description of DataArray
 *
 * @author aleksey.ga
 */
class DataArray {
    public static $error=""; // расшифровка ошибки
    
    /**
     *  Поиск дубликатов значений в массиве
     * @param array $array_data- 2х мерный массив с значениями
     * @param string $exception_name - исключающе значение для учёта как дубликат, т.е. повторяющие такие значения не считаются дубликатом (пример времменая ID товара)
     * @param array $columNumber - масив названий с номером столбца или false если столбец не неайден
     * @param array $namecolum - название стобца для проверки на дубликаты
     * @return boolean - возвращает false если есть дубликаты + расшифровку в error
     */
    public static function checkDuplicate($array_data, $columNumber, $namecolum,$exception_name=""){
        $maxstring=count($array_data); // высчитываем размер проверяемого массива
        $num_name=$columNumber[$namecolum]; // определяем индекс искомого столбца
        for ($i=0;$i<$maxstring; $i++){
            $duplicate=0;
            foreach ($array_data as $brand){
                $name=$brand[$num_name];
                if($name==$array_data[$i][$num_name]){ //проверка полученного значени на дубликат
                    if($name!=$exception_name){  // проверка на констану
                        $duplicate++;
                        if($duplicate>1){
                            DataArray::$error="<b style='color:#ff0000'> Ошибка!</b> Данные не загружены. Найдены дубликаты в столбце '".$namecolum."'. Дублируется значение: ".$name;
                            return false;
                        }
                    }
                }
            }
        }
        return true;
    }
}

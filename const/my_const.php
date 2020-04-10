<?php
define ("API_KEY", 'AIzaSyA0_qtWDkkCX-9Fup50MkkIywbyM8dWiHo');  // Ваш Google API key
//define ("MAIN_SITE", "http://www.test.importer-tool.com"); // главная страница
define ("MAIN_SITE", "http://test.checktool.pp.ua"); // главная страница
define ("LOCATION_CONTROLLER", '\brands\app\controller\\'); // путь к контролерам
define ("LAYOUT", 'main'); //шаблон по умолчанию
define ("DEFAUL_TITLE", 'Video Searcher'); //Title по умолчанию

define ("LINK_YOUTUBE","https://www.youtube.com/watch?v=");  
define ("LINK_LEXANI_IMG","https://lexani.com/img/vehicles/");

define ("ADMIN", 'admin');   // логин пользователя администратора
define ("DIR_TEMP","../data_temp/"); //папка для загрузки файлов с данными сохранения данных
//define ("DB_BRANDS","../config/db_config_brands.php");
define ("DB_SEARCH_VIDEO","../myconfig/db_config_search_video.php");  // настройки подключения БД

//define ("COLUM_NAME_BRANDS","../config/colum_name_db.php");
define ("NAME_FILE_RESULT","result.csv"); // название файла с результатом поиска
define ("NAME_FILE_COMPARISON","comparison.csv");// название файла результата сравнения 
define ("NAME_FILE_LINK_ERROR","link_error.csv"); //название файла с ошибочными линками

define ("KEYWORD_SEARCH_BLOCK","../myconfig/keyword_search_block.php"); //файл с ключевыми словами для поиска блока с видео
define ("KEYWORD_SEARCH_VIDEO","../myconfig/keyword_search_video.php"); //файл с ключевыми словами для поиска блока с видео
define ("KEYWORD_SEARCH_IMG","../myconfig/keyword_search_img.php"); //файл с ключевыми словами для поиска блока с видео

define ("COLUM_NAME_RESULT","../myconfig/name_column_search_result.php"); //название столбцов для файла с результатом поиска
define ("COLUM_NAME_COMPARISON","../myconfig/name_column_comparison_result.php"); //название столбцов для файла результата сравнения
define ("COLUM_NAME_LINK_ERROR","../myconfig/name_column_link_error.php"); //название столбцов для файла с ошибочными линками
define ("COLUM_NAME_RESULT_FULL","../myconfig/name_column_search_result_full.php"); //название столбцов для файла с результатом поиска

define ("ERROR_TEXT","ОШИБКА! ");
define ("URL_KEY_START",8); // значение для формирование ключадл для DB из входящего линка, кол-во обрезаемых символов с начала строки
define ("URL_KEY_END",58);// значение для формирование ключа для DB из входящего линка, максимальная длина строки



define ("SELECT_TYPEUSER","  <option value='import'>Import</option>
    <option value='tl'>Tl</option>
    <option value='all'>All</option>
    <option value='check'>Check</option>
    <option value='invent'>Inventory</option>
    <option value='manager'>Manager</option>
    <option value='vendor_rel'>Vendor Rel</option>
    <option value='admin'>Admin</option>"
);

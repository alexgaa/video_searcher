<?php
namespace brands\app\models\users;
use \brands\vendor\core\db\DB;
use \brands\app\models\users\UserReadSite;

/**
 * Добавление нового пользователя из формы
 *
 * @author aleksey.ga
 */
class UserReadSite
{
     /**
     *  текст ошибки если она есть, если ошибкт нет то false
     * @var string
     */
    public $error=false;

    /**
     * добавление нового пользователя из формы
     * @return boolean если ошибка false (текст ошибки $error), если всё ок то true
     */
    public function userAddBase()
    {
         $user_data= new UserReadSite();
         $user_data_array=$user_data->checkUserData(); // получаем подготовленные и обработаные данные полученные из формы
         $db= DB::getDb(DB_SEARCH_VIDEO);
         // проверяем на наличие в базе добавляемого пользователя
         $sql="SELECT user_name FROM User WHERE user_name='".$user_data_array['username']."'";
         $result=$db->get($sql);
         if($result){
             $this->error="<b style='color:#ff0000'>Ошибка сохранения!</b> Пользователь с логином: ".$user_data_array['username']." уже есть в базе";
             return false;
         }
         if(!$user_data_array){ // ошибка в исходных данных в форме
            return false;
         }
         else{
            $sql1="REPLACE INTO User (`user_name`, `pass`,`fullname`, `typeuser`,`tl` ,`block`, `type`, `admin_t`, `inventory_t`, `check_t`, `vendor_t`, `tl_import_t`, `import_t`, `manager_t`, `all_t`)";
            $sql2=" VALUES ('".$user_data_array['username']."','".$user_data_array['pass']."','".$user_data_array['fullname']."','".$user_data_array['typeuser']."','".$user_data_array['tl']."', ".$user_data_array['block'].",'".$user_data_array['type']."','".$user_data_array['admin']."','".$user_data_array['inven']."','".$user_data_array['check']."','".$user_data_array['vendor']."','".$user_data_array['tl_imp']."','".$user_data_array['imp']."','".$user_data_array['mand']."','".$user_data_array['all']."')";
            $sql=$sql1.$sql2;
            if(!$db->send($sql)){
                $this->$error="<b style='color:#ff0000'> Ошибка!</b> Загрузка остановленна! Проблема с загрузкой данныйх по пользователю: ".$username;
                return false;
            }
            return true;
         }
     }
     /**
     *  Проверка и подготовка значений для БД, входящие данные из $_POST
     * @return array возвращает подготовленный массив с данными для записи в БД
     * 
     */
    public function checkUserData()
    {
        if($_POST['username']!=''){
            $nameColum['username']=addslashes($_POST['username']);
        }
        else {
            $this->error="Незаполненно поле UserName";
            return false;
        }
        if($_POST['pass']!=''){
            $nameColum['pass']=password_hash($_POST['pass'],PASSWORD_DEFAULT);
        }
        else {
            $this->error="Незаполненно поле Pass";
            return false;
        }
        if($_POST['fullname']!=''){
            $nameColum['fullname']=addslashes($_POST['fullname']);
        }
        else {
            $this->error="Незаполненно поле Full name";
            return false;
        }
        if($_POST['typeuser']!=''){
            $nameColum['typeuser']=addslashes($_POST['typeuser']);
        }
        else {
            $this->error="Незаполненно поле Type user ";
            return false;
        }
        if($_POST['tl']!=''){
            $nameColum['tl']=addslashes($_POST['tl']);
        }
        else {
            $this->error="Незаполненно поле tl";
            return false;
        }
        if($_POST['block']!=''){
            $nameColum['block']=addslashes($_POST['block']);
        }
        else {
            $nameColum['block']=0;      
        }
        if($_POST['type']!=''){
            $nameColum['type']=addslashes($_POST['type']);
        }
        else {
            $this->error="Незаполненно поле type";
            return false;
        }
        if($_POST['admin']!=''){
            $nameColum['admin']=addslashes($_POST['admin']);
        }
        else {
            $nameColum['admin']='n';
        }
        if($_POST['inven']!=''){
            $nameColum['inven']=addslashes($_POST['inven']);
        }
        else {
            $nameColum['inven']='r';
        }
        if($_POST['check']!=''){
            $nameColum['check']=addslashes($_POST['check']);
        }
        else {
            $nameColum['check']='r';
        }
        if($_POST['vendor']!=''){
            $nameColum['vendor']=addslashes($_POST['vendor']);
        }
        else {
            $nameColum['vendor']='r';
        }
        if($_POST['tl_imp']!=''){
            $nameColum['tl_imp']=addslashes($_POST['tl_imp']);
        }
        else {
            $nameColum['tl_imp']='r';
        }
        if($_POST['imp']!=''){
            $nameColum['imp']=addslashes($_POST['imp']);
        }
        else {
            $nameColum['imp']='r';
        }
        if($_POST['mand']!=''){
            $nameColum['mand']=addslashes($_POST['mand']);
        }
        else {
            $nameColum['mand']='r';
        }
        if($_POST['all']!=''){
            $nameColum['all']=addslashes($_POST['all']);
        }
        else {
            $nameColum['all']='r';
        }
        return $nameColum;
    }
}

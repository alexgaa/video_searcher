<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace brands\app\models\users;
use \brands\vendor\core\db\DB;


class SearchUser
{
    /**
     * Поиск в базе пользователей
     * @return array возращаем список пользователей с данными 
     * 
     */
    public function searchBd()
    {
        $search_users=new SearchUser();
        $data=$search_users->requestAnalysis(); // получаем массив с данными и вторую часть SQl запроса
        $db=DB::getDb(DB_SEARCH_VIDEO);
        if($data){
            $sql2=$data['sql']; // извлекаем торую часть SQl запроса из данных
            unset($data['sql']); //удаляем торую часть SQl запроса
            $sql1="SELECT * FROM User WHERE ";
            $sql3=" ORDER BY user_name";
            $sql=$sql1.$sql2.$sql3;
            $result=$db->get($sql,$data);
            return $result; 
        }
        else{
            $sql="SELECT * FROM User ORDER BY user_name";
            $result=$db->get($sql);
            return $result;
        }
    }
    
    /**
     * Анализирует полученные данные из _PPOST и подготовливает для SQL запроса 
     * @return string возращает строку для второй части SQL запроса 
     */
    private function requestAnalysis()
    {
        $counter=0;
        $sql_array=[];
        $data=[];
        if($_POST['username']!=''){
            $data['username']=addslashes($_POST['username']);
            $sql_array['username']=" user_name=:username";
            $counter++;
        }
        if($_POST['fullname']!=''){
            $data['fullname']=addslashes($_POST['fullname']);
            $sql_array['fullname']=" fullname=:fullname";
            $counter++;
        }
        if($_POST['typeuser']!=''){
            $data['typeuser']=addslashes($_POST['typeuser']);
            $sql_array['typeuser']=" typeuser=:typeuser";
            $counter++;
        }
        if($_POST['tl']!=''){
            $data['tl']=addslashes($_POST['tl']);
            $sql_array['tl']=" tl=:tl";
            $counter++;
        }
        if($_POST['block1']!=''){
            if($_POST['block1']=='n'){
                $data['block']=5;
                $sql_array['block']=" block > :block";
            }else{
                $data['block']=5;
                $sql_array['block']=" block < :block";
            }
            $counter++;
        }
        if($_POST['type']!=''){
            $data['type']=addslashes($_POST['type']);
            $sql_array['type']=" type=:type";
            $counter++;
        }
        if($_POST['admin']!=''){
            $data['admin']=addslashes($_POST['admin']);
            $sql_array['admin']=" admin_t=:admin";
            $counter++;
        }
        if($_POST['inven']!=''){
            $data['inven']=addslashes($_POST['inven']);
            $sql_array['inven']=" inventory_t=:inven";
            $counter++;
        }
        if($_POST['check']!=''){
            $data['check']=addslashes($_POST['check']);
            $sql_array['check']=" check_t=:check";
            $counter++;
        }
        if($_POST['vendor']!=''){
            $data['vendor']=addslashes($_POST['vendor']);
            $sql_array['vendor']=" vendor_t=:vendor";
            $counter++;
        }
        if($_POST['tl_imp']!=''){
            $data['tl_imp']=addslashes($_POST['tl_imp']);
            $sql_array['tl_imp']=" tl_import_t=:tl_imp";
            $counter++;
        }
        if($_POST['imp']!=''){
            $data['imp']=addslashes($_POST['imp']);
            $sql_array['imp']=" import_t=:imp";
            $counter++;
        }
        if($_POST['mand']!=''){
            $data['mand']=addslashes($_POST['mand']);
            $sql_array['mand']=" manager_t=:mand";
            $counter++;
        }
        if($_POST['all']!=''){
            $data['all']=addslashes($_POST['all']);
            $sql_array['all']=" all_t=:all";
            $counter++;
        }
        $sql="";
        if($counter){
            $i=0;
            foreach($sql_array as $temp){ // собираем SQL строку
                if($i){
                    $sql=$sql.' AND '.$temp;
                }
                else{
                    $sql=$temp;
                }
                $i++;
            }
            $data['sql']=$sql; // добавляем SQL строку в массив с данными
            return $data;
        }
        return false;
    }
    
    /**
     * Проверяет есть ли пользователь в базе и возращает его ID если находит
     * @param string $user логин пользователя
     * @return int возвращает id пользователя если не найтен False
     */
    
    public static function checkInBd($user)
    {
        $db=DB::getDb(DB_SEARCH_VIDEO);
        $arr['user_name']=$user;
        $sql="SELECT * FROM User WHERE user_name=:user_name";
        $result=$db->get($sql, $arr);
        if(isset($result[0]['id'])){
            return $result[0]['id'];
        }
        else{
            return false;
        }
      
    }
}
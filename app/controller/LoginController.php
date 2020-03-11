<?php
if ( !isset($_SESSION) && !session_id() ) {
    session_start();
}

use \brands\app\models\CheckUser;

require_once '../vendor/autoload.php';
$error_log="";
if(isset($_POST['submit'])){
    $user=CheckUser::check($_POST['login'],$_POST['pass']);

    if($user){
        $_SESSION['user']=password_hash($_POST['login'], PASSWORD_DEFAULT); //$_POST['login'];
        $_SESSION['dir_user']=filter_input(INPUT_POST,'login');// $_POST['login'];
        $_SESSION['typeuser']=$user[0]['typeuser'];
        $_SESSION['check_t']=$user[0]['check_t'];
        $_SESSION['inventory_t']=$user[0]['inventory_t'];
        $_SESSION['vendor_t']=$user[0]['vendor_t'];
        $_SESSION['tl_import_t']=$user[0]['tl_import_t'];
        $_SESSION['import_t']=$user[0]['import_t'];
        $_SESSION['manager_t']=$user[0]['manager_t'];
        $_SESSION['all_t']=$user[0]['all_t'];
        header ("Location: ".MAIN_SITE);           
    }
    $error_log=CheckUser::$error;
}
require '../app/views/login.php';
?>

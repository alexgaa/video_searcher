<?php
namespace App\Controller;

use App\Entity\UserData;
use App\Entity\VideoData;
use App\Models\content\Analysis;
use App\Models\content\FinalAnalysis;
use App\Models\db\DbWork;
//use App\Models\general\StartSearch;
use App\Models\general\UrlCheck;
use App\Models\general\UserCheckData;
//use App\Models\main\InputData;
use App\Models\result\SaveResult;
use App\Models\youtube\YoutubeWork;
use App\Vendor\file\FileWork;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class MainController extends AbstractController
{
    /*
     * информация об ошибке
     */
    public $error='';
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        $actual_user=$this->getUser()->getUsername(); //получаем текущего пользователя
        $session = new Session();
        $session->set('dir_user', $actual_user);
        return $this->render('main/index.html.twig', [
            'error'=>'',
            'result'=>'',
        ]);
    }
    /**
     * Получение входящих данный от пользоватея и их обработка
     * @Route("/link-user", name="link_user")
     */
    public function linkUser(Request $request)
    {
        $result="";
        $param=$request->request->all();
        if($param){ //получаем линк для поиска видео
            $result=$this->lexani($param['linkuser']);//поиск видео на сайте Lexani
        }
        return $this->render('main/index.html.twig', [
            'error'=>$this->error,
            'result'=>$result,
        ]);
    }

    /**
     * Поиск видео на сайте https://lexani.com/videos
     * @return array возращает массив данных для вывода в шаблон
     */
    public function lexani(string $linkUser)
    {
        $keyword= require_once KEYWORD_SEARCH_BLOCK; //ключевые слова для поиска блока с видео
        $result="";
        $summaryData=[];
        $inputLink= $this->saveInputData($linkUser); //валидируем и сохраняем полученный линк и данные о пользователе в DB
        if($inputLink){
            ini_set("max_execution_time", "380"); //увеличиваем время выполнения скрипта
            //поиск видео на сайте
            $content = file_get_contents($inputLink);//получам содержимое сайта в строку
            //$content = file_get_contents(DIR_TEMP.'temp_site_lexani.html');// DIR_TEMP получам содержимое из файла сайта в строку
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
            $result=$this->error;
        }
        $arr=compact('result','inputLink','summaryData'); //пакуем результаты в массив
        return $arr;
    }

    /**
    * Проверка линка и сохраненеи информации в базу линков
    * @return string / boolean  возращает массив или false в случае ошибки
     */
    public function saveInputData($linkUser){
        //валидация входящего линка
        $linkInput=UrlCheck::inputUrl($linkUser);
        if(!$linkInput){
            $this->error=ERROR_TEXT."Введённый линк '".$linkUser."' - Битый ";
            return false;
        }
        $actual_user=$this->getUser()->getUsername(); //получаем текущего пользователя
        $session = new Session();
        $session->set('dir_user', $actual_user);
        $ip=UserCheckData::ip(); //получаем IP пользователя
        $browser=UserCheckData::browser(); //получаем данные браузера
        $date = new \DateTime(); //получаем текущую дату
        $repository=$this->getDoctrine()->getRepository(UserData::class);
        $user_data=$repository->findOneBy(['name_user'=>$actual_user]); // проеверяем естьли текущиё пользователь в базе линков
        if(!$user_data){ // если пользователя нет в базе леинков добавляем
            $user_data=new UserData();
            $user_data->setNameUser($actual_user);
        }
        $user_data->setUserIp($ip); // добавляем новый IP
        $user_data->setBrowser($browser); // Добавляем новый инф браузера
        $user_data->setDate($date);// Добавляем дату
        $entity= $this->getDoctrine()->getManager();
        $entity->persist($user_data);
        $entity->flush();
        return $linkInput;
    }
    /**
     * @Route("/file-result", name="file_result")
     * выдача файла с результатом
     */
    public function fileResult(){
        $dir_user=$this->getUser()->getUsername(); //получаем название папки для пользователя
        $nameFile=DIR_TEMP.$dir_user.'/'.NAME_FILE_RESULT;
        if(!FileWork::fileUploadUser($nameFile)){
            $result=ERROR_TEXT."Нет файла для выгрузки.";
            return $this->render('main/index.html.twig', [
                'result'=>'',
                'error'=>$result
            ]);
        }
    }
    /**
     * @Route("/file-сomparison", name="file_сomparison")
     * выдача файла с сравнением линков
     */
    public function fileComparison(){
        $dir_user=$this->getUser()->getUsername(); //получаем название папки для пользователя
        $nameFile=DIR_TEMP.$dir_user.'/'.NAME_FILE_COMPARISON;
        if(!FileWork::fileUploadUser($nameFile)){
            $result=ERROR_TEXT."Нет файла для выгрузки.";
            return $this->render('main/index.html.twig', [
                'result'=>'',
                'error'=>$result
            ]);
        }
    }
    /**
     * @Route("file-error",name="file_error")
     * выдача файла с ошибками
     */
    public function fileError(){
        $dir_user=$this->getUser()->getUsername(); //получаем название папки для пользователя
        $nameFile=DIR_TEMP.$dir_user.'/'.NAME_FILE_LINK_ERROR;
        if(!FileWork::fileUploadUser($nameFile)){
            $result=ERROR_TEXT."Нет файла для выгрузки.";
            return $this->render('main/index.html.twig', [
                'result'=>'',
                'error'=>$result
            ]);
        }
    }
    /**
     * @Route("read",name="read")
     * Выводим все записи из базы линков в таблицу
     */
    public function read()
    {
        $all=0;
        $error='';
        $data_array=DbWork::selectAllData(); //получаем данные из базы
        $arrKeyDel=[0=>'id', 1=>'id_input_url']; // столбцы для удаления из массива данных
        $data_array=SaveResult::delColumn($data_array,$arrKeyDel); //удаляем лишние столбцы
        if(!SaveResult::saveResultFile($data_array, NAME_FILE_RESULT, COLUM_NAME_RESULT_FULL)){// сохраняем в файл
            $error="Ошибка сохранения в файл!";
        }
        if($data_array){
            $all=count($data_array);
        }
        return $this->render('main/read.html.twig', [
            'result'=>$data_array,
            'all'=>$all,
            'error'=>$error
        ]);
    }

    /**
     * удаляем записи из БД
     * @Route("edit", name="edit")
     */
    public function edit(Request $request)
    {
        $all=0;
        $param=$request->request->all();
        if(isset($param['delete'])){
            $i=0;
            foreach ($param['delete'] as $temp){
                $entityManager=$this->getDoctrine()->getManager();
                $videoData=$entityManager->getRepository(VideoData::class)->find($param['id_url'][$i]);
                $entityManager->remove($videoData);
                $entityManager->flush();
                $i++;
            }
        }
        $data_array=DbWork::selectAllData(); //получаем данные из базы
        if($data_array){
            $all=count($data_array);
        }
        return $this->render('main/edit.html.twig', [
            'result'=>$data_array,
            'all'=>$all,
            'error'=>''
        ]);
    }
}

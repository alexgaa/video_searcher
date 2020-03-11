    <h4 class="text-secondary">Результат поиска видео на сайте "<?=$inputLink?>":</h4>
<form  action="/main/file-unload" method="post" enctype="multipart/form-data">
    <p class="text-secondary">Всего найдено <b><?=$summaryData['all']?></b> линков на видео. 
        <?php if($summaryData['all']){?>
        <a href='/main/file-result' name='a_result_file' class="btn text-primary shadow-none">Скачать</a>  <?php } ?></p>
    <?php 
        if($summaryData['old'] or $summaryData['none'] or $summaryData['new']){
    ?>   
   <p class="text-secondary">Результат анализа линков на видео: <a href="/main/file-comparison" class="btn text-primary shadow-none">Скачать</a><br>
   Новые - <b><?=$summaryData['new']?></b><br>
   Старые - <b><?=$summaryData['old']?></b><br>
   Удалены с сайта - <b><?=$summaryData['none']?></b><br>
   </p>
    <?php }
        if($summaryData['error']){
    ?>   
    <p class="text-secondary">Линки с ошибками <b><?=$summaryData['error']?></b>  <a href="/main/file-error" class="btn text-primary shadow-none">Скачать</a></p>
    <?php }?>
    <a href='/main/' class="btn btn-primary shadow-none text-white">Очистить</a>
</form>
<br>
<p><?=$result?></p>

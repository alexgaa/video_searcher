<b><p id='result_del'></p></b>
<div id="block_del">
<p><?php if ($data_array) {?>
    <b>В базе найдено <?=count($data_array)?> записей:</b> 
    <a id="submit_save_video_del" class="btn btn-primary shadow-none text-white">Сохранить изменения</a></p>

<form id="tabl2" action="/main/delete" method="post" enctype="multipart/form-data">
    <table class="table table-hover table-bordered" style="margin-bottom: 0">
        <thead class="thead-dark thead_calc">
            <tr>
                <th style="text-align:center" scope="col"><span class="ps_color">Подтвердите удаление</span></th>
                                
                <th style="text-align:center"scope="col">URL</th>
                <th style="text-align:center" scope="col">User</th>
                <th style="text-align:center" scope="col">Url Video</th>
                <th style="text-align:center" scope="col">Image from the site</th>
                <th style="text-align:center" scope="col">Title</th>
                <th style="text-align:center" scope="col">Description</th>
                <th style="text-align:center" scope="col">Image youtube</th>
                <th style="text-align:center" scope="col">valid</th>
                <th style="text-align:center" scope="col">Date</th>
                
            </tr>
        </thead>
        <tbody>
            <?php $temp_id=0; foreach ($data_array as $temp){?>
                <tr class='result'>
                    <td>
                        <div class="form-check has-danger">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" name='delete[<?=$temp_id?>]' id='delete[<?=$temp_id?>]'>
                              <span class="ps_color">Удалить</span>
                            </label>
                        </div>
                    </td>    
                    <input type="hidden" name='id_url[<?=$temp_id?>]' value="<?=$temp['id']?>">
                    <td style="word-wrap:break-word"><a href="<?=$temp['url']?>"><?=$temp['url']?></a></td>
                    <td style="word-wrap:break-word"><?=$temp['name']?></td>
                    <td style="word-wrap:break-word"><a href="<?=LINK_YOUTUBE.$temp['id_video']?>"><?=LINK_YOUTUBE.$temp['id_video']?></a></td>
                    <td style="word-wrap:break-word"><a href="<?=LINK_LEXANI_IMG.$temp['img_site']?>"><img src="<?=LINK_LEXANI_IMG.$temp['img_site']?>" width="100%"></a></td>
                    <td style="word-wrap:break-word" title='<?=$temp['title']?>'><?=mb_strimwidth($temp['title'], 0, 50, "...");?></td>
                    <td style="word-wrap:break-word" title='<?=$temp['description']?>'><?=mb_strimwidth($temp['description'], 0, 50, "...");?></td>
                    <td style="word-wrap:break-word"><a href="<?=$temp['img_youtube']?>"><img src="<?=$temp['img_youtube']?>" width="100%"></a></td>
                    <td style="word-wrap:break-word"><?=$temp['valid']?></td>
                    <td style="word-wrap:break-word"><?=$temp['date']?></td>    
                        
                        
                        
                </tr>
            <?php $temp_id++;}?>    
        </tbody>
    </table>
    <br>
    <!--<button type="submit" name='delete' class="btn btn-primary">Сохранить</button>-->

    <br>
    <p id='error_del'></p>
    
</form>
<?php } else { ?> <p><b>Нет данных!</p> <b><?php }?>
</div>

<p><?php if ($data_array) {?>
<b>В базе найдено <?=count($data_array)?> записей:</b>
        <a href='/main/file-result' name='a_result_file' class="btn text-primary shadow-none">Сохранить в файл</a>
</p>
  <table class="table table-bordered table-hover" style="margin-bottom: 0">
            <thead class="thead-dark thead_calc">
                <tr>
                    <th style="text-align:center" scope="col">URL</th>
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
                <?php 
                    foreach ($data_array as $temp){?>
                        <tr>
                            <td style="word-wrap:break-word"><a href="<?=$temp['url']?>"><?=$temp['url']?></a></td>
                            <td style="word-wrap:break-word"><?=$temp['name']?></td>
                            <td style="word-wrap:break-word"><a href="<?=LINK_YOUTUBE.$temp['id_video']?>"><?=LINK_YOUTUBE.$temp['id_video']?></a></td>
                            <td style="word-wrap:break-word"><a href="<?=LINK_LEXANI_IMG.$temp['img_site']?>"><img src="<?=LINK_LEXANI_IMG.$temp['img_site']?>" width="100%"></a></td>
                            <td style="word-wrap:break-word" title="<?=$temp['title']?>"><?=mb_strimwidth($temp['title'], 0, 50, "...");?></td>
                            <td style="word-wrap:break-word" title="<?=$temp['description']?>"><?=mb_strimwidth($temp['description'], 0, 50, "...");?></td>
                            <td style="word-wrap:break-word"><a href="<?=$temp['img_youtube']?>"><img src="<?=$temp['img_youtube']?>" width="100%"></a></td>
                            <td style="word-wrap:break-word" class="text-danger"><?=$temp['valid']?></td>
                            <td style="word-wrap:break-word"><?=$temp['date']?></td>
                        </tr>
                 <?php }?>   
            </tbody>
        </table> 
<?php } else { ?> <p><b>Нет данных!</p> <b><?php }?>


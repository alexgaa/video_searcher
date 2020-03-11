<h2>Результат выборки:</h2>
<form id="tabl2" action="" method="post" enctype="multipart/form-data">
    <table class="table table-hover table-bordered" style="margin-bottom: 0">
        <thead class="thead-dark">
            <tr>
                <th scope="col"><span class="ps_color">Подтвердите удаление</span></th>
                                
                <th scope="col">URL</th>
                <th scope="col">User</th>
                <th scope="col">Url Video</th>
                <th scope="col">Image from the site</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Imgage youtube</th>
                <th scope="col">valid</th>
                <th scope="col">Date</th>
                
            </tr>
        </thead>
        <tbody>
            <?php $temp_id=0; foreach ($data_array as $temp){?>
                <tr class='result'>
                    <td>
                        <div class="form-check has-danger">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" name='delete[<?=$temp_id?>]' id='delete[<?=$temp_id?>]' value="delete">
                              <span class="ps_color">Удалить</span>
                            </label>
                        </div>
                    </td>    
                    <input type="hidden" name='id_url[<?=$temp_id?>]' value="<?=$temp['id']?>">
                    <td style="word-wrap:break-word"><?=$temp['url']?></td>
                        <td style="word-wrap:break-word"><?=$temp['name']?></td>
                        <td style="word-wrap:break-word"><?=LINK_YOUTUBE.$temp['id_video']?></td>
                        <td style="word-wrap:break-word"><?=LINK_LEXANI_IMG.$temp['img_site']?></td>
                        <td style="word-wrap:break-word"><?=$temp['title']?></td>
                        <td style="word-wrap:break-word"><?=$temp['description']?></td>
                        <td style="word-wrap:break-word"><?=$temp['img_youtube']?></td>
                        <td style="word-wrap:break-word"><?=$temp['valid']?></td>
                        <td style="word-wrap:break-word"><?=$temp['date']?></td>
                </tr>
            <?php $temp_id++;}?>    
        </tbody>
    </table>
    <br>
    <a id="submit_save_brand_del" class="btn btn-primary shadow-none text-white">Сохранить</a>
    <br>
    <p id='error_del'></p>
</form>
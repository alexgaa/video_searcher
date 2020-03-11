<form action="/main/link-user" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <br>
        <label for="linkUser"><h4><b>Введите адрес страницы для поиска на ней видео:</b></h4></label>
        <input type="text" class="form-control" id="linkUser" aria-describedby="linkUserHelp" name="linkUser" readonly required value="https://lexani.com/videos" placeholder="https://example.com">
        <small id="linkUserHelp" class="form-text text-muted">Страница может содержать видео формата youtube, vimeo.</small>
     </div>
     <button id='submit_search_video' type="submit" class="btn btn-primary">Поиск</button>
</form>
<br>
<b><p class="text-success" id='info_message'></p></b>
<p><?=$result?></p>



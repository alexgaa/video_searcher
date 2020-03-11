            <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleFormControlFile1">Выберите файл с даннми пользователей:<span class="ps_color">*</span></label>
                 <input type="file" class="form-control-file" id="exampleFormControlFile1" name="fileusers">
            </div>
            <button type="submit" class="btn btn-primary">Загрузить</button>
            <p><span class="ps_color">*</span> <b>Обязательные столбцы: User, Name, pass, full name, type user, tl, block, Type, Admin, Inven, Check, Vendor, TL_Imp, Imp, Mand, All</b></p>
        </form>
        <p id="p_result"><?php if(isset($result)){ $result; }?></p>


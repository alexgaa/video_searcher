        <form action="/users/delete" method="post" enctype="multipart/form-data">
        <?php include "../app/views/Users/search_menu.php"?>
        <button type="submit" name="search_user_delete" class="btn btn-primary">Найти</button>
        </form>
        <p id="p_result"><?php if(isset($result)){ $result; }?></p>
        <?php if(isset($result_array)){ ?>
        <form id="tabl2" action="/users/search" method="post" enctype="multipart/form-data">
            <table class="table table-hover table-bordered" style="margin-bottom: 0">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col"><span class="ps_color">Delete</span></th>
                        <th scope="col">UserID</th>
                        <th scope="col">UserName</th>
                        <th scope="col">Full Name </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i=0;
                    foreach ($result_array as $data){?>
                    <tr class='result' >
                        <td>
                            <div class="form-check has-danger">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input" name='delete[<?=$i?>]' id='delete[<?=$i?>]' value="delete">
                                  <span class="ps_color">Подтвердите удаление</span>
                                </label>
                            </div>
                        </td>    
                        <td><input class='form-control form-control-sm' name='id[<?=$i?>]' type='text' value='<?=$data['id']?>' readonly></td>
                        <td><input class='form-control form-control-sm' name='username[<?=$i?>]' type='text'  value='<?=$data['user_name']?>' readonly></td>
                        <td><input class='form-control form-control-sm' name='fullname[<?=$i?>]' type='text' value='<?=$data['fullname']?>' readonly></td>
                    </tr>
                    <?php $i++;}?>
                </tbody>
            </table>
            <br>
            <a id="submit_save_del" class="btn btn-primary shadow-none text-white">Сохранить</a>
            <a id="submit_clear_search_users" class="btn btn-primary shadow-none text-white">Очистить</a>
            <!--<button type="submit" name="clear_search_users" class="btn btn-primary">Очисть</button>-->
            <!--<button type="submit" name="edit_user" class="btn btn-primary">Сохранить</button>-->
        </form>
        <p id='error_save_user'></p>
        <p id='error_del'></p>
        <?php }
        ?>


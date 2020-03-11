        <form action="/users/edit" method="post" enctype="multipart/form-data">
        <?php include "../app/views/Users/search_menu.php"?>
        <button type="submit" name="search_user_edit" class="btn btn-primary">Найти</button>
        </form>
        <p id="p_result"><?php if(isset($result)){ $result; }?></p>
        <?php if(isset($result_array)){ ?>
        <form id="tabl2" action="/users/search" method="post" enctype="multipart/form-data">
            <table class="table table-hover table-bordered" style="margin-bottom: 0">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">UserID</th>
                        <th scope="col">UserName</th>
                        <th scope="col">Passsword </th>
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
                                  <input type="checkbox" class="form-check-input" name='delete[<?=$i?>]' value="delete">
                                  <span class="ps_color">Выдать новый пароль</span>
                                </label>
                            </div>
                        </td>
                        <td><input class='form-control form-control-sm' name='id[<?=$i?>]' type='text' value='<?=$data['id']?>' readonly></td>
                        <td><input class='form-control form-control-sm' name='username[<?=$i?>]' type='text'  value='<?=$data['user_name']?>' readonly></td>
                        <td><input class='form-control form-control-sm' name='pass[<?=$i?>]' type='text' value='<?=$data['pass']?>'></td>
                    </tr>
                    <?php $i++;}?>
                </tbody>
            </table>
            <br>
            <a id="submit_save_pass" class="btn btn-primary shadow-none text-white">Save</a>
            <a id="submit_clear_search_users" class="btn btn-primary shadow-none text-white">Clear</a>
            <!--<button type="submit" name="clear_search_users" class="btn btn-primary">Очисть</button>-->
            <!--<button type="submit" name="edit_user" class="btn btn-primary">Сохранить</button>-->
        </form>
        <p id='error_save_user'></p>
        <p id='error_del'></p>
        <?php }
        ?>

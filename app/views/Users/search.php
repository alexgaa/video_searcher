       <form action="/users/search" method="post" enctype="multipart/form-data">
        <?php include "../app/views/Users/search_menu.php"?>    
        <button type="submit" name="search_user" class="btn btn-primary">Найти</button>
        </form>
        <p id="p_result"><?php if(isset($result)){ $result; }?></p>
        <?php if(isset($result_array)){ ?>
        <form id="tabl2" action="/users/search" method="post" enctype="multipart/form-data">
            <table class="table table-hover table-bordered" style="margin-bottom: 0">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">UserID</th>
                        <th scope="col">UserName</th>
                        <th scope="col">Full name </th>
                        <th scope="col">Type user </th>
                        <th scope="col">tl </th>
                        <th scope="col">Block</th>
                        <th scope="col">Type </th>
                        <th scope="col">Admin</th>
                        <th scope="col">Inven</th>
                        <th scope="col">Check</th>
                        <th scope="col">Vendor</th>
                        <th scope="col">TL_Imp</th>
                        <th scope="col">Imp</th>
                        <th scope="col">Mand</th>
                        <th scope="col">All</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i=0;
                    foreach ($result_array as $data){?>
                    <tr class='result' >
                        <td><input class='form-control form-control-sm' name='id[<?=$i?>]' type='text' value='<?=$data['id']?>' readonly></td>
                        <td><input class='form-control form-control-sm' name='username[<?=$i?>]' type='text'  value='<?=$data['user_name']?>'></td>
                        <td><input class='form-control form-control-sm' name='fullname[<?=$i?>]' type='text' value='<?=$data['fullname']?>'></td>
                        <td>
                        <select class='form-control form-control-sm' name='typeuser[<?=$i?>]'>
                            <option selected value='<?=$data['typeuser']?>'><?=$data['typeuser']?></option>
                            <?=SELECT_TYPEUSER?>
                            </select>
                        </td>
                        <td><input class='form-control form-control-sm' name='tl[<?=$i?>]'  type='text' value='<?=$data['tl']?>'></td>
                        <td>
                        <select class='form-control form-control-sm' name='block[<?=$i?>]'>
                                <option selected value='<?=$data['block']?>'><?=$data['block']?></option>
                                <option value="10">Заблокировать</option>
                                <option value="0">Открыть</option>
                        </select>
                        </td>
                        <td>
                        <select class='form-control form-control-sm' name='type[<?=$i?>]'>
                                <option selected value='<?=$data['type']?>'><?=$data['type']?></option>
                                <option value="Import">Import</option>
                                <option value="TL_Import">TL Import</option>
                                <option value="Inventory">Inventory</option>
                                <option value="Check">Check</option>
                                <option value="VendorRe">Vendor Re</option>
                                <option value="All">ALL</option>
                        </select>
                        </td>
                        <td>
                            <select class='form-control form-control-sm' name='admin[<?=$i?>]'>
                                <option selected value='<?=$data['admin_t']?>'>
                                    <?php 
                                    if($data['admin_t']=='y')
                                        { echo "Редактирование";}
                                    else{ echo "Чтение";} 
                                    ?></option>
                                <option value="n">Чтение</option>
                                <option value="y">Редактирование</option>
                            </select>
                        </td>
                        <td>
                            <select class='form-control form-control-sm' name='inven[<?=$i?>]'>
                                <option selected value='<?=$data['inventory_t']?>'>
                                    <?php 
                                    if($data['inventory_t']=='w')
                                        { echo "Редактирование";}
                                    else{ echo "Чтение";} 
                                    ?></option>
                                <option value="r">Чтение</option>
                                <option value="w">Редактирование</option>
                            </select>
                        </td>
                        <td>
                            <select class='form-control form-control-sm' name='check[<?=$i?>]'>
                                <option selected value='<?=$data['check_t']?>'>
                                    <?php 
                                    if($data['check_t']=='w')
                                        { echo "Редактирование";}
                                    else{ echo "Чтение";} 
                                    ?></option>
                                <option value="r">Чтение</option>
                                <option value="w">Редактирование</option>
                            </select>
                        </td>
                        <td>
                            <select class='form-control form-control-sm' name='vendor[<?=$i?>]'>
                                <option selected value='<?=$data['vendor_t']?>'>
                                    <?php 
                                    if($data['vendor_t']=='w')
                                        { echo "Редактирование";}
                                    else{ echo "Чтение";} 
                                    ?></option>
                                <option value="r">Чтение</option>
                                <option value="w">Редактирование</option>
                            </select>
                        </td>
                        <td>
                            <select class='form-control form-control-sm' name='tl_imp[<?=$i?>]'>
                                <option selected value='<?=$data['tl_import_t']?>'>
                                    <?php 
                                    if($data['tl_import_t']=='w')
                                        { echo "Редактирование";}
                                    else{ echo "Чтение";} 
                                    ?></option>
                                <option value="r">Чтение</option>
                                <option value="w">Редактирование</option>
                            </select>
                        </td>
                        <td>
                            <select class='form-control form-control-sm' name='imp[<?=$i?>]'>
                                <option selected value='<?=$data['import_t']?>'>
                                    <?php 
                                    if($data['import_t']=='w')
                                        { echo "Редактирование";}
                                    else{ echo "Чтение";} 
                                    ?></option>
                                <option value="r">Чтение</option>
                                <option value="w">Редактирование</option>
                            </select>
                        </td>
                        <td><select class='form-control form-control-sm' name='mand[<?=$i?>]'>
                                <option selected value='<?=$data['manager_t']?>'>
                                    <?php 
                                    if($data['manager_t']=='w')
                                        { echo "Редактирование";}
                                    else{ echo "Чтение";} 
                                    ?></option>

                                <option value="r">Чтение</option>
                                <option value="w">Редактирование</option>
                            </select>
                        </td>
                        <td><select class='form-control form-control-sm' name='all[<?=$i?>]'>
                                <option selected value='<?=$data['all_t']?>'>
                                    <?php 
                                    if($data['all_t']=='w')
                                        { echo "Редактирование";}
                                    else{ echo "Чтение";} 
                                    ?></option>
                                <option value="r">Чтение</option>
                                <option value="w">Редактирование</option>
                            </select>
                        </td>
                    </tr>
                    <?php $i++;}?>
                </tbody>
                
            </table>
            <br>
            <a id="submit_save_user" class="btn btn-primary shadow-none text-white">Save</a>
            <a id="submit_clear_search_users" class="btn btn-primary shadow-none text-white">Clear</a>
        </form>
        <p id='error_save_user'></p>
        <?php }
        ?>

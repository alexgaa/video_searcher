        <form action="/users/new-user" method="post" enctype="multipart/form-data">
        <table class="table table-hover table-bordered" style="margin-bottom: 0">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">UserName<span class="ps_color">*</span></th>
                    <th scope="col">Pass <span class="ps_color">*</span></th>
                    <th scope="col">Full name <span class="ps_color">*</span></th>
                    <th scope="col">Type user <span class="ps_color">*</span></th>
                    <th scope="col">tl <span class="ps_color">*</span></th>
                    <th scope="col">Block</th>
                    <th scope="col">Type <span class="ps_color">*</span></th>
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
                <tr>
                    <td><input class='form-control form-control-sm' name='username' type='text' required placeholder="Логин"></td>
                    <td><input class='form-control form-control-sm' name='pass' type='text' required placeholder="Пароль"></td>
                    <td><input class='form-control form-control-sm' name='fullname' type='text' required placeholder="Фамилия Имя"></td>
                    <td>
                    <select class='form-control form-control-sm' name='typeuser'>
                            <option selected value="import">Import</option>
                            <option value="tl">Tl</option>
                            <option value="all">All</option>
                            <option value="check">Check</option>
                            <option value="invent">Inventory</option>
                            <option value="manager">Manager</option>
                            <option value="vendor_rel">Vendor Rel</option>
                            <option value="admin">Admin</option>
                        </select>
                    </td>
                    <td><input class='form-control form-control-sm' name='tl'  type='text' required placeholder="Кто TL"></td>
                    <td>
                    <select class='form-control form-control-sm' name='block'>
                            <option selected value=""></option>
                            <option value="10">Заблокировать</option>
                    </select>
                    </td>
                    <td>
                    <select class='form-control form-control-sm' name='type'>
                            <option selected value="Import">Import</option>
                            <option value="TL_Import">TL Import</option>
                            <option value="Inventory">Inventory</option>
                            <option value="Check">Check</option>
                            <option value="VendorRe">Vendor Re</option>
                            <option value="All">ALL</option>
                    </select>
                    </td>
                    <td>
                        <select class='form-control form-control-sm' name='admin'>
                            <option selected value="n">Чтение</option>
                            <option value="y">Редактирование</option>
                        </select>
                    </td>
                    <td>
                        <select class='form-control form-control-sm' name='inven'>
                            <option selected value="r">Чтение</option>
                            <option value="w">Редактирование</option>
                        </select>
                    </td>
                    <td>
                        <select class='form-control form-control-sm' name='check'>
                            <option selected value="r">Чтение</option>
                            <option value="w">Редактирование</option>
                        </select>
                    </td>
                    <td>
                        <select class='form-control form-control-sm' name='vendor'>
                            <option selected value="r">Чтение</option>
                            <option value="w">Редактирование</option>
                        </select>
                    </td>
                    <td>
                        <select class='form-control form-control-sm' name='tl_imp'>
                            <option selected value="r">Чтение</option>
                            <option value="w">Редактирование</option>
                        </select>
                    </td>
                    <td>
                        <select class='form-control form-control-sm' name='imp'>
                            <option selected value="r">Чтение</option>
                            <option value="w">Редактирование</option>
                        </select>
                    </td>
                    <td><select class='form-control form-control-sm' name='mand'>
                            <option selected value="r">Чтение</option>
                            <option value="w">Редактирование</option>
                        </select>
                    </td>
                    <td><select class='form-control form-control-sm' name='all'>
                            <option selected value="r">Чтение</option>
                            <option value="w">Редактирование</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <button type="submit" name="add_new_user" class="btn btn-primary">Добавить</button>
        </form>
        <p><span class="ps_color">*</span> - поля обязательные к заполнению.</p>
        <p id="p_result"><?php if(isset($result)){ $result; }?></p>

        <table class="table table-hover table-bordered" style="margin-bottom: 0">
            <thead class="thead-dark">
                <tr>
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
                <tr>
                    <td><input class='form-control form-control-sm' name='username' type='text'  placeholder="Логин"></td>
                    <td><input class='form-control form-control-sm' name='fullname' type='text' placeholder="Фамилия Имя"></td>
                    <td>
                    <select class='form-control form-control-sm' name='typeuser'>
                        <option selected value=''></option>
                        <?=SELECT_TYPEUSER?>
                        </select>
                    </td>
                    <td><input class='form-control form-control-sm' name='tl'  type='text' placeholder="Кто TL"></td>
                    <td>
                    <select class='form-control form-control-sm' name='block1'>
                            <option selected value=""></option>
                            <option value="n">Заблокированые</option>
                            <option value="y">Рабочиие</option>
                    </select>
                    </td>
                    <td>
                    <select class='form-control form-control-sm' name='type'>
                            <option selected value=""></option>
                            <option value="Import">Import</option>
                            <option value="TL_Import">TL Import</option>
                            <option value="Inventory">Inventory</option>
                            <option value="Check">Check</option>
                            <option value="VendorRe">Vendor Re</option>
                            <option value="All">ALL</option>
                    </select>
                    </td>
                    <td>
                        <select class='form-control form-control-sm' name='admin'>
                            <option selected value=""></option>
                            <option value="n">Чтение</option>
                            <option value="y">Редактирование</option>
                        </select>
                    </td>
                    <td>
                        <select class='form-control form-control-sm' name='inven'>
                            <option selected value=""></option>
                            <option value="r">Чтение</option>
                            <option value="w">Редактирование</option>
                        </select>
                    </td>
                    <td>
                        <select class='form-control form-control-sm' name='check'>
                            <option selected value=""></option>
                            <option value="r">Чтение</option>
                            <option value="w">Редактирование</option>
                        </select>
                    </td>
                    <td>
                        <select class='form-control form-control-sm' name='vendor'>
                            <option selected value=""></option>
                            <option value="r">Чтение</option>
                            <option value="w">Редактирование</option>
                        </select>
                    </td>
                    <td>
                        <select class='form-control form-control-sm' name='tl_imp'>
                            <option selected value=""></option>
                            <option value="r">Чтение</option>
                            <option value="w">Редактирование</option>
                        </select>
                    </td>
                    <td>
                        <select class='form-control form-control-sm' name='imp'>
                            <option selected value=""></option>
                            <option value="r">Чтение</option>
                            <option value="w">Редактирование</option>
                        </select>
                    </td>
                    <td><select class='form-control form-control-sm' name='mand'>
                            <option selected value=""></option>
                            <option value="r">Чтение</option>
                            <option value="w">Редактирование</option>
                        </select>
                    </td>
                    <td><select class='form-control form-control-sm' name='all'>
                            <option selected value=""></option>
                            <option value="r">Чтение</option>
                            <option value="w">Редактирование</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>


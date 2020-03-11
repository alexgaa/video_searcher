        <table class="table table-bordered table-hover" style="margin-bottom: 0">
            <thead class="thead-dark thead_calc">
                <tr>
                    <th scope="col">UserID</th>
                    <th scope="col">UserName</th>
                    <th scope="col">Block</th>
                    <th scope="col">Type</th>
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
                    foreach ($user_array as $temp){
                        echo '<tr>';
                        echo "<td>".$temp['id']."</td>";
                        echo "<td>".$temp['user_name']."</td>";
                        echo "<td>".$temp['block']."</td>";
                        echo "<td>".$temp['type']."</td>";
                        echo "<td>".$temp['admin_t']."</td>";
                        echo "<td>".$temp['inventory_t']."</td>";
                        echo "<td>".$temp['check_t']."</td>";
                        echo "<td>".$temp['vendor_t']."</td>";
                        echo "<td>".$temp['tl_import_t']."</td>";
                        echo "<td>".$temp['import_t']."</td>";
                        echo "<td>".$temp['manager_t']."</td>";
                        echo "<td>".$temp['all_t']."</td>";
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table> 

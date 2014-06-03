<?php if (!defined('APP')) { die('Access denied.'); }
function patron_table($patron_base_url, $data) {
?>
        <div>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#">List</a></li>
                <li><a href="<?php echo "$patron_base_url?action=edit"; ?>">Edit</a></li>
            </ul>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>patron_id</th>
                <th>name</th>
                <th>email</th>
                <th>phone</th>
                <th colspan="2">Actions</th>
            </tr>
            </thead>
            <tbody>
                <!--
            <tr>
                <td><a href="#">5</a></td>
                <td>John Doe</td>
                <td>john@example.com</td>
                <td>555 555 0100</td>
                <td><a href="#">Edit</a></td>
                <td><a href="#">Delete</a></td>
            </tr> -->
<?php while (( $r = $data->fetch_assoc() )) { ?>
            <tr>
                <td><?php echo $r['patron_id']; ?></td>
                <td><?php echo $r['name']; ?></td>
                <td><?php echo $r['email']; ?></td>
                <td><?php echo $r['phone']; ?></td>
                <td><a href="<?php echo $patron_base_url . "?action=edit&id=" . $r['patron_id']; ?>">Edit</a></td>
                <td><a href="<?php echo $patron_base_url . "?action=delete&id=" . $r['patron_id']; ?>">Delete</a></td>
            </tr>
<?php } // end foreach ($data as $record) ?>
            </tbody>
        </table>
<?php
} // end patron_table

<?php defined('APP') or die('Access denied.');
function table($category_base_url, $data) {
?>
        <div>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#">List</a></li>
                <li><a href="<?php echo "$category_base_url?action=edit"; ?>">Edit</a></li>
            </ul>
        </div>
        Search
        <form method="get" role="form" class="form-inline">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <button type="submit" class="btn btn-default">Find</button>
        </form>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th colspan="2">Actions</th>
            </tr>
            </thead>
            <tbody>
<?php foreach ($data as $r) { ?>
            <tr>
                <td><?php echo_safe($r->category_id); ?></td>
                <td><?php echo_safe($r->name); ?></td>
                <td><a href="<?php echo $category_base_url . "?action=edit&id={$r->category_id}"; ?>">
                    Edit</a></td>
                <td><a 
                    href="<?php echo $category_base_url . "?action=delete&id={$r->category_id}"; ?>">
                    Delete</a></td>
            </tr>
<?php } // end foreach ($data as $r) ?>
            </tbody>
        </table>
<?php
} // end category_table

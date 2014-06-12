<?php defined('APP') or die('Access denied.');
function table($base_url, $data) {
?>
        <div>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#">List</a></li>
                <li><a href="<?php echo "$base_url?action=edit"; ?>">Edit</a></li>
            </ul>
        </div>
        Search
        <form method="get" role="form" class="form-inline">
            <div class="form-group">
                <label for="name">Title</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <button type="submit" class="btn btn-default">Find by Name</button>
        </form>

        <form method="get" role="form" class="form-inline">
            <div class="form-group">
                <label for="name">Description</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <button type="submit" class="btn btn-default">Find by Description</button>
        </form>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th colspan="2">Actions</th>
            </tr>
            </thead>
            <tbody>
<?php foreach ($data as $r) { ?>
            <tr>
                <td><?php echo_safe($r->work_id); ?></td>
                <td><?php echo_safe($r->title); ?></td>
                <td><a href="<?php echo $base_url . "?action=edit&id={$r->work_id}"; ?>">
                    Edit</a></td>
                <td><a 
                    href="<?php echo $base_url . "?action=delete&id={$r->work_id}"; ?>">
                    Delete</a></td>
            </tr>
<?php } // end foreach ($data as $r) ?>
            </tbody>
        </table>
<?php
} // end category_table

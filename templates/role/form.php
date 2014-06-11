<?php defined('APP') or die('Access denied.');
function form($role_base_url, $role_obj, $error) {
    if (!$role_obj) {
        $role_obj = new Dummy;
    }
?>
<div class="spaced">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo $role_base_url; ?>">List</a></li>
        <li class="active"><a href="#">Edit</a></li>
    </ul>
</div>

<form role="form" method="post">
    <?php if ($error) { ?>
    <div class="alert alert-danger" id="form-error">
        <p><b>One or more errors occured:</b></p>
        <ul>
    <?php foreach ($error as $e) { ?>
            <li><?php echo $e; ?></li>
    <?php } ?>
        </ul>
    </div>
    <?php }

    if ($role_obj->role_id) { ?>
    <input type="hidden" name="role_id" value="<?php echo $role_obj->role_id; ?>">
    <div class="form-group">
        <label for="role_id">Role ID</label>
        <p id="role_id"><?php echo $role_obj->role_id; ?></p>
    </div>
    <?php } ?>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" required
            value="<?php echo_safe($role_obj->name); ?>">
    </div>
    <input type="hidden" name="submit" value="submit">
    <button class="btn btn-default" type="submit">Submit</button>
    <?php if ($role_obj->role_id) { ?>
    <a href="<?php echo "$role_base_url?action=delete&id=$role_obj->role_id"; ?>"
        class="btn btn-danger">Delete</a>
    <?php } ?>
</form>
<?php
}

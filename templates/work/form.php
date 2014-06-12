<?php defined('APP') or die('Access denied.');
function form(
    $base_url, $work_obj, $error, $work_contributors, $category_list, $contributor_list, $role_list)
{
    if (!$work_obj) {
        $work_obj = new Dummy;
    }
?>
<div class="spaced">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo $base_url ?>">List</a></li>
        <li class="active"><a href="#">Edit</a></li>
    </ul>
</div>

<form method="post">
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

    if ($work_obj->work_id) {?>
    <div class="form-group">
        <label for="id">Work ID</label>
        <p id="id" class="form-control-static"><?php echo $work_obj->work_id ?></p>
    </div>
    <?php } ?>
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title" required 
            value="<?php echo_safe($work_obj->title) ?>">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10"
            class="form-control"><?php echo_safe($work_obj->description) ?></textarea>
    </div>
    <div class="form-group">
        <label for="category">Category</label>
        <select name="category" id="category" class="form-control" required>
            <option>Select a category</option>
            <?php foreach ($category_list as $cat) { ?>
                <option value="<?php echo $cat->category_id ?>" <?php echo $cat->category_id == $work_obj->category_id ?>>
                    <?php echo $cat->name; ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <input type="hidden" name="submit" value="work">
    <button class="btn btn-default" type="submit">Submit</button>
    <?php if ($work_obj->work_id) { ?>
    <a href="<?php echo "$base_url?action=delete&id=$work_obj->work_id"; ?>"
        class="btn btn-danger">Delete</a>
    <?php } ?>
</form>
<h2>Contributors</h2>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($work_contributors as $c) { ?>
        <tr>
            <td><?php echo_safe($c->contributor_name) ?></td>
            <td><?php echo_safe($c->role_name) ?></td>
            <td><a href="<?php echo "$base_url?action=delete_contributor&contrib_id={$c->contributor_id}&role_id={$c->role_id}" ?>">Delete</a></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<h3>Add a contributor:</h3>
<form method="post">
    <div class="form-group">
        <label for="contributor">Contributor</label>
        <select name="contributor" id="contributor" class="form-control">
            <option value="">Select a contributor</option>
            <?php foreach ($contributor_list as $c) { ?>
            <option value="<?php echo $c->contributor_id ?>">
                <?php echo $c->name ?>
            </option>
            <?php } ?> 
        </select>
    </div>
    <div class="form-group">
        <label for="role">Role</label>
        <select name="role" id="role" class="form-control">
            <option value="">Select a role</option>
            <?php foreach ($role_list as $c) { ?>
            <option value="<?php echo $c->role_id ?>">
                <?php echo $c->name ?>
            </option>
            <?php } ?> 
        </select>
    </div>

    <input type="hidden" name="submit" value="contributor">
    <button class="btn btn-default" type="submit">Submit</button>
</form>
<?php
}

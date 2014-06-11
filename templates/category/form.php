<?php defined('APP') or die('Access denied.');
function form($category_base_url, $category_obj, $error) {
    if (!$category_obj) {
        $category_obj = new Dummy;
    }
?>
<div class="spaced">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo $category_base_url; ?>">List</a></li>
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

    if ($category_obj->category_id) { ?>
    <input type="hidden" name="category_id" value="<?php echo $category_obj->category_id; ?>">
    <div class="form-group">
        <label for="category_id">Category ID</label>
        <p id="category_id"><?php echo $category_obj->category_id; ?></p>
    </div>
    <?php } ?>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" required
            value="<?php echo_safe($category_obj->name); ?>">
    </div>
    <input type="hidden" name="submit" value="submit">
    <button class="btn btn-default" type="submit">Submit</button>
    <?php if ($category_obj->category_id) { ?>
    <a href="<?php echo "$category_base_url?action=delete&id=$category_obj->category_id"; ?>"
        class="btn btn-danger">Delete</a>
    <?php } ?>
</form>
<?php
}

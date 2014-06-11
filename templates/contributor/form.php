<?php defined('APP') or die('Access denied.');
function form($contributor_base_url, $contributor_obj, $error) {
    if (!$contributor_obj) {
        $contributor_obj = new Dummy;
    }
?>
<div class="spaced">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo $contributor_base_url; ?>">List</a></li>
        <li class="active"><a href="#">Edit</a></li>
    </ul>
</div>

<form contributor="form" method="post">
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

    if ($contributor_obj->contributor_id) { ?>
    <input type="hidden" name="contributor_id" value="<?php echo $contributor_obj->contributor_id; ?>">
    <div class="form-group">
        <label for="contributor_id">contributor ID</label>
        <p id="contributor_id"><?php echo $contributor_obj->contributor_id; ?></p>
    </div>
    <?php } ?>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" required
            value="<?php echo_safe($contributor_obj->name); ?>">
    </div>
    <input type="hidden" name="submit" value="submit">
    <button class="btn btn-default" type="submit">Submit</button>
    <?php if ($contributor_obj->contributor_id) { ?>
    <a href="<?php echo "$contributor_base_url?action=delete&id=$contributor_obj->contributor_id"; ?>"
        class="btn btn-danger">Delete</a>
    <?php } ?>
</form>
<?php
// TODO: add list of the contributor's works below
// select * from Work inner join Contributor_Work where Contributor_Work.contributor_id = ?
}

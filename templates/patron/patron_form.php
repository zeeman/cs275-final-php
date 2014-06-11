<?php defined('APP') or die('Access denied.');
/* patron_detail_render
Renders the patron detail form.

args:
$patron_base_url - 
$patron_obj - The data to display. If false, the fields will be empty.
$error - An error message to display. If false, will not be displayed.
*/
function patron_form($patron_base_url, $patron_obj, $error) {
    if (!$patron_obj) {
        $patron_obj = new Dummy;
    }
?>
<div class="spaced">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo $patron_base_url; ?>">List</a></li>
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

    if ($patron_obj->patron_id) { ?>
    <input type="hidden" name="patron_id" value="<?php echo $patron_obj->patron_id; ?>">
    <div class="form-group">
        <label for="patron_id">Patron ID</label>
        <p id="patron_id"><?php echo $patron_obj->patron_id; ?></p>
    </div>
    <?php  }?>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" required
            value="<?php echo_safe($patron_obj->name); ?>">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" id="email" name="email"
            value="<?php echo_safe($patron_obj->email); ?>">
    </div>
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" class="form-control" id="phone" name="phone"
            value="<?php echo_safe($patron_obj->phone); ?>">
    </div>
    <input type="hidden" name="submit" value="submit">
    <button class="btn btn-default" type="submit">Submit</button>
    <?php if ($patron_obj->patron_id) { ?>
    <a href="<?php echo "$patron_base_url?action=delete&id=$patron_obj->patron_id"; ?>"
        class="btn btn-danger">Delete</a>
    <?php } ?>
</form>
<?php
// add list of the patron's loans
}

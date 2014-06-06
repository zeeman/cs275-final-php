<?php if (!defined('APP')) { die('Access denied.'); }
/* patron_detail_render
Renders the patron detail form.

args:
$patron_base_url - 
$patron_obj - The data to display. If false, the fields will be empty.
$error - An error message to display. If false, will not be displayed.
*/
function patron_form($patron_base_url, $patron_obj, $error) {
?>
<?php if ($id) { ?>
<div>
<a href="<?php echo "$patron_base_url?action=edit&id=$id&go=prev"?>" class="btn btn-default">Previous</a>
<a href="<?php echo "$patron_base_url?action=edit&id=$id&go=next"?>" class="btn btn-default">Next</a>
<a href="<?php echo "$patron_base_url?action=delete&id=$id"; ?>" class="btn btn-danger">Delete</a>
</div>
<?php } ?>

<div>
    <ul class="nav nav-tabs">
        <li><a href="<?php echo $patron_base_url; ?>">List</a></li>
        <li class="active"><a href="#">Edit</a></li>
    </ul>
</div>
<form role="form" method="post">
<?php if ($error) { ?>
<div class="alert alert-danger">
    <?php echo $error; ?>
</div>
<?php } ?>
<input type="hidden" name="id" value="<?php echo $patron_obj->patron_id; ?>">
<?php if ($patron_obj->id) { ?>
<div class="form-group">
    <label for="patron_id">Patron ID</label>
    <p id="patron_id"><?php echo $patron_obj->id; ?></p>
</div>
<?php  }?>
<div class="form-group">
    <label for="name">name</label>
    <input type="text" class="form-control" id="name" name="name"
        value="<?php echo $patron_obj->name; ?>">
</div>
<div class="form-group">
    <label for="phone">phone</label>
    <input type="text" class="form-control" id="phone" name="phone"
        value="<?php echo $patron_obj->phone; ?>">
</div>
<div class="form-group">
    <label for="email">email</label>
    <input type="text" class="form-control" id="email" name="email"
        value="<?php echo $patron_obj->email; ?>">
</div>
<input type="hidden" name="submit" value="submit">
<button class="btn btn-default" type="submit">Submit</button>
</form>
<?php
}

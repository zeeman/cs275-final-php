<?php if (!defined('APP')) { die('Access denied.'); }
function patron_delete($id, $name) {
?>
<em>Are you sure you want to delete the patron <b><?php echo $name ?></b>?</em>
<form method="post">
    <input type="hidden" name="delete_id" value="<?php echo $id; ?>">
    <button type="submit" class="btn btn-danger">Yes, delete.</button>
    <a href="patron.php?action=edit&id=<?php echo $id; ?>" class="btn btn-default">No, don't delete.</a>
<?php
}
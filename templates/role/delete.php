<?php if (!defined('APP')) { die('Access denied.'); }
function delete($id, $name) {
?>
<em>Are you sure you want to delete the role <b><?php echo $name ?></b>?</em>
<form method="post">
    <input type="hidden" name="delete_id" value="<?php echo $id; ?>">
    <button type="submit" class="btn btn-danger">Yes, delete.</button>
    <a href="role.php?action=edit&id=<?php echo $id; ?>" class="btn btn-default">No, don't delete.</a>
<?php
}
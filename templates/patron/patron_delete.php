<?php if (!defined('APP')) { die('Access denied.'); }
function patron_delete($id) {
?>
<em>Are you sure you want to delete?</em>
<form method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <button type="submit">Yes, delete.</button>
    <a href="patron.php?action=edit&id=<?php echo $id; ?>">No, don't delete.</button>
<?php
}
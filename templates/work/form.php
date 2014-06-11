<?php
function work_form(
    $base_url, $work_obj, $work_contributors, $category_list, $contributor_list, $role_list)
{
    if (!$work_obj) {
        $work_obj = new Dummy;
    }      
?>
<div class="spaced">
    <ul class="nav nav-tabs">
        <li><a href="#">List</a></li>
        <li class="active"><a href="#">Edit</a></li>
    </ul>
</div>

<form method="post">
    <div class="form-group">
        <label for="id">Work ID</label>
        <p id="id" class="form-control-static">1</p>
    </div>
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
            <?php foreach ($category_list as $cat) ?>
                <option value="<?php echo $cat->category_id ?>" <?php echo $cat->category_id == $work->category_id ?>>
                    <?php echo $cat->name; ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <input type="hidden" name="submit" value="work">
    <button class="btn btn-default" type="submit">Submit</button>
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
            <td><?php echo_safe($c->name) ?></td>
            <td><?php echo_safe($c->category) ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td>Contrib Utor</td>
            <td>Producer</td>
            <td><a href="#">Delete</a></td>
        </tr>

    </tbody>
</table>

<h3>Add a contributor:</h3>
<form method="post">
    <div class="form-group">
        <label for="contributor">Contributor</label>
        <select name="contributor" id="contributor" class="form-control">
            <option value="1">Contrib Utor</option>
            <option value="2">Aut Hority</option>
        </select>
    </div>
    <div class="form-group">
        <label for="role">Role</label>
        <select name="role" id="role" class="form-control">
            <option value="1">Producer</option>
            <option value="2">Author</option>
        </select>
    </div>

    <input type="hidden" name="submit" value="contributor">
    <button class="btn btn-default" type="submit">Submit</button>
</form>
<?php
}

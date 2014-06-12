<?php define('APP', 0);
require_once('common.php');
require_once('templates/base.php');
require_once('models/work.php');
require_once('models/category.php');
require_once('models/contributor.php');
require_once('models/role.php');

$filename = basename(__FILE__);
$work_base_url = BASE_URL . $filename;

$work_model = new Work($db);
$category_model = new Category($db);
$contributor_model = new Contributor($db);
$role_model = new Role($db);

switch(isset($_GET['action']) ? $_GET['action'] : 'list')
{
    case 'list':
        require_once("templates/work/table.php");
        // handle filters
        if (isset($_GET['name'])) {
            $data = $work_model->find_title($_GET['title']);
        } elseif (isset($_GET['desc'])) {
            $data = $work_model->find_description($_GET['desc']);
        } else {
            $data = $work_model->get_all();
        }

        base_header("Work List");
        table($work_base_url, $data);
        base_footer();

        break;
    case 'edit':
        require_once("templates/work/form.php");
        $data = NULL;
        $error = array();

        // handle form submission
        if (isset($_POST['submit']) and $_POST['submit'] == "work")
        {
            // handle validation
            if (!strlen($_POST['title'])) { $error[] = "You must enter a title."; }

            if (!count($error)) {
                // no errors - put it in the db
                // handle new object
                if (!isset($_POST['work_id'])) {
                    $id = $work_model->insert(
                        $_POST['title'], $_POST['description'], $_POST['category']);
                    redirect("$work_base_url?action=edit&id=$id");
                } else {
                    $work_model->update(
                        $_POST['work_id'], $_POST['title'], $_POST['description'],
                        $_POST['category']);
                }
            }

            $data = new stdClass;
            $data->work_id = isset($_POST['work_id']) ? $_POST['work_id'] : null;
            $data->title = isset($_POST['title']) ? $_POST['title'] : '';
            $data->description = isset($_POST['description']) ? $_POST['description'] : '';
            $data->category_id = isset($_POST['category']) ? $_POST['category'] : '';
        } elseif (isset($_POST['submit']) and $_POST['submit'] == "contributor") {
            $work_model->add_contributor($_GET['id'], $_POST['contributor'], $_POST['role']);
            redirect("$work_base_url?action=edit&id={$_GET['id']}");
        }

        // make sure the object exists
        if (isset($_GET['id']) and !isset($_POST['submit'])) {
            $data = $work_model->get($_GET['id']);
            if (!$data) {
                $error[] = "No object exists where id = " . htmlspecialchars($_GET['id']);
            }
        }

        if (isset($_GET['id'])) {
            $work_contributors = $work_model->get_contributors($_GET['id']);
        } else {
            $work_contributors = [];
        }
        $category_list = $category_model->get_all();
        $contributor_list = $contributor_model->get_all();
        $role_list = $role_model->get_all();

        base_header("Edit work");
        form($work_base_url, $data, $error, $work_contributors, $category_list, $contributor_list,
            $role_list);
        base_footer();
        break;
    case 'delete':
        // handle deletion after confirmation
        if (isset($_POST['delete_id'])) {
            $work_model->delete($_POST['delete_id']);
            redirect($work_base_url);
        }
        
        // handle nonexistent objects
        if (!($data = $work_model->get($_GET['id']))) redirect($work_base_url);

        require_once("templates/work/delete.php");
        // render the thing
        base_header("Delete work");
        delete($_GET['id'], $data->name);
        base_footer();

        break;
}
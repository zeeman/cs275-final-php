<?php define('APP', 0);
require_once('common.php');
require_once('templates/base.php');
require_once('models/category.php');

$filename = basename(__FILE__);
$category_base_url = BASE_URL . $filename;

$category_model = new Category($db);

switch(isset($_GET['action']) ? $_GET['action'] : 'list')
{
    case 'list':
        require_once("templates/category/table.php");
        // handle filters
        if (isset($_GET['name'])) {
            $data = $category_model->find_name($_GET['name']);
        } else {
            $data = $category_model->get_all();
        }

        base_header("Category List");
        table($category_base_url, $data);
        base_footer();

        break;
    case 'edit':
        require_once("templates/category/form.php");
        $data = NULL;
        $error = array();

        // handle form submission
        if (isset($_POST['submit']))
        {
            // handle validation
            if (!strlen($_POST['name'])) { $error[] = "You must enter a name."; }

            if (!count($error)) {
                // no errors - put it in the db
                // handle new object
                if (!isset($_POST['category_id'])) {
                    $id = $category_model->insert($_POST['name']);
                    redirect("$category_base_url?action=edit&id=$id");
                } else {
                    $category_model->update(
                        $_POST['category_id'], $_POST['name']);
                }
            }

            $data = new stdClass;
            $data->category_id = isset($_POST['category_id']) ? $_POST['category_id'] : null;
            $data->name = isset($_POST['name']) ? $_POST['name'] : '';
        }

        // make sure the object exists
        if (isset($_GET['id']) and !isset($_POST['submit'])) {
            $data = $category_model->get($_GET['id']);
            if (!$data) {
                $error[] = "No object exists where id = " . htmlspecialchars($_GET['id']);
            }
        }

        base_header("Edit category");
        form($category_base_url, $data, $error);
        base_footer();
        break;
    case 'delete':
        // handle deletion after confirmation
        if (isset($_POST['delete_id'])) {
            $category_model->delete($_POST['delete_id']);
            redirect($category_base_url);
        }
        
        // handle nonexistent objects
        if (!($data = $category_model->get($_GET['id']))) redirect($category_base_url);

        require_once("templates/category/delete.php");
        // render the thing
        base_header("Delete category");
        delete($_GET['id'], $data->name);
        base_footer();

        break;
}
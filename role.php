<?php define('APP', 0);
require_once('common.php');
require_once('templates/base.php');
require_once('models/role.php');

$filename = basename(__FILE__);
$role_base_url = BASE_URL . $filename;

$role_model = new Role($db);

switch(isset($_GET['action']) ? $_GET['action'] : 'list')
{
    case 'list':
        require_once("templates/role/table.php");
        // handle filters
        if (isset($_GET['name'])) {
            $data = $role_model->find_name($_GET['name']);
        } else {
            $data = $role_model->get_all();
        }

        base_header("Role List");
        table($role_base_url, $data);
        base_footer();

        break;
    case 'edit':
        require_once("templates/role/form.php");
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
                if (!isset($_POST['role_id'])) {
                    $id = $role_model->insert($_POST['name']);
                    redirect("$role_base_url?action=edit&id=$id");
                } else {
                    $role_model->update(
                        $_POST['role_id'], $_POST['name']);
                }
            }

            $data = new stdClass;
            $data->role_id = isset($_POST['role_id']) ? $_POST['role_id'] : null;
            $data->name = isset($_POST['name']) ? $_POST['name'] : '';
        }

        // make sure the object exists
        if (isset($_GET['id']) and !isset($_POST['submit'])) {
            $data = $role_model->get($_GET['id']);
            if (!$data) {
                $error[] = "No object exists where id = " . htmlspecialchars($_GET['id']);
            }
        }

        base_header("Edit role");
        form($role_base_url, $data, $error);
        base_footer();
        break;
    case 'delete':
        // handle deletion after confirmation
        if (isset($_POST['delete_id'])) {
            $role_model->delete($_POST['delete_id']);
            redirect($role_base_url);
        }
        
        // handle nonexistent objects
        if (!($data = $role_model->get($_GET['id']))) redirect($role_base_url);

        require_once("templates/role/delete.php");
        // render the thing
        base_header("Delete role");
        delete($_GET['id'], $data->name);
        base_footer();

        break;
}
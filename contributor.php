<?php define('APP', 0);
require_once('common.php');
require_once('templates/base.php');
require_once('models/contributor.php');

$filename = basename(__FILE__);
$contributor_base_url = BASE_URL . $filename;

$contributor_model = new Contributor($db);

switch(isset($_GET['action']) ? $_GET['action'] : 'list')
{
    case 'list':
        require_once("templates/contributor/table.php");
        // handle filters
        if (isset($_GET['name'])) {
            $data = $contributor_model->find_name($_GET['name']);
        } else {
            $data = $contributor_model->get_all();
        }

        base_header("Contributor List");
        table($contributor_base_url, $data);
        base_footer();

        break;
    case 'edit':
        require_once("templates/contributor/form.php");
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
                if (!isset($_POST['contributor_id'])) {
                    $id = $contributor_model->insert($_POST['name']);
                    redirect("$contributor_base_url?action=edit&id=$id");
                } else {
                    $contributor_model->update(
                        $_POST['contributor_id'], $_POST['name']);
                }
            }

            $data = new stdClass;
            $data->contributor_id = isset($_POST['contributor_id']) ? $_POST['contributor_id'] : null;
            $data->name = isset($_POST['name']) ? $_POST['name'] : '';
        }

        // make sure the object exists
        if (isset($_GET['id']) and !isset($_POST['submit'])) {
            $data = $contributor_model->get($_GET['id']);
            if (!$data) {
                $error[] = "No object exists where id = " . htmlspecialchars($_GET['id']);
            }
        }

        base_header("Edit Contributor");
        form($contributor_base_url, $data, $error);
        base_footer();
        break;
    case 'delete':
        // handle deletion after confirmation
        if (isset($_POST['delete_id'])) {
            $contributor_model->delete($_POST['delete_id']);
            redirect($contributor_base_url);
        }
        
        // handle nonexistent objects
        if (!($data = $contributor_model->get($_GET['id']))) redirect($contributor_base_url);

        require_once("templates/contributor/delete.php");
        // render the thing
        base_header("Delete Contributor");
        delete($_GET['id'], $data->name);
        base_footer();

        break;
}
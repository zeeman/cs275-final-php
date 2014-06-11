<?php define('APP', 0);
/*
Patron View Cases:
- list
    - plain view (no params)
    - filtered
        - name filter ($_GET['name'])
- edit
    - create new (no params)
        - submit new (POST params)
    - edit existing ($_GET['id'])
        - submit existing (POST params with $_POST['patron_id'] set)
- delete
    - initial delete request, needing confirmation ($_GET['id'] set)
    - actual deletion request ($_GET['id'] and $_POST['delete'] set)
*/
require_once('common.php');
require_once('templates/base.php');
require_once('models/patron.php');

$filename = basename(__FILE__);
$patron_base_url = BASE_URL . $filename;

$patron_model = new Patron($db);

switch(isset($_GET['action']) ? $_GET['action'] : 'list')
{
    case 'list':
        require_once("templates/patron/patron_table.php");
        // handle filters
        if (isset($_GET['name'])) {
            $data = $patron_model->find_name($_GET['name']);
        } else {
            $data = $patron_model->get_all();
        }

        base_header("Patron List");
        patron_table($patron_base_url, $data);
        base_footer();

        break;
    case 'edit':
        require_once("templates/patron/patron_form.php");
        $data = NULL;
        $error = array();

        // handle form submission
        if (isset($_POST['submit']))
        {
            // handle validation
            if (!strlen($_POST['name'])) { $error[] = "You must enter a name."; }

            if (strlen($_POST['phone'])) {
                // strip all non-numbers from the phone, then make sure it's valid
                if (!preg_match( "/^[0-9]{10}$/", preg_replace('/[^0-9]/', '', $_POST['phone']) )) {
                    $error[] = "Invalid phone number entered.";
            }}

            if (strlen($_POST['email'])) {
                if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $error[] = "Invalid email entered.";
            }}

            if (!count($error)) {
                // no errors - put it in the db
                // handle new object
                if (!isset($_POST['patron_id'])) {
                    $id = $patron_model->insert($_POST['name'], $_POST['email'], $_POST['phone']);
                    redirect("$patron_base_url?action=edit&id=$id");
                } else {
                    $patron_model->update(
                        $_POST['patron_id'], $_POST['name'], $_POST['email'], $_POST['phone']);
                }
            }

            $data = new stdClass;
            $data->patron_id = isset($_POST['patron_id']) ? $_POST['patron_id'] : null;
            $data->name = isset($_POST['name']) ? $_POST['name'] : '';
            $data->phone = isset($_POST['phone']) ? $_POST['phone'] : '';
            $data->email = isset($_POST['email']) ? $_POST['email'] : '';
        }

        // make sure the object exists
        if (isset($_GET['id']) and !isset($_POST['submit'])) {
            $data = $patron_model->get($_GET['id']);
            if (!$data) {
                $error[] = "No object exists where id = " . htmlspecialchars($_GET['id']);
            }
        }

        base_header("Edit Patron");
        patron_form($patron_base_url, $data, $error);
        base_footer();
        break;
    case 'delete':
        // handle deletion after confirmation
        if (isset($_POST['delete_id'])) {
            $patron_model->delete($_POST['delete_id']);
            redirect($patron_base_url);
        }
        
        // handle nonexistent objects
        if (!($data = $patron_model->get($_GET['id']))) redirect($patron_base_url);

        require_once("templates/patron/patron_delete.php");
        // render the thing
        base_header("Delete Patron");
        patron_delete($_GET['id'], $data->name);
        base_footer();

        break;
}
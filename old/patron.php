<?php define('APP', 0);
require_once('./common.php');
require_once('./templates/base.php');
$patron_base_url = BASE_URL . "patron.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$fields = "`patron_id`, `name`, `phone`, `email`";

switch ($action)
{
case 'list':
    $q = "select $fields from `Patron`";
    /*if (isset($_GET['name']) || isset($_GET['phone']) || isset($_GET['email'])) {
        $q .= " where ";

    }*/
    require('./templates/patron/patron_table.php');
    // get the data from the database
    $data = $db->query($q);
    base_header("Patron List");
    patron_table($patron_base_url, $data);
    base_footer();
    break;
/* case 'detail':
    require('./templates/patron/patron_detail.php');
    $data = False;
    base_header("Patron Details - " . $data['id']);
    patron_detail($data);
    base_footer();
    break;*/
case 'edit':
    require('./templates/patron/patron_form.php');
    $id = $name = $phone = $email = $error = "";
    // handle form submission and validation
    if (isset($_POST['submit'])) {
        // validate
        if (trim($_POST['name']) == "") { $error = "A name is required!"; }
        // if valid, submit to the db
        if ($error == "") {
            // if id is blank the record is new
            if ($_POST['id'] !== "") {
                // update existing
                $q = "update `Patron` set `name`=?, `phone`=?, `email`=? where `patron_id` = ?";
                $stmt = $db->prepare($q);
                $stmt->bind_param('sssi', $_POST['name'], $_POST['email'], $_POST['phone'],
                    $_POST['id']);        
                $stmt->execute();
            } else {
                // insert new
                $q = "insert into `Patron` (`name`, `email`, `phone`) values (?, ?, ?)";
                $stmt = $db->prepare($q);
                $stmt->bind_param('sss', $_POST['name'], $_POST['email'], $_POST['phone']);
                $stmt->execute();
                $q = "select LAST_INSERT_ID()";
                $data = $db->query($q);
                $id = $data->fetch_row()[0];
                redirect_inside("patron.php?action=edit&id=$id");
            }
        }
        // if invalid, display the error
    }

    // handle going forward and backwards
    elseif (isset($_GET['go'])) {
        if ($_GET['go'] == "next") {
            $q = "select min(`patron_id`) from `Patron` where `patron_id` > ? limit 1";
        } elseif ($_GET['go'] == "prev") {
            $q = "select max(`patron_id`) from `Patron` where `patron_id` < ? limit 1";
        }
        $stmt = $db->prepare($q);
        $stmt->bind_param('i', $_GET['id']);
        $stmt->bind_result($id);
        $stmt->execute();
        if ($stmt->affected_rows == 0) {
            // stupid response but I don't know what else to do
            redirect_inside('patron.php');
        }
        $stmt->fetch();
        redirect_inside("patron.php?action=edit&id=$id");
    }

    // handle form display
    if ( isset($_GET['id']) ) {
        $q = "select $fields from `Patron` where `patron_id` = ?";
        $stmt = $db->prepare($q);
        $stmt->bind_param('i', $_GET['id']);
        $stmt->bind_result($id, $name, $phone, $email);
        $stmt->execute();
        if ($stmt->affected_rows == 0) {
            // stupid response but I don't know what else to do
            die('404 not found');
        }
        $stmt->fetch();
    }

    base_header("Edit Patron - " . $id);
    patron_form($patron_base_url, $id, $name, $phone, $email, $error);
    base_footer();
    break;
case 'delete':
    // should probably confirm before deletion. nah fuck it
    $q = "delete from `Patron` where `patron_id` = ?";
    $stmt = $db->prepare($q);
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    redirect_inside('patron.php');
    break;
default:
    die("Invalid action: $action. -10 points.");
}
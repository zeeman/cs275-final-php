<?php defined('APP') or die('Access denied.');
class Patron
{
    public $fields = ['patron_id', 'name', 'email', 'phone'];
    public $primary_key = ['patron_id'];
    public $table_name = "Patron";
    private $field_str;
    private $db_connection;

    function __construct($db_connection)
    {
        // ugly hack to quote every string
        $this->field_str = '`' . implode('`,`', $this->fields) . '`';
        $this->db_connection = $db_connection;
    }

    // retrieve patron by user ID
    public function get($id)
    {
        $q = "select {$this->field_str} from {$this->table_name} where $primary_key = ?";
        $stmt 
    }

    // find names like the name
    public function find_name($name)
    {

    }

    public function insert($name, $email, $phone) 
    {

    }

    public function update($id, $name, $email, $phone)
    {

    }
}
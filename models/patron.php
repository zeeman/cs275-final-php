<?php defined('APP') or die('Access denied.');
class Patron
{
    /*
    Class allowing easy interaction with the Patron table. Follows Fowler's Table Data Gateway
    pattern.
    */
    private $fields = ['patron_id', 'name', 'email', 'phone'];
    private $table_name = "Patron";
    private $field_str;
    private $db_connection;

    /* constructor
    Accepts the DB connection (PDO or compatible) as an argument.
     */
    function __construct($db_connection)
    {
        // ugly hack to quote every string
        $this->field_str = '`' . implode('`,`', $this->fields) . '`';
        $this->db_connection = $db_connection;
    }

    // retrieve patron by user ID. returns an anonymous object with an attribute for each field
    public function get($id)
    {
        $q = "select {$this->field_str} from {$this->table_name} where `patron_id` = ?";
        $stmt = $db->prepare($q);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // find names like the name passed in. in the UI should mention that % and _ do things.
    public function find_name($name)
    {
        $q = "select {$this->field_str} from {$this->table_name} where `name` like ?";
        $stmt = $db->prepare($q);
        $stmt->execute(["%$name%"]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /* insert()
    Accepts $name, $email, $phone of a new Patron object to create, returns the newly-created
    entity's primary key.
    */
    public function insert($name, $email, $phone) 
    {
        $q = "insert `{$this->table_name}` (`name`,`email`,`phone`) values(?,?,?)";
        $stmt = $db->parepare($q);
        $stmt->execute([$name, $email, $phone]);

        $q = "select last_insert_id()";
        $stmt = $db->query($q);
        return $stmt->fetchColumn(0);
    }

    /* update()
    Updates $name, $email, and $phone of patron $id. Returns a bool indicating success or failure.
    */
    public function update($id, $name, $email, $phone)
    {
        $q = "update `{$this->table_name}` set name=?, email=?, phone=? where `patron_id` = ?";
        $stmt = $db->prepare($q);
        return $stmt->execute(array($name, $email, $phone, $id));
    }

    public function delete($id)
    {
        $q = "delete from `{$this->table_name}` where `patron_id` = ?";
        $stmt = $db->prepare($q);
        return $stmt->execute([$id]);
    }
}

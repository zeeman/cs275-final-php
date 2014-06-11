<?php defined('APP') or die('Access denied.');

class Role
{
    private $fields = ['role_id', 'name'];
    private $table_name = "Role";
    private $field_str;
    private $db_connection;

    /* constructor
    Accepts the DB connection (PDO or compatible) as an argument.
     */
    function __construct($db_connection)
    {
        // ugly hack to quote every string
        $this->field_str = '`' . implode('`,`', $this->fields) . '`';
        $this->db = $db_connection;
    }

    public function get_all()
    {
        $q = "select {$this->field_str} from {$this->table_name}";
        $stmt = $this->db->prepare($q);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function get($id)
    {
        $q = "select {$this->field_str} from {$this->table_name} where `role_id` = ?";
        $stmt = $this->db->prepare($q);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function find_name($name)
    {
        $q = "select {$this->field_str} from {$this->table_name} where `name` like ?";
        $stmt = $this->db->prepare($q);
        $stmt->execute(["%$name%"]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function insert($name) 
    {
        $q = "insert `{$this->table_name}` (`name`) values(?)";
        $stmt = $this->db->prepare($q);
        $stmt->execute([$name]);

        $q = "select last_insert_id()";
        $stmt = $this->db->query($q);
        return $stmt->fetchColumn(0);
    }

    public function update($id, $name)
    {
        $q = "update `{$this->table_name}` set name=? where `role_id` = ?";
        $stmt = $this->db->prepare($q);
        return $stmt->execute(array($name, $id));
    }

    public function delete($id)
    {
        $q = "delete from `{$this->table_name}` where `role_id` = ?";
        $stmt = $this->db->prepare($q);
        return $stmt->execute([$id]);
    }
}
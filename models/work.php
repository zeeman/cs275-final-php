<?php defined('APP') or die('Access denied.');

class Work
{
    private $fields = ['work_id', 'title', 'description', 'category_id'];
    private $table_name = "Work";
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
        $q = "select {$this->field_str} from {$this->table_name} where `work_id` = ?";
        $stmt = $this->db->prepare($q);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function find_title($title)
    {
        $q = "select {$this->field_str} from {$this->table_name} where `title` like ?";
        $stmt = $this->db->prepare($q);
        $stmt->execute(["%$title%"]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function find_description($description)
    {
        $q = "select {$this->field_str} from {$this->table_name} where `description` like ?";
        $stmt = $this->db->prepare($q);
        $stmt->execute(["%$description%"]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function insert($title, $description, $category_id) 
    {
        $q = "insert `{$this->table_name}` (`title`, `description`, `category_id`) values(?, ?, ?)";
        $stmt = $this->db->prepare($q);
        $stmt->execute([$title, $description, $category_id]);

        $q = "select last_insert_id()";
        $stmt = $this->db->query($q);
        return $stmt->fetchColumn(0);
    }

    public function update($id, $title, $description, $category_id)
    {
        $q="update `{$this->table_name}` set title=?,description=?,category_id=? where `work_id`=?";
        $stmt = $this->db->prepare($q);
        return $stmt->execute(array($title, $description, $category_id, $id));
    }

    public function delete($id)
    {
        $q = "delete from `{$this->table_name}` where `work_id` = ?";
        $stmt = $this->db->prepare($q);
        return $stmt->execute([$id]);
    }

    public function add_contributor($work_id, $contributor_id, $role_id)
    {
        $q = "insert `Contributor_Work` (`work_id`, `contributor_id`, `role_id`) values (?, ?, ?)";
        $stmt = $this->db->prepare($q);
        return $stmt->execute([$work_id, $contributor_id, $role_id]);
    }

    public function remove_contributor($work_id, $contributor_id, $role_id)
    {
        $q = "delete from `Contributor_Work` where `work_id`=?, `contributor_id`=?, `role_id`=?";
        $stmt = $this->db->prepare($q);
        return $stmt->execute([$work_id, $contributor_id, $role_id]);
    }

    public function get_contributors($work_id)
    {
        // natural joins for the naturally lazy
        $q = "select contributor.contributor_id, contributor.name as contributor_name, role.role_id, role.name as role_name from contributor_work natural join contributor natural join contributor_work natural join role where contributor_work.work_id = ?";
        $stmt = $this->db->prepare($q);
        $stmt->execute([$work_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
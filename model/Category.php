<?php
class Category
{
    private $conn;
    private $table_name = "category";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function get_category_by_id($id)
    {
        $query = "select * from " . $this->table_name . " where id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function get_All()
    {
        $query = "select * from " . $this->table_name;
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function add_category($name, $description)
    {
        $error = [];
        if (empty($name)) {
            $error['name'] = "Name is required";
        }
        if (empty($description)) {
            $error['description'] = "Description is required";
        }
        if (count($error) > 0) {
            return $error;
        }

        $query = "insert into " . $this->table_name . " (name, description) values (:name, :description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindeParam(":description", $description);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update_category($id, $name, $description)
    {
        $error = [];
        if (empty($id)) {
            $error['id'] = "Id is required";
        }
        if (empty($name)) {
            $error['name'] = "Name is required";
        }
        if (count($error) > 0) {
            return $error;
        }
        $query = "update " . $this->table_name . " set name = :name, description = :description where id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam("name", $name);
        $stmt->bindParam("description", $description);
        $stmt->bindParam("id", $id);
        if ($stmt->execute()->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_category($id)
    {
        $query = "delete from " . $this->table_name . " where id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}

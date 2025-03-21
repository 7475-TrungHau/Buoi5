<?php


class Product
{
    private $conn;
    private $table_name = 'product';


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function get_product_by_id($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function get_All_Product()
    {
        $query = 'select p.id, p.name, p.description, p.price, p.image ,c.name as category_name from ' . $this->table_name . ' p left join category c on p.category_id = c.id';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function add_Product($name, $price, $description, $category_id, $image)
    {
        $error = [];
        if (!$name)
            $error['name'] = 'Name is required';
        if (!$price)
            $error['price'] = 'Price is required';
        if (!$description)
            $error['description'] = 'Description is required';
        if (!$category_id)
            $error['category_id'] = 'Category is required';
        if (!$image)
            $error['image'] = 'Image is required';

        if (count($error) > 0)
            return $error;

        $query = 'INSERT INTO ' . $this->table_name . ' (name, price, description, category_id, image) VALUES (:name, :price, :description, :category_id, :image)';
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute(['name' => $name, 'price' => $price, 'description' => $description, 'category_id' => $category_id, 'image' => $image])) {
            return true;
        }
        return false;
    }

    public function update_Product($id, $name, $price, $description, $category_id, $image)
    {
        $query = 'UPDATE ' . $this->table_name . ' SET name = :name, price = :price, description = :description, category_id = :category_id, image = :image WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam('description', $description);
        $stmt->bindParam('category_id', $category_id);
        $stmt->bindParam('image', $image);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function delete_Product($id)
    {
        $query = 'DELETE FROM ' . $this->table_name . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

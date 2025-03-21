<?php
require_once __DIR__ . '/../model/Category.php';
require_once __DIR__ . '/../config/database.php';

class CategoryController
{
    private $db;
    private $categoryModel;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new Category($this->db);
    }

    public function index()
    {
        $categories = $this->categoryModel->get_All();
        include __DIR__ . "/../view/category/index.php";
    }
    public function show($id)
    {
        $category = $this->categoryModel->get_category_by_id($id);
        include __DIR__ . "/../view/category/show.php";
    }
    public function create()
    {
        include __DIR__ . "/../view/category/create.php";
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            if ($this->categoryModel->add_category($name, $description)) {
                header("Location: /category");
            } else {
                echo "Create failed";
            }
        } else {
            echo "Method not allowed";
        }
    }
    public function edit($id)
    {
        $category = $this->categoryModel->get_category_by_id($id);
        include __DIR__ . "/../view/category/edit.php";
    }
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            if ($this->categoryModel->update_category($id, $name, $description)) {
                header("Location: /category");
            } else {
                echo "Update failed";
            }
        } else {
            echo "Method not allowed";
        }
    }
    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->categoryModel->delete_category($id)) {
                header("Location: /category");
            } else {
                echo "Delete failed";
            }
        } else {
            echo "Method not allowed";
        }
    }
}

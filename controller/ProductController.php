<?php
require_once __DIR__ . '/../model/Product.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/Category.php';

class ProductController
{
    private $db;
    private $productModel;
    private $categories;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new Product($this->db);
        $this->categories = new Category($this->db);
    }

    public function show($id)
    {
        $product = $this->productModel->get_product_by_id($id);
        include __DIR__ . '/../view/product/show.php';
    }

    public function index()
    {
        $products = $this->productModel->get_All_Product();
        include __DIR__ . '/../view/product/index.php';
    }

    public function create()
    {
        $categories = $this->categories->get_All();
        include __DIR__ . '/../view/product/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = [];

            // Validate required fields
            if (empty($_POST['name'])) $errors['name'] = "Product name is required";
            if (empty($_POST['price']) || !is_numeric($_POST['price'])) $errors['price'] = "Valid price is required";
            if (empty($_POST['description'])) $errors['description'] = "Description is required";
            if (empty($_POST['category_id'])) $errors['category_id'] = "Category is required";

            // Handle image based on selection type
            $image = null;
            if ($_POST['image_source'] === 'file' && isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                // Process file upload
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $_FILES['image']['name'];
                $tmp_name = $_FILES['image']['tmp_name'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                if (!in_array($ext, $allowed)) {
                    $errors['image'] = "Invalid file format. Only JPG, PNG and GIF are allowed.";
                } elseif ($_FILES['image']['size'] > 2097152) { // 2MB
                    $errors['image'] = "File size exceeds 2MB limit.";
                } else {
                    $new_filename = uniqid() . '.' . $ext;
                    $upload_dir = __DIR__ . '/../public/uploads/';

                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }

                    if (move_uploaded_file($tmp_name, $upload_dir . $new_filename)) {
                        $image = '/BT6/public/uploads/' . $new_filename;
                    } else {
                        $errors['image'] = "Failed to upload image.";
                    }
                }
            } elseif ($_POST['image_source'] === 'url' && !empty($_POST['image_url'])) {
                // Process image URL
                $image = filter_var($_POST['image_url'], FILTER_SANITIZE_URL);
            } else {
                $errors['image'] = "Product image is required";
            }

            // If no errors, add product
            if (empty($errors)) {
                $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                $category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);

                if ($this->productModel->add_Product($name, $price, $description, $category_id, $image)) {
                    header("Location: /BT6/product");
                    exit;
                } else {
                    $errors['general'] = "Failed to create product. Please try again.";
                }
            }

            // If we have errors, go back to the form with error messages
            if (!empty($errors)) {
                $categories = $this->categories->get_All();
                include __DIR__ . '/../view/product/create.php';
            }
        } else {
            header("HTTP/1.1 405 Method Not Allowed");
            echo "Method not allowed";
        }
    }

    public function edit($id)
    {
        $product = $this->productModel->get_product_by_id($id);
        $categories = $this->categories->get_All();
        include __DIR__ . '/../view/product/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = [];

            // Validate required fields
            if (empty($_POST['name'])) $errors['name'] = "Product name is required";
            if (empty($_POST['price']) || !is_numeric($_POST['price'])) $errors['price'] = "Valid price is required";
            if (empty($_POST['description'])) $errors['description'] = "Description is required";
            if (empty($_POST['category_id'])) $errors['category_id'] = "Category is required";

            // Handle image based on selection type
            $image = $_POST['current_image']; // Default to current image
            if ($_POST['image_source'] === 'file' && isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                // Process file upload
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $_FILES['image']['name'];
                $tmp_name = $_FILES['image']['tmp_name'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                if (!in_array($ext, $allowed)) {
                    $errors['image'] = "Invalid file format. Only JPG, PNG and GIF are allowed.";
                } elseif ($_FILES['image']['size'] > 2097152) { // 2MB
                    $errors['image'] = "File size exceeds 2MB limit.";
                } else {
                    $new_filename = uniqid() . '.' . $ext;
                    $upload_dir = __DIR__ . '/../public/uploads/';

                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }

                    if (move_uploaded_file($tmp_name, $upload_dir . $new_filename)) {
                        $image = '/BT6/public/uploads/' . $new_filename;
                    } else {
                        $errors['image'] = "Failed to upload image.";
                    }
                }
            } elseif ($_POST['image_source'] === 'url' && !empty($_POST['image_url'])) {
                // Process image URL
                $image = filter_var($_POST['image_url'], FILTER_SANITIZE_URL);
            }

            // If no errors, update product
            if (empty($errors)) {
                $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                $category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);

                if ($this->productModel->update_Product($id, $name, $price, $description, $category_id, $image)) {
                    header("Location: /BT6/product");
                    exit;
                } else {
                    $errors['general'] = "Failed to update product. Please try again.";
                }
            }

            // If we have errors, go back to the form with error messages
            if (!empty($errors)) {
                $product = $this->productModel->get_product_by_id($id);
                $categories = $this->categories->get_All();
                include __DIR__ . '/../view/product/edit.php';
            }
        } else {
            header("HTTP/1.1 405 Method Not Allowed");
            echo "Method not allowed";
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->productModel->delete_Product($id)) {
                header("Location: /product");
            } else {
                echo "Delete failed";
            }
        } else {
            echo "Method not allowed";
        }
    }
}

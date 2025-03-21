<?php

require_once __DIR__ . '/controller/ProductController.php';
require_once __DIR__ . '/controller/CategoryController.php';

// Lấy đường dẫn yêu cầu từ URL
$request = $_SERVER['REQUEST_URI'];

// Loại bỏ base path nếu ứng dụng nằm trong thư mục con
$basePath = '/BT6'; // Thay đổi nếu ứng dụng nằm ở thư mục khác
$request = str_replace($basePath, '', $request);

// Loại bỏ query string (nếu có)
$request = strtok($request, '?');

// Định nghĩa các route
switch ($request) {
    case '/':
    case '':
        echo "<h1>Home Page</h1>";
        break;
    case '/product':
        $productController = new ProductController();
        $productController->index();
        break;
    case '/product/show':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $productController = new ProductController();
            $productController->show($id);
        } else {
            echo "Product ID is missing.";
        }
        break;
    case '/product/create':
        $productController = new ProductController();
        $productController->create();
        break;
    case '/product/store':
        $productController = new ProductController();
        $productController->store();
    case '/product/edit':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $productController = new ProductController();
            $productController->edit($id);
        } else {
            echo "Product ID is missing.";
        }
        break;
    case '/product/update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id) {
                $productController = new ProductController();
                $productController->update($id);
            } else {
                echo "Product ID is missing.";
            }
        } else {
            echo "Invalid request method.";
        }
        break;
    case '/product/delete':
        $id = $_POST['id'] ?? null;
        if ($id) {
            $productController = new ProductController();
            $productController->delete($id);
        } else {
            echo "Product ID is missing";
        }
        break;
    case '/category':
        $categoryController = new CategoryController();
        $categoryController->index();
        break;
    case '/category/index':
        $categoryController = new CategoryController();
        $categoryController->index();
        break;

    default:
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        break;
}

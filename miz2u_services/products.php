<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, DELETE");
header("Access-Control-Allow-Headers: Content-Type");


include "connection.php";

$method = $_SERVER["REQUEST_METHOD"];

switch ($method) {
    case 'GET':
        
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);
        $products = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }

        echo json_encode($products);
        break;

    case 'POST':
        
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? 0;
        $description = $_POST['description'] ?? '';
        $hasImage = isset($_FILES['image']) && $_FILES['image']['error'] === 0;

        
        if (isset($_POST['prod_id'])) {
            // Update Product
            $prod_id = $_POST['prod_id'];

            if ($hasImage) {
                // Upload new image
                $imageFile = $_FILES['image'];
                $targetDir = "images/";
                $imageName = uniqid() . "_" . basename($imageFile["name"]);
                $targetPath = $targetDir . $imageName;

                if (!move_uploaded_file($imageFile["tmp_name"], $targetPath)) {
                    http_response_code(500);
                    echo json_encode(["error" => "Failed to upload image"]);
                    exit;
                }

                //with new image
                $stmt = $conn->prepare("UPDATE products SET name=?, price=?, description=?, image=? WHERE prod_id=?");
                $stmt->bind_param("sdsss", $name, $price, $description, $imageName, $prod_id);
            } else {
                //without changing image
                $stmt = $conn->prepare("UPDATE products SET name=?, price=?, description=? WHERE prod_id=?");
                $stmt->bind_param("sdss", $name, $price, $description, $prod_id);
            }

            if ($stmt->execute()) {
                echo json_encode(["message" => "Product updated"]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => $stmt->error]);
            }

        } else {
            // Create Product
            if (!$hasImage) {
                http_response_code(400);
                echo json_encode(["error" => "Image file is missing"]);
                exit;
            }

            $imageFile = $_FILES['image'];

            // Auto Generate ID
            $getIdSql = "SELECT prod_id FROM products ORDER BY prod_id DESC LIMIT 1";
            $result = $conn->query($getIdSql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $lastId = intval(substr($row['prod_id'], 2));
                $newId = 'P-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newId = 'P-0001';
            }

            // Upload image
            $targetDir = "images/";
            $imageName = uniqid() . "_" . basename($imageFile["name"]);
            $targetPath = $targetDir . $imageName;

            if (!move_uploaded_file($imageFile["tmp_name"], $targetPath)) {
                http_response_code(500);
                echo json_encode(["error" => "Failed to upload image"]);
                exit;
            }

            // Insert new product
            $stmt = $conn->prepare("INSERT INTO products (prod_id, name, price, description, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdss", $newId, $name, $price, $description, $imageName);

            if ($stmt->execute()) {
                echo json_encode(["message" => "Product created", "prod_id" => $newId]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => $stmt->error]);
            }
        }

        break;

    case 'DELETE':
        
        $data = json_decode(file_get_contents("php://input"), true);
        $prod_id = $data['prod_id'] ?? null;
    
        if (!$prod_id) {
            http_response_code(400);
            echo json_encode(["error" => "Product ID is required"]);
            exit;
        }
    
        // Delete Image
        $imageQuery = $conn->prepare("SELECT image FROM products WHERE prod_id=?");
        $imageQuery->bind_param("s", $prod_id);
        $imageQuery->execute();
        $imageResult = $imageQuery->get_result();
        if ($imageResult->num_rows > 0) {
            $row = $imageResult->fetch_assoc();
            $imagePath = "images/" . $row['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    
        $stmt = $conn->prepare("DELETE FROM products WHERE prod_id=?");
        $stmt->bind_param("s", $prod_id);
    
        if ($stmt->execute()) {
            echo json_encode(["message" => "Product deleted successfully"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => $stmt->error]);
        }
    
        break;
}
?>

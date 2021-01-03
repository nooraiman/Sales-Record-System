<?php
//SESSION CHECK
session_start();
if(!isset($_SESSION['id'])) {
    die(http_response_code(403));
}

require '../includes/database.php';

function insertProduct($name,$price,$supplier)
{
    global $conn;
    $result = "";

    try
    {
        $stmt = $conn->prepare("INSERT INTO product (prod_name,prod_price,su_id) VALUES (?,?,?)");
        $stmt->execute([$name,$price,$supplier]);
        $result = "success";
    }
    catch(PDOException $e)
    {
        $result = $e->getMessage();
    }
    echo $result;
}

function getProduct($id)
{
    global $conn;

    try
    {
        $stmt = $conn->prepare("SELECT * FROM product p JOIN supplier s ON p.su_id = s.su_id WHERE p.prod_id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt->rowCount() == 1)
        {
            $result += array("message"=>"found");
            echo json_encode($result);
        }
        else
        {
            echo json_encode(array("message"=>"not found"));
        }
    }
    catch(PDOException $e)
    {
        throw $e->getMessage();
    }
}

function editProduct($id,$name,$price,$supplier)
{
    global $conn;
    $result = "";

    try
    {
        $stmt = $conn->prepare("UPDATE product SET prod_name = ?, prod_price = ?, su_id = ? WHERE prod_id = ?");
        $stmt->execute([$name,$price,$supplier,$id]);
        $result = "success";
    }
    catch(PDOException $e)
    {
        throw $e->getMessage();
        $result = "failed";
    }
    
    echo $result;
}

function deleteProduct($id)
{
    global $conn;
    $result = "";

    try
    {
        $stmt = $conn->prepare("DELETE FROM product WHERE prod_id = ?");
        $stmt->execute([$id]);
        $result = "success";
    }
    catch(PDOException $e)
    {
        throw $e->getMessage();
        $result = "failed";
    }

    echo $result;
}

// Insert Product
if(isset($_POST['insertProduct']))
{
    $name = $_POST['productName'];
    $price = $_POST['productPrice'];
    $supplier = $_POST['supplier'];

    insertProduct($name,$price,$supplier);
}
// Get Product
else if(isset($_GET['getProduct']))
{
    $id = $_GET['id'];
    getProduct($id);
}
// Edit Product
else if(isset($_POST['editProduct']))
{
    $id = $_POST['EproductID'];
    $name = $_POST['EproductName'];
    $price = $_POST['EproductPrice'];
    $supplier = $_POST['Esupplier'];

    editProduct($id,$name,$price,$supplier);
}
// Delete Product
else if(isset($_POST['deleteProduct']))
{
    $id = $_POST['id'];
    deleteProduct($id);
}
else
{
    die("No Direct Access!");
}
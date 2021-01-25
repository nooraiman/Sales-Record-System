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
        $result = "failed";
    }
    echo $result;
}

function getProduct($id)
{
    global $conn;
    $result = "";

    try
    {
        $stmt = $conn->prepare("SELECT * FROM product p JOIN supplier s ON p.su_id = s.su_id WHERE p.prod_id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt->rowCount() == 1)
        {
            $result += array("message"=>"found");
            $result = json_encode($result);
        }
        else
        {
            $result = json_encode(array("message"=>"not found"));
        }
    }
    catch(PDOException $e)
    {
        $result = json_encode(array("message"=>"failed"));
    }

    echo $result;
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
        $result = "failed";
    }

    echo $result;
}

// Insert Product
if(isset($_POST['insertProduct']))
{
    $name = strip_tags($_POST['productName']);
    $price = strip_tags($_POST['productPrice']);
    $supplier = strip_tags($_POST['supplier']);

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
    $id = strip_tags($_POST['EproductID']);
    $name = strip_tags($_POST['EproductName']);
    $price = strip_tags($_POST['EproductPrice']);
    $supplier = strip_tags($_POST['Esupplier']);

    editProduct($id,$name,$price,$supplier);
}
// Delete Product
else if(isset($_POST['deleteProduct']))
{
    $id = strip_tags($_POST['id']);
    deleteProduct($id);
}
else
{
    die("No Direct Access!");
}
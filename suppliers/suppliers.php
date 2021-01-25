<?php
//SESSION CHECK
session_start();
if(!isset($_SESSION['id'])) {
    die(http_response_code(403));
}

require '../includes/database.php';

function insertSupplier($name,$phone,$email) 
{
    global $conn;
    $result = "";
    try
    {
        $stmt = $conn->prepare("INSERT INTO supplier (su_name,su_phone,su_email) VALUES (?,?,?)");
        $stmt->execute([$name,$phone,$email]);
        $result = "success";
    }
    catch(PDOException $e)
    {
        $result = "failed";
    }

    echo $result;
}

function getSupplier($id)
{
    global $conn;
    $result = "";

    try
    {
        $stmt = $conn->prepare("SELECT * FROM supplier WHERE su_id = ?");
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

function editSupplier($id,$name,$phone,$email)
{
    global $conn;
    $result = "";

    try
    {
        $stmt = $conn->prepare("UPDATE supplier SET su_name = ?, su_phone = ?, su_email = ? WHERE su_id = ?");
        $stmt->execute([$name,$phone,$email,$id]);
        $result = "success";
    }
    catch(PDOException $e)
    {
        $result = "failed";
    }

    echo $result;
}

function deleteSupplier($id)
{
    global $conn;
    $result = "";

    try
    {
        $stmt = $conn->prepare("DELETE FROM supplier WHERE su_id = ?");
        $stmt->execute([$id]);
        $result = "success";
    }
    catch(PDOException $e)
    {
        $result = "failed";
    }

    echo $result;
}

if(isset($_POST['insertSupplier']))
{
    $name = strip_tags($_POST['supplierName']);
    $phone = strip_tags($_POST['supplierPhone']);
    $email = strip_tags($_POST['supplierEmail']);

    insertSupplier($name,$phone,$email);
}
else if(isset($_GET['getSupplier']))
{
    $id = strip_tags($_GET['id']);
    getSupplier($id);
}
else if(isset($_POST['editSupplier']))
{
    $id = strip_tags($_POST['EsupplierID']);
    $name = strip_tags($_POST['EsupplierName']);
    $phone = strip_tags($_POST['EsupplierPhone']);
    $email = strip_tags($_POST['EsupplierEmail']);

    editSupplier($id,$name,$phone,$email);
}
else if(isset($_POST['deleteSupplier']))
{
    $id = strip_tags($_POST['id']);
    deleteSupplier($id);
}
else
{
    die("No Direct Access!");
}

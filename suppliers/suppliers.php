<?php
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
        throw $e->getMessage();
        $result = "failed";
    }

    echo $result;
}

function getSupplier($id)
{
    global $conn;

    try
    {
        $stmt = $conn->prepare("SELECT * FROM supplier WHERE su_id = ?");
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
        throw $e->getMessage();
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
        throw $e->getMessage();
        $result = "failed";
    }

    echo $result;

}

if(isset($_POST['insertSupplier']))
{
    $name = $_POST['supplierName'];
    $phone = $_POST['supplierPhone'];
    $email = $_POST['supplierEmail'];

    insertSupplier($name,$phone,$email);
}
else if(isset($_GET['getSupplier']))
{
    $id = $_GET['id'];
    getSupplier($id);
}
else if(isset($_POST['editSupplier']))
{
    $id = $_POST['EsupplierID'];
    $name = $_POST['EsupplierName'];
    $phone = $_POST['EsupplierPhone'];
    $email = $_POST['EsupplierEmail'];

    editSupplier($id,$name,$phone,$email);
}
else if(isset($_POST['deleteSupplier']))
{
    $id = $_POST['id'];
    deleteSupplier($id);
}
else
{
    die("No Direct Access!");
}

<?php
require_once '../includes/database.php';

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

    return $result;
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

    return $result;
}

function deleteSupplier($id)
{
    global $conn;
    $result = "";
    try
    {
        $stmt = $conn->prepare("DELETE FROM supplier WHERE su_id = ?");
        $stmt->execute([$id]);
        echo "<script>alert('[Success] Supplier Has Been Deleted!');window.location.replace('/suppliers/');</script>";

    }
    catch(PDOException $e)
    {
        throw $e->getMessage();
        echo "<script>alert('[Failed] Supplier Has Not Been Deleted!');</script>";
    }

}

if(isset($_POST['insertSupplier']))
{
    $name = strip_tags($_POST['supplierName']);
    $phone = strip_tags($_POST['supplierPhone']);
    $email = strip_tags($_POST['supplierEmail']);

    echo(insertSupplier($name,$phone,$email));
}
else if(isset($_GET['getSupplier']))
{
    $id = $_GET['id'];
    getSupplier($id);
}
else if(isset($_POST['editSupplier']))
{
    $id = strip_tags($_POST['EsupplierID']);
    $name = strip_tags($_POST['EsupplierName']);
    $phone = strip_tags($_POST['EsupplierPhone']);
    $email = strip_tags($_POST['EsupplierEmail']);

    echo(editSupplier($id,$name,$phone,$email));
}
else if(isset($_GET['deleteSupplier']))
{
    $id = strip_tags($_GET['id']);
    deleteSupplier($id);
}
else
{
    die("No Direct Access!");
}
?>
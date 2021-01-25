<?php
//SESSION CHECK
session_start();
if(!isset($_SESSION['id'])) {
    die(http_response_code(403));
}

require '../includes/database.php';

function insertTransaction($prod_id,$st_id,$tr_qty,$tr_date,$tr_key_in) 
{
    global $conn;
    $result = "";

    try
    {
        $stmt = $conn->prepare("INSERT INTO transaction (prod_id,st_id,tr_qty,tr_date,tr_key_in) VALUES (?,?,?,?,?)");
        $stmt->execute([$prod_id,$st_id,$tr_qty,$tr_date,$tr_key_in]);
        $result = "success";
    }
    catch(PDOException $e)
    {
        $result = "failed";
    }

    echo $result;
}

function getTransaction($id)
{
    global $conn;
    $result = "";

    try
    {
        $stmt = $conn->prepare("SELECT t.tr_id,t.tr_qty,t.tr_date,t.tr_key_in,p.prod_id,p.prod_name,p.prod_price,s.st_username,s.st_id FROM transaction t JOIN product p ON t.prod_id = p.prod_id JOIN staff s ON t.st_id = s.st_id WHERE tr_id = ?");
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

function editTransaction($tr_id,$tr_qty,$tr_date,$tr_key_in)
{
    global $conn;
    $result = "";

    try
    {
        $stmt = $conn->prepare("UPDATE transaction SET tr_qty = ?, tr_date = ?, tr_key_in = ? WHERE tr_id = ?");
        $stmt->execute([$tr_qty,$tr_date,$tr_key_in,$tr_id]);
        $result = "success";
    }
    catch(PDOException $e)
    {
        $result = "failed";
    }

    echo $result;
}

function deleteTransaction($id)
{
    global $conn;
    $result = "";

    try
    {
        $stmt = $conn->prepare("DELETE FROM transaction WHERE tr_id = ?");
        $stmt->execute([$id]);
        $result = "success";
    }
    catch(PDOException $e)
    {
        $result = "failed";

    }

    echo $result;
}

if(isset($_POST['insertTransaction'])) {
    $prod_id = strip_tags($_POST['add_prod_id']);
    $st_id = strip_tags($_POST['add_st_id']);
    $tr_qty = strip_tags($_POST['add_tr_qty']);
    $tr_date = strip_tags($_POST['add_tr_date']);
    $tr_key_in = strip_tags($_POST['add_tr_key_in']);
    
    insertTransaction($prod_id,$st_id,$tr_qty,$tr_date,$tr_key_in);
} 
else if(isset($_GET['getTransaction'])) {
    $id = strip_tags($_GET['id']);
    getTransaction($id);
} 
else if(isset($_POST['editTransaction'])) {
    $tr_id = strip_tags($_POST['edit_tr_id']);
    $tr_qty = strip_tags($_POST['edit_tr_qty']);
    $tr_date = strip_tags($_POST['edit_tr_date']);
    $tr_key_in = strip_tags($_POST['edit_tr_key_in']);

    editTransaction($tr_id,$tr_qty,$tr_date,$tr_key_in);  
} 
else if(isset($_POST['deleteTransaction'])) {
    $id = strip_tags($_POST['id']);
    deleteTransaction($id);
} 
else {
    die("No Direct Access!");
}
<?php
//SESSION CHECK
session_start();
if(!isset($_SESSION['id'])) {
    die(http_response_code(403));
}
else {
    if($_SESSION['role'] != 'Admin')
    {
        die(http_response_code(403));
    }
}

require '../includes/database.php';

function insertStaff($id, $username, $password, $name, $email, $role)
{
    global $conn;
    $result = "";

    try
    {
        // Check if user is exist
        $stmt = $conn->prepare("SELECT * FROM staff WHERE st_id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $check = $stmt->rowCount();

        if($check < 1) 
        {
            $stmt = $conn->prepare("INSERT INTO staff (st_id, st_username, st_password, st_name, st_email) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$id,$username,$password,$name,$email]);

            $stmt = $conn->prepare("INSERT INTO login (st_id,ro_id) VALUES (?,?)");
            $stmt->execute([$id,$role]);

            $result = "success";
        }
        else {
            $result = "exist";
        }
    }
    catch(PDOException $e)
    {
        throw $e;
        $result = "failed";
    }

    echo $result;
}

function getStaff($id)
{
    global $conn;
    $result = "";

    try
    {
        $stmt = $conn->prepare("SELECT s.st_id,s.st_username,s.st_name,s.st_email,r.ro_id,r.ro_name FROM staff s JOIN login l ON s.st_id = l.st_id JOIN role r ON l.ro_id = r.ro_id WHERE s.st_id = :id");
        $stmt->bindValue(':id',$id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt->rowCount() == 1)
        {
            $result += array("message"=>"found");
            $result =  json_encode($result);
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

function editStaff($id, $username, $password, $name, $email, $role)
{
    global $conn;
    $result = "";

    try
    {
        if($password == "")
        {
            $stmt = $conn->prepare("UPDATE staff s JOIN login l ON s.st_id = l.st_id SET s.st_id = :id, s.st_username = :username, s.st_name = :name, s.st_email = :email, l.ro_id = :role WHERE s.st_id = :id");
            $stmt->bindValue(":id",$id);
            $stmt->bindValue(":username",$username);
            $stmt->bindValue(":name",$name);
            $stmt->bindValue(":email",$email);
            $stmt->bindValue(":role",$role);
            $stmt->execute();
            $result = "success";
        }
        else
        {
            $stmt = $conn->prepare("UPDATE staff s JOIN login l ON s.st_id = l.st_id SET s.st_id = :id, s.st_username = :username, s.st_password = :password, s.st_name = :name, s.st_email = :email, l.ro_id = :role WHERE s.st_id = :id");
            $stmt->bindValue(":id",$id);
            $stmt->bindValue(":username",$username);
            $stmt->bindValue(":password",$password);
            $stmt->bindValue(":name",$name);
            $stmt->bindValue(":email",$email);
            $stmt->bindValue(":role",$role);
            $stmt->execute();
            $result = "success";
        }
    }
    catch(PDOException $e)
    {
        $result = "failed";
    }

    echo $result;
}

function deleteStaff($id)
{
    global $conn;
    $result = "";

    try
    {
        $stmt = $conn->prepare("DELETE s FROM staff s JOIN login l ON s.st_id = l.st_id WHERE s.st_id = ?");
        $stmt->execute([$id]);
        $result = "success";
    }
    catch(PDOException $e)
    {
        $result = "failed";
    }

    echo $result;


}

if(isset($_POST['insertStaff'])) 
{
    $id = strip_tags($_POST['staffID']);
    $username = strip_tags($_POST['staffUsername']);
    $password = md5(md5(md5(strip_tags($_POST['staffPassword']))));
    $name = strip_tags($_POST['staffName']);
    $email = strip_tags($_POST['staffEmail']);
    $role = strip_tags($_POST['role']);

    insertStaff($id, $username, $password, $name, $email, $role);
}
else if(isset($_GET['getStaff']))
{
    $id = $_GET['id'];
    getStaff($id);
}
else if(isset($_POST['editStaff'])) 
{
    $id = strip_tags($_POST['EstaffID']);
    $username = strip_tags($_POST['EstaffUsername']);
    $name = strip_tags($_POST['EstaffName']);
    $email = strip_tags($_POST['EstaffEmail']);
    $role = strip_tags($_POST['Erole']);

    if(trim($_POST['EstaffPassword']) != '')
    {
        $password = md5(md5(md5($_POST['EstaffPassword'])));
    }
    else
    {
        $password = "";
    }

    editStaff($id, $username, $password, $name, $email, $role);
}
else if(isset($_POST['deleteStaff']))
{
    $id = strip_tags($_POST['id']);
    deleteStaff($id);
}
else
{
    die("No Direct Access!");
}
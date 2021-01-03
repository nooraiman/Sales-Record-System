<?php
//SESSION CHECK
session_start();
if (!isset($_SESSION['id'])) {
    die(http_response_code(403));
}

require '../includes/database.php';

function insertReports($name, $phone, $email)
{
    global $conn;
    $result = "";
    try {
        $stmt = $conn->prepare("INSERT INTO report (su_name,su_phone,su_email) VALUES (?,?,?)");
        $stmt->execute([$name, $phone, $email]);
        $result = "success";
    } catch (PDOException $e) {
        throw $e->getMessage();
        $result = "failed";
    }

    echo $result;
}

function getReports($id)
{
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT * FROM report WHERE su_id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() == 1) {
            $result += array("message" => "found");
            echo json_encode($result);
        } else {
            echo json_encode(array("message" => "not found"));
        }
    } catch (PDOException $e) {
        throw $e->getMessage();
    }
}

function editReports($id, $name, $phone, $email)
{
    global $conn;
    $result = "";
    try {
        $stmt = $conn->prepare("UPDATE report SET su_name = ?, su_phone = ?, su_email = ? WHERE su_id = ?");
        $stmt->execute([$name, $phone, $email, $id]);
        $result = "success";
    } catch (PDOException $e) {
        throw $e->getMessage();
        $result = "failed";
    }

    echo $result;
}

function deleteReports($id)
{
    global $conn;
    $result = "";

    try {
        $stmt = $conn->prepare("DELETE FROM report WHERE su_id = ?");
        $stmt->execute([$id]);
        $result = "success";
    } catch (PDOException $e) {
        throw $e->getMessage();
        $result = "failed";
    }

    echo $result;
}

if (isset($_POST['insertReports'])) {
    $name = $_POST['reportsName'];
    $phone = $_POST['reportsPhone'];
    $email = $_POST['reportsEmail'];

    insertReports($name, $phone, $email);
} else if (isset($_GET['getReports'])) {
    $id = $_GET['id'];
    getReports($id);
} else if (isset($_POST['editReports'])) {
    $id = $_POST['editReportID'];
    $name = $_POST['editReportName'];
    $phone = $_POST['editReportPhone'];
    $email = $_POST['editReportEmail'];

    editReports($id, $name, $phone, $email);
} else if (isset($_POST['deleteReports'])) {
    $id = $_POST['id'];
    deleteReports($id);
} else {
    die("No Direct Access!");
}

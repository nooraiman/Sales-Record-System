<?php

function getProductCount() {
    global $conn;
    $result = "";

    try
    {
        $stmt = $conn->prepare("SELECT * FROM product");
        $stmt->execute();
        $result = $stmt->rowCount();
    }
    catch(PDOException $e)
    {
        $result = json_encode(array("message"=>"failed"));
    }

    return $result;
}

function getSupplierCount() {
    global $conn;
    $result = "";

    try
    {
        $stmt = $conn->prepare("SELECT * FROM supplier");
        $stmt->execute();
        $result = $stmt->rowCount();
    }
    catch(PDOException $e)
    {
        $result = json_encode(array("message"=>"failed"));
    }

    return $result;
}

function getTransactionCount() {
    global $conn;
    $result = "";

    try
    {
        $stmt = $conn->prepare("SELECT * FROM transaction WHERE month(tr_date) = ?");
        $stmt->execute([date('m')]);
        $result = $stmt->rowCount();
    }
    catch(PDOException $e)
    {
        $result = json_encode(array("message"=>"failed"));
    }

    return $result;
}

function getSalesMonth() { 
    global $conn;

    try
    {
        $stmt = $conn->prepare("SELECT (p.prod_price*t.tr_qty) AS total_price FROM transaction t JOIN product p ON t.prod_id=p.prod_id WHERE month(t.tr_date) = ? AND year(t.tr_date) = ?");
        $stmt->execute([date('m'), date('Y')]);
        $total = 0;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $total += ($row['total_price']);
        }
    }
    catch(PDOException $e)
    {
        $total = json_encode(array("message"=>"failed"));
    }

    return $total;
}

function getSalesForMonth($month) { 
    global $conn;

    try
    {
        $stmt = $conn->prepare("SELECT (p.prod_price*t.tr_qty) AS total_price FROM transaction t JOIN product p ON t.prod_id=p.prod_id WHERE month(t.tr_date) = ? AND year(t.tr_date) = ?");
        $stmt->execute([$month, date('Y')]);
        $total = 0;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $total += ($row['total_price']);
        }
    }
    catch(PDOException $e)
    {
        $total = json_encode(array("message"=>"failed"));
    }

    return $total;
}

function getSales() { 
    global $conn;

    try
    {
        $stmt = $conn->prepare("SELECT (p.prod_price*t.tr_qty) AS total_price FROM transaction t JOIN product p ON t.prod_id=p.prod_id WHERE year(t.tr_date) = ?");
        $stmt->execute([date('Y')]);
        $total = 0;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $total += ($row['total_price']);
        }
    }
    catch(PDOException $e)
    {
        $total = json_encode(array("message"=>"failed"));
    }

    return $total;
}

function getSupplierSales() {
    global $conn;
    $result = [];

    try {
        $stmt = $conn->prepare("SELECT s.su_name, COUNT(t.tr_qty) AS qty_sold FROM transaction t JOIN product p ON p.prod_id = t.prod_id JOIN supplier s ON p.su_id = s.su_id WHERE year(t.tr_date) = ? GROUP BY s.su_name");
        $stmt->execute([date('Y')]);
        $array = $stmt->fetchAll();
        foreach($array as $r) {
            array_push($result, $r);
        }
    } catch(PDOException $e) 
    {
        $result = array("message"=>"failed");
    }

    return $result;
}
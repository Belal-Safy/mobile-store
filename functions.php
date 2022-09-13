<?php

function toFixed($number, $decimals) {
    return number_format($number, $decimals, '.', "");
}

function removeElementWithValue($array, $key, $value){
    foreach($array as $subKey => $subArray){
        if($subArray[$key] == $value){
        unset($array[$subKey]);
    }
}
    return $array;
}

function updateElementWithValue($array, $key, $value, $quantity){
    foreach($array as $subKey => $subArray){
        if($subArray[$key] == $value){
            $array[$subKey]['quantity'] = $quantity;
        }
    }
    return $array;
}

function getTotalPrice($cart,$conn){
    $sum = 0;
    foreach($cart as $value) {
    $quantity = $value['quantity'];

    $id = $value['product_id'];
    $sql = "SELECT price FROM products where product_id = $id";

    $result = $conn->query($sql);
    $price = $result->fetch_assoc()['price'];
    $sum += $price * $quantity * 0.75;
    }
    return $sum;
}

?>
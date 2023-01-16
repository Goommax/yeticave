<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
ini_set('error_log', __DIR__ . '/php-errors.log');
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("db_queries.php");


$sql = cat_query();
$res = mysqli_query($con, $sql);
if ($res) {
$categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
$error = mysqli_error($con);
}

$sql = goods_list_query();
$res = mysqli_query($con, $sql);
if ($res) {
$inform = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
$error = mysqli_error($con);
}

$page_content = include_template("main.php", [
   'categories' => $categories,
   'inform' => $inform
]);

$layout_content = include_template("layout.php", [
   'content' => $page_content,
   'categories' => $categories,
   'title' => "Главная",
   'is_auth' => $is_auth,
   'user_name' => $user_name
]);

print($layout_content);

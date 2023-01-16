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
$categories = get_query_category_list($con);
$categories_id = array_column($categories, "id");
$page_content = include_template("sign-up.php", [
 'categories' => $categories,
 ]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $required = ["email", "name", "password", "message"];
  $errors = [];
  $rules = [
    "email" => function ($value) {
      return val_email($value);
    },

    "name" => function ($value) {
      return val_length($value, 2, 100);
    },
    "password" => function ($value) {
      return val_length($value, 8, 1000);
    },
    "message" => function ($value) {
      return val_length($value, 10, 10000);
    }
  ];
  $user = filter_input_array(
    INPUT_POST,
    [
      "email" => FILTER_DEFAULT,
      "name" => FILTER_DEFAULT,
      "password" => FILTER_DEFAULT,
      "message" => FILTER_DEFAULT
    ],
    true
  );

  foreach ($user as $field => $value) {
    if (isset($rules[$field])) {
      $rule = $rules[$field];
      $errors[$field] = $rule($value);
    }
    if (in_array($field, $required) && empty($value)) {
      $errors[$field] = "Это поле нужно заполнить";
    }
  }

  $errors = array_filter($errors);

  if (count($errors)) {
    $page_content = include_template("sign-up.php", [
      'categories' => $categories,
      'user' => $user,
      'errors' => $errors
    ]);
  } else {
    $users_data = users_data_query($con);
    $emails = array_column($users_data, "email");
    $names = array_column($users_data, "name");
    if (in_array($user["email"], $emails)) {
      $errors["email"] = "Пользователь с таким е-mail уже зарегистрирован";
    }
    if (in_array($user["name"], $names)) {
      $errors["name"] = "Пользователь с таким именем уже зарегистрирован";
    }
    if (count($errors)) {
      $page_content = include_template("sign-up.php", [
        "categories" => $categories,
        "user" => $user,
        "errors" => $errors
      ]);
    } else {

      $sql = user_reg_query();
      $user["password"] = password_hash($user["password"], PASSWORD_DEFAULT);
      $stmt = db_get_prepare_stmt($con, $sql, $user);
      $res = mysqli_stmt_execute($stmt);
      if ($res) {
        header("Location: /login.php");
      } else {
        $error = mysqli_error($con);
      }

    }
  }
}

$layout_content = include_template("layout.php", [
   'content' => $page_content,
   'categories' => $categories,
   'title' => "Регистрация",
   'is_auth' => $is_auth,
   'user_name' => $user_name
]);

print($layout_content);
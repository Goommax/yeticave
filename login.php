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
$page_content = include_template("log_in.php", [
 'categories' => $categories,
 ]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ["email", "password"];
    $errors = [];
    $rules = [
        "email" => function ($value) {
            return val_email($value);
        },

        'password' => function ($value) {
            return val_length($value, 8, 1000);
        },
    ];
    $user_login = filter_input_array(
        INPUT_POST,
        [
            "email" => FILTER_DEFAULT,
            'password' => FILTER_DEFAULT,
        ],
        true
    );

    foreach ($user_login as $field => $value) {
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
        $page_content = include_template("log_in.php", [
            'categories' => $categories,
            'user_login' => $user_login,
            'errors' => $errors
        ]);
    } else {
        $users_data = get_login_query($con, $user_login['email']);
      
        if ($users_data) {
            if (password_verify($user_login["password"], $users_data['user_password'])) {
                session_start();
                $_SESSION['name'] = $users_data['user_name'];
                $_SESSION['id'] = $users_data['id'];

                header("Location: /index.php");
            } else {
                $errors["password"] = "Вы ввели неверный пароль";
            }
        } else {
            $errors["email"] = "Пользователь с таким E-mail не зарегистрирован";
        }
        if (count($errors)) {
            $page_content = include_template("log_in.php", [
                'categories' => $categories,
                'user_login' => $user_login,
                'errors' => $errors
            ]);
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
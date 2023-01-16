<?php
function goods_list_query() {
return "SELECT l.id, l.title, l.img, l.start_price, l.date_finish, c.name_category
  FROM lots l JOIN categories c ON l.category_id = c.id ORDER BY date_creation DESC;";
}

function cat_query() {
return "SELECT id, character_code, name_category FROM categories;";}

function lot_query($lot_id) {
return "SELECT l.id, l.title, l.start_price, l.img, l.lot_description, l.date_finish, c.name_category FROM lots l
JOIN categories c ON l.category_id = c.id WHERE l.id = $lot_id;";}

function lot_add_query($user_id) {
  return "INSERT INTO lots (title, category_id, lot_description, start_price, step, date_finish, img, user_id)
  VALUES (?, ?, ?, ?, ?, ?, ?, $user_id);";}

function get_query_category_list($con)
{
    $sql = "SELECT id, character_code, name_category FROM categories";
    $cat_res = mysqli_query($con, $sql);
    if ($cat_res) {
        return mysqli_fetch_all($cat_res, MYSQLI_ASSOC);
    } else {
        return mysqli_error($con);
    }
}

function user_reg_query () {
  return "INSERT INTO users (date_registration, email, user_name, user_password, contacts) VALUES (NOW(), ?, ?, ?, ?);";
}

function users_data_query($con) {
  if (!$con) {
    $error = mysqli_connect_error();
    return $error;
  }
  else {
    $sql = "SELECT email, user_name FROM users";
    $result = mysqli_query($con, $sql);
    if ($result) {
      $users_data = get_arrow($result);
      return $users_data;
    }
    $error = mysqli_error($con);
    return $error;
  }
}
function get_login_query($con, $email) {
  if (!$con) {
  $error = mysqli_connect_error();
  return $error;
  } else {
      $sql = "SELECT id, email, user_name, user_password FROM users WHERE email = '$email'";
      $result = mysqli_query($con, $sql);
      if ($result) {
          $users_data= get_arrow($result);
          return $users_data;
      }
      $error = mysqli_error($con);
      return $error;
  }
}
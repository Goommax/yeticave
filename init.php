<?php
$con = mysqli_connect("localhost", "root", "root", "yeticavedb");
mysqli_set_charset($con, "utf8");
if (!$con) {
  $error = mysqli_connect_error();
  die();
}

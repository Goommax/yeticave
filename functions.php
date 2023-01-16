<?php
/**
*Функция формата цены, которую я перенес из ранее сделанного задания в надежде
*на то что она будет ровног вызываться из этого файла после шаблонизации проекта
*/
function form_price($f_price) {
  $f_price = ceil($f_price);
  if ($f_price>=1000) {
    $f_price = number_format($f_price, 0, '', ' ');
  }
  return $f_price .' ' . '&#x20bd';
}
/**
*Функция счетчика времени до истечения действия лота
*/
function time_left($lotdate)
{
    date_default_timezone_set('Europe/Moscow');
    $final_date = date_create($lotdate);
    $cur_date = date_create("now");
    $diff = date_diff($final_date, $cur_date);
    $format_diff = date_interval_format($diff, "%d %H %I");
    $arr = explode(" ", $format_diff);

    $hours = $arr[0] * 24 + $arr[1];
    $minutes = intval($arr[2]);
    $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
    $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);
    $res[] = $hours;
    $res[] = $minutes;

    return $res;
}

/*Функция валидации числового значения в поле формы*/
function val_number($value)
{
    if (is_numeric($value)) {
        if (!empty($value)) {
            $value = $value * 1;
            if (is_int($value) && $value > 0) {
                return NULL;
            } else {
                return 'Содержимое поля должно быть целым числом больше нуля';
            }
        }
    } else {
        return 'Содержимое поля должно быть целым числом больше нуля';
    }
};

/*Функция валидации даты*/
function val_date($date) {
  if (is_date_valid($date)) {
    $cur_date = date_create('now');
    $d = date_create($date);
    $dif = date_diff($d, $cur_date);
    $days = date_interval_format($dif, '%d');
    if ($days < 1) {
      return "Дата должна быть больше текущей, минимум на 1 день";
    }
  } else {
    return "Укажите дату в формате «ГГГГ-ММ-ДД»";
  }
  }

/*Функция валидации категории*/
function val_category($id, $allowed_list) {
  if (!in_array($id, $allowed_list)) {
    return "Такой категории в списке нет";
  }
  return null;
}

/*Функция валидации длины записи*/

function val_length($value, $min, $max)
{
  if ($value) {
    $len = strlen($value);
    if($len < $min or $len > $max) {
      return "Запись должна быть от $min до $max символов";
    }
  }
}

/*Функция валидации e-mail адреса */

function val_email($value) {
if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
    return "Некорректный e-mail адрес";
}
}

/**
 * Возвращает массив из объекта результата запроса
 * @param object $result_query mysqli Результат запроса к базе данных
 * @return array
 */
function get_arrow ($result_query) {
  $row = mysqli_num_rows($result_query);
  if ($row === 1) {
      $arrow = mysqli_fetch_assoc($result_query);
  } else if ($row > 1) {
      $arrow = mysqli_fetch_all($result_query, MYSQLI_ASSOC);
  }

  return $arrow;
}
function db_get_prepare_stmt_version($link, $sql, $data = []) {
  $stmt = mysqli_prepare($link, $sql);

  if ($stmt === false) {
      $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
      die($errorMsg);
  }

  if ($data) {
      $types = '';
      $stmt_data = [];

      foreach ($data as $key => $value) {
          $type = 's';

          if (is_int($value)) {
              $type = 'i';
          }
          else if (is_double($value)) {
              $type = 'd';
          }

          if ($type) {
              $types .= $type;
              $stmt_data[] = $value;
          }
      }

      $values = array_merge([$stmt, $types], $stmt_data);
      mysqli_stmt_bind_param(...$values);

      if (mysqli_errno($link) > 0) {
          $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
          die($errorMsg);
      }
  }

  return $stmt;
}

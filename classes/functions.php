<?php

/**
 * Returns escaped text for display
 *
 * @param $unescaped_text
 * @return string escaped text
 */
function e($unescaped_text)
{
  return htmlentities($unescaped_text, ENT_QUOTES, "UTF-8");
}

/**
 * Echoes escaped text
 *
 * @param $unescaped_text
 */
function ee($unescaped_text)
{
  echo e($unescaped_text);
}

/**
 * Returns mysqli-escaped string
 *
 * @param $unescaped
 * @return string
 */
function escape($unescaped)
{
  return DB::l()->real_escape_string($unescaped);
}

function show_flash_message()
{
  if (isset($_SESSION['flash_message'])) {
    ?>
    <div class="flash-message bg-<?php ee($_SESSION['flash_status']) ?>">
      <?php ee($_SESSION['flash_message']); ?>
    </div>
    <?php

    unset($_SESSION['flash_status']);
    unset($_SESSION['flash_message']);
  }
}

function generateRandomString($length = 6)
{
  $characters = '123456789';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

function exit_with_error_json($error_text)
{
  global $json; // TODO: remove for dist
  $json['status'] = "error";
  $json['message'] = $error_text;
  echo json_encode($json);
  die();
}

function starts_with($string, $needle)
{
  return substr($string, 0, strlen($needle)) == $needle;
}

// Fix for older PHP versions
if (!function_exists('array_column')) {
  function array_column(array $input, $columnKey, $indexKey = null)
  {
    $array = array();
    foreach ($input as $value) {
      if (!isset($value[$columnKey])) {
        trigger_error("Key \"$columnKey\" does not exist in array");
        return false;
      }
      if (is_null($indexKey)) {
        $array[] = $value[$columnKey];
      } else {
        if (!isset($value[$indexKey])) {
          trigger_error("Key \"$indexKey\" does not exist in array");
          return false;
        }
        if (!is_scalar($value[$indexKey])) {
          trigger_error("Key \"$indexKey\" does not contain scalar value");
          return false;
        }
        $array[$value[$indexKey]] = $value[$columnKey];
      }
    }
    return $array;
  }
}

if (!function_exists('http_response_code')) {
  function http_response_code($newcode = NULL)
  {
    static $code = 200;
    if ($newcode !== NULL) {
      header('X-PHP-Response-Code: ' . $newcode, true, $newcode);
      if (!headers_sent())
        $code = $newcode;
    }
    return $code;
  }
}
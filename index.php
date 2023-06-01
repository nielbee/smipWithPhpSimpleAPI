<?php
error_reporting(0);
// (A) SETTINGS
define("URL_BASE", "/");
define("PATH_PAGES", __DIR__ . DIRECTORY_SEPARATOR . "api/endpoint" . DIRECTORY_SEPARATOR);
 
// (B) PARSE URL PATH INTO AN ARRAY
// e.g. http://site.com > [""]
// e.g. http://site.com/foo > ["foo"]
// e.g. http://site.com/foo/bar > ["foo", "bar"]
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
if (substr($path, 0, strlen(URL_BASE)) == URL_BASE) {
  $path = substr($path, strlen(URL_BASE));
}
$path = explode("/", rtrim($path, "/\\"));

// (C) LOAD REQUESTED PAGE ACCORDINGLY
// (C1) URL PATH TO PHYSICAL FILE
// e.g. http://site.com > index.html
// e.g. http://site.com/foo > foo.html
// e.g. http://site.com/foo/bar > foo-bar.html
if (count($path)==1) { 
  $file = $path[0]=="" ? "index.php" : $path[0] . ".php"; 
} else {
  $file = implode("-", $path) . ".php"; 
}

// (C2) LOAD PHYSICAL FILE
if (file_exists(PATH_PAGES . $file)) { require PATH_PAGES . $file; }
else {
  http_response_code(404);
  require PATH_PAGES . "404.php";
}
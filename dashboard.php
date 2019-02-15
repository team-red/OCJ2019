<?php
session_name("peanutbutterandjelly");
session_start();
// this is just the template
if (!isset($_SESSION["logged_in"])){
    // AGAIN, EXIT always after header()
    header("location: index.php");
    exit();
}
require_once("utils/helper/utils.php");
require_once("utils/helper/dashboard_utils.php");

// this part can be ignored, for the moment there is one page for Dashboard
// this would be useful to make it more interactive later
if (isset($_GET["page"]) && check_page($_GET["page"], $pages)) {
    $active_page = $_GET["page"];
} else {
    $active_page = $default_page["name"];
}
require_once("utils/database.php");
$dbh = Database::connect();
require_once("utils/profile/user.php");
if (isset($_SESSION["email"])){
    $user = User::fromEmail($dbh, $_SESSION["email"]);
} else {
    // _SESSION information corrupted
    // logging out
    session_unset();
    session_destroy();
    header("location: index.php");
    exit();
}
$isAdmin = ($user->role) === "admin"; // should be improved
if (is_admin_exclusive($active_page, $pages) && $isAdmin === false)
{
    $active_page = $default_page["name"];
}

if ($active_page === "logout"){
  require_once("content/dashboard/content_logout.php");
}


?>

<!DOCTYPE html>
<html lang="fr-FR">
<?php generate_header($active_page, "css/dashboard.css", "js/dashboard.js", $pages); ?>

<body>
<div class="app">

<?php
generate_header_tag();
generate_sidebar($active_page, $pages, $isAdmin);
?>

<!-- Main -->
<div class="app-main">
<?php require_once("content/dashboard/content_".$active_page.".php"); ?>
</div>
</div>


<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<?php
$dbh = null;
?>

</html>

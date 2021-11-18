<?
session_start();
require_once('dbController.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    echo 'Нет доступа';
    die();
}

if (isset($_POST) && isset($_POST['id'])) {
    $db = new dbController();
    $id = (int) $_POST['id'];
    $row = $db->getItem($id);
    $img = $row['img'];
} else {
    die();
}

$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/img/';
$uploadfile = $uploaddir . str_replace(" ", "-", basename($_FILES['image']['name']));

if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
    unlink($_SERVER['DOCUMENT_ROOT'] . "/" . $img);
    $img = "img/" . str_replace(" ", "-", basename($_FILES['image']['name']));
}

$type = (int) $_POST['product-type'];
$title = trim($_POST['title']);
$description = trim($_POST['description']);
$vendor = (int) ($_POST['vendor-type']);
$price = (int) $_POST['price'];
$db->updateItem($id, $type, $title, $description, $vendor, $price, $img);

header('Location: /item-info.php?id=' . $id);
?>

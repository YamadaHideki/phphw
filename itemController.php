<?
session_start();
require_once('dbController.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    echo 'Нет доступа';
    die();
}

$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/img/';
$uploadfile = $uploaddir . str_replace(" ", "-", basename($_FILES['image']['name']));

if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
    if (isset($_POST)) {
        $type = (int) $_POST['product-type'];
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $vendor = (int) ($_POST['vendor-type']);
        $price = (int) $_POST['price'];
        $img = "img/" . str_replace(" ", "-", basename($_FILES['image']['name']));
        $db = new dbController();
        $db->addItem($type, $title, $description, $vendor, $price, $img);
    }
} else {
    echo "Возможная атака с помощью файловой загрузки!\n";
}

header('Location: /index.php');
?>

<?
session_start();
require_once('dbController.php');
$db = new dbController();
if (isset($_SESSION) && $_SESSION['role'] == 1 && $_POST['productId']) {
    $row = $db->getRate($_SESSION['user_id'], (int) $_POST['productId']);
    echo json_encode($row['rate']);
}
if (isset($_SESSION) && $_SESSION['role'] == 1 && isset($_POST['rate']) && isset($_POST['productId'])) {
    $rate = (int) $_POST['rate'];
    $productId = (int) $_POST['productId'];
    if ($rate <= 5 && $rate >= 0) {
        $db->addNewRate($_SESSION['user_id'], $productId, $rate);
    }
} else {
    die();
}
?>

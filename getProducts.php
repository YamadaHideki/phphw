<?
require_once('dbController.php');
$db = new dbController();
$result = $db->getRowsInDb('products');
echo json_encode($result);
?>

<?
require_once('dbController.php');
$db = new dbController();
$result = $db->getRowsInDb('products');
$vendors = $db->getRowsInDb('vendors');
$typeOfProducts = $db->getRowsInDb('type_of_products');
for ($i = 0; $i < count($result); $i++) {
    foreach ($vendors as $v) {
        if ($v['id'] == $result[$i]['product_type_id']) {
            $result[$i]['vendor_name'] = $v['name'];
        }
    }
    foreach ($typeOfProducts as $t) {
        if ($t['id'] == $result[$i]['product_type_id']) {
            $result[$i]['product_type_name'] = $t['name'];
        }
    }
    $result[$i]['rate'] = $db->getMiddleRate($result[$i]['id']);
}
var_dump($result);
//echo json_encode($result);
?>

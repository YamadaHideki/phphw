<?
session_start();
require_once('theme.php');
require_once('dbController.php');
if (!isset($_GET['id'])) {
    die();
}
$db = new dbController();
$item = $db->getItem((int) $_GET['id']);
?>
<div class="item-info">
    <div class="item-info-top-block">
        <div class="item-info-img">
            <img src="<?=$item['img'];?>" alt="" width="300px"></img>
        </div>
        <div class="item-info-right-block">
            <div class="item-info-product-name"><b><?=$item['type_of_product'];?></b></div>
            <div class="item-info-title"><?=$item['title'];?></div>
            <div class="item-info-vendor">Производитель: <?=$item['vendor'];?></div>
            <div class="item-info-price">Цена: <b><?=$item['price'];?> руб.</b></div>
        </div>
    </div>
    <div class="item-info-under-block">
        <div class="item-info-description">
            <?=$item['description'];?>
        </div>
    </div>
</div>

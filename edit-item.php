<?
require_once('theme.php');
require_once('dbController.php');
if(!empty($_SESSION) && $_SESSION['role'] == 0 && isset($_GET['id'])) {
    $db = new dbController();
    $row = $db->getItem((int) $_GET['id']);
} else {
    echo "Нет доступа!";
    die();
}
?>
<form class="form-style" action="editItemController.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?=$row['id'];?>">
    <select class="form-options" name="product-type">
        <?
        $db = new dbController();
        $result = $db->getRowsInDb("type_of_products");
        foreach ($result as $value) {
            ?>
            <option value="<?echo $value['id'];?>"
                    <?
                    if ($value['id'] == $row['product_type_id']) {
                        ?>
                        selected="selected"
                        <?
                    }
                    ?>
            >
                <?echo $value['name'];?>
            </option>
            <?
        }
        ?>
    </select>
    <input type="text" name="title" required placeholder="Наименование продукта" autocomplete="off" value="<?=$row['title'];?>">
    <textarea class="form-options-area" name="description" cols="30" rows="10" placeholder="Описание продукта" required autocomplete="off"><?=$row['description'];?>
    </textarea>
    <select class="form-options" name="vendor-type">
        <?
        $result = $db->getRowsInDb("vendors");
        foreach ($result as $value) {
            ?>
            <option value="<?echo $value['id'];?>"
                <?
                if ($value['id'] == $row['vendor_type_id']) {
                    ?>
                    selected="selected"
                    <?
                }
                ?>
            >
                <?echo $value['name'];?>
            </option>
            <?
        }
        ?>
    </select>
    <input type="text" name="price" required placeholder="Цена" autocomplete="off" value="<?=$row['price'];?>">
    <img src="<?=$row['img'];?>" width="100px" style="margin: 0 auto 10px auto">
    <input type="file" name="image" accept=".png, .jpg, .jpeg">
    <input type="submit" name="submit" value="Изменить">
</form>

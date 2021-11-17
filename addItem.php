<?
require_once('theme.php');
require_once('dbController.php');
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    echo 'Нет доступа';
    die();
}
?>
<form class="form-style" action="itemController.php" method="POST" enctype="multipart/form-data">
    <select class="form-options" name="product-type">
    <?
    $db = new dbController();
    $result = $db->getRowsInDb("type_of_products");
    foreach ($result as $value) {
        ?>
        <option value="<?echo $value['id'];?>"><?echo $value['name'];?></option>
        <?
    }
    ?>
    </select>
    <input type="text" name="title" required placeholder="Наименование продукта" autocomplete="off">
    <textarea class="form-options-area" name="description" cols="30" rows="10" placeholder="Описание продукта" required autocomplete="off"></textarea>
    <input type="text" name="vendor" required placeholder="Производитель" autocomplete="off">
    <input type="text" name="price" required placeholder="Цена" autocomplete="off">
    <input type="file" name="image" required accept=".png, .jpg, .jpeg">
    <input type="submit" name="submit" value="Добавить">
</form>
</body>
</html>

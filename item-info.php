<?
require_once('theme.php');
require_once('dbController.php');
if (!isset($_GET['id'])) {
    die();
} else {
    $db = new dbController();
    $item = $db->getItem((int) $_GET['id']);
    if (!$item) {
        die();
    }
}
?>
<div class="item-info">
    <div id="product-id" hidden><?=$item['id'];?></div>
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
        <?
        if (isset($_SESSION) && $_SESSION['role'] == 1) {
            ?>
            <div class="rate">
                <span id="rate-title">Ваша оценка:</span>
                <div class="rating">0</div>
                <div class="rating">1</div>
                <div class="rating">2</div>
                <div class="rating">3</div>
                <div class="rating">4</div>
                <div class="rating">5</div>
            </div>
            <?
        }
        if (!empty($_SESSION) && $_SESSION['role'] == 0) {
            ?>
            <div class="edit-info">
                <a href="/edit-item.php?id=<?=$item['id'];?>">изменить инфо</a>
            </div>
            <?
        }
        ?>
    </div>
    <div class="item-info-under-block">
        <div class="item-info-description">
            <?=$item['description'];?>
        </div>
    </div>
</div>
<script>
    if ($('.rate').length) {
        var productId = $('#product-id').text();
        $.ajax({
            method: "POST",
            url: "newRate.php",
            data: {productId: productId},
            success(data) {
                json = JSON.parse(data);
                $('.rating').each(function () {
                    if ($(this).text() === json) {
                        $(this).addClass('rate-clicked');
                    }
                })
            }
        })
        $('.rating').on('click', function () {
            var item = $(this);
            var rate = item.text();
            $.ajax({
                method: "POST",
                url: "newRate.php",
                data: {rate: rate, productId: productId},
                success(data) {
                    $('.rating').removeClass('rate-clicked');
                    item.addClass('rate-clicked');
                }
            })
            console.log($(this).text());
        })
    }
</script>
</body>
</html>

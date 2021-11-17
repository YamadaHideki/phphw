<?
session_start();
require_once('dbController.php');
require_once('theme.php');
$db = new dbController();
$result = $db->getRowsInDb("products");
?>
<div class="items-controll">
    <div class="sort-controll">
        <div class="sort">
            Сортировка:
            <select name="sort-by-price" id="sort-by-price">
                <option value="price-down" selected="selected">Сначала недорогие</option>
                <option value="price-up">Сначала дорогие</option>
                <option value="rate-up">Сначала с лучшей оценкой</option>
                <option value="rate-down">Сначала с худшей оценкой</option>
            </select>
        </div>
    </div>
    <div id="items"></div>
</div>

<script>
    var json = '';
    $.ajax({
        method: "POST",
        url: "getProducts.php",
        success(data) {
            json = JSON.parse(data, false);
            sortData(json, "down", "price");
            /*son = filterByVendor(json, ['amd','intel']);
            console.log(json);*/
            drawNewData(json);
        }
    });

    function sortData(data, upDown, optionName) {
        switch (optionName) {
            case 'price':
                if (upDown === "up") {
                    data.sort((a, b) => b.price - a.price);
                }
                if (upDown === "down") {
                    data.sort((a, b) => a.price - b.price);
                }
                break;
            case 'star':
                if (upDown === "up") {
                    data.sort((a, b) => b.star - a.star);
                }
                if (upDown === "down") {
                    data.sort((a, b) => a.star - b.star);
                }
                break;
        }
    }

    function filterByVendor(data, vendor) {
        return data.filter(function (e) {
            var myBoolean;
            for (var i = 0; i < vendor.length; i++) {
                if (!myBoolean) {
                    myBoolean = e.vendor.toLowerCase() === vendor[i].toLowerCase();
                }
            }
            return myBoolean;
        })
    }



    function drawNewData(data) {
        var items = document.getElementById('items');
        var result = '';
        for (var i = 0; i < data.length; i++) {
            result += "<div class='item' id='"+ data[i].id +"'>";
            console.log(data[i].img);
            result += "<img src="+data[i].img+" width='150px'>";
            result += "<div class='item-title'>"+ data[i].title +"</div>";
            //result += "<div class='description'>"+ data[i].description +"</div>";
            //result += "<div class='item-vendor'>"+ data[i].vendor +"</div>";
            result += "<div class='item-price'>"+ data[i].price +" руб.</div>";
            result += "</div>";
        }
        items.innerHTML = result;
    }

    const selectPrice = document.querySelector('#sort-by-price');

    selectPrice.addEventListener("change", function() {
        const element = document.querySelector('#sort-by-price');
        const split = element.value.split("-");
        sortData(json, split[1], split[0]);
        drawNewData(json);
    });

</script>
</body>
</html>
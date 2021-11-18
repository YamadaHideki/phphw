<?
session_start();
require_once('dbController.php');
require_once('theme.php');
$db = new dbController();
$result = $db->getRowsInDb("products");
?>
<div class="items-controll">
    <div class="filter-controll">
        <div class="filter">
            <?
            $vendors = $db->getRowsInDb("vendors");
            foreach ($vendors as $item) {
                ?>
                <div class="filter-checkbox">
                    <input id="<?=$item['name'];?>" type="checkbox" class="filter-input-checkbox cp" name="<?=$item['name'];?>" value="<?=$item['id'];?>" checked>
                    <label class="cp" for="<?=$item['name'];?>"><?=$item['name'];?></label>
                </div>
                <?
            }
            ?>
        </div>
    </div>

    <div class="products">
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
</div>

<script>
    var json = '';
    var filteredData = '';
    $.ajax({
        method: "POST",
        url: "getProducts.php",
        success(data) {
            json = JSON.parse(data, false);
            filteredData = json;
            sortData(filteredData, "down", "price");
            drawNewData(filteredData);
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
            case 'rate':
                if (upDown === "up") {
                    data.sort((a, b) => b.rate - a.rate);
                }
                if (upDown === "down") {
                    data.sort((a, b) => a.rate - b.rate);
                }
                break;
        }
    }

    function filterByVendor(data, vendor) {
        return data.filter(function (e) {
            var myBoolean = false;
            for (var i = 0; i < vendor.length; i++) {
                if (!myBoolean) {
                    myBoolean = e.vendor_type_id === vendor[i];
                }
            }
            return myBoolean;
        })
    }

    function drawNewData(data) {
        var items = document.getElementById('items');
        var result = '';
        for (var i = 0; i < data.length; i++) {
            result += "<a class='item-href' href='/item-info.php?id=" + data[i].id + "'><div class='item' id='"+ data[i].id + "'>";
            result += "<div class='item-img'><img src="+data[i].img+" width='150px'></div>";
            result += "<div class='item-m-options'>";
            result += "<div class='item-title'>" + data[i].product_type_name + ": " + data[i].title +"</div>";
            result += "<div class='item-vendor'>Производитель: " + data[i].vendor_name + "</div>";
            result += "</div>";
            result += "<div class='item-vendor' hidden>"+ data[i].vendor_type_id +"</div>";
            result += "<div class='item-r-options'>";
            result += "<div class='item-price'>"+ data[i].price + " руб.</div>";
            result += "<div class='item-rate'>Сред. оценка: "+ data[i].rate + "</div>";
            result += "</div>";
            result += "</div></a>";
        }
        items.innerHTML = result;
    }

    const selectPrice = document.querySelector('#sort-by-price');
    const filterVendor = document.querySelectorAll('.filter-input-checkbox');

    var sortSettings = [];
    var filterSettings = [];

    filterVendor.forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
            filterSettings = Array.from(filterVendor)
                .filter(i => i.checked)
                .map(i => i.value);
            var filterNewArray = filterByVendor(json, filterSettings);
            sortData(filterNewArray, sortSettings[1], sortSettings[0]);
            filteredData = filterNewArray;
            drawNewData(filteredData);
        });
    });

    selectPrice.addEventListener("change", function() {
        const element = document.querySelector('#sort-by-price');
        sortSettings = element.value.split("-");
        sortData(filteredData, sortSettings[1], sortSettings[0]);
        drawNewData(filteredData);
    });

</script>
</body>
</html>
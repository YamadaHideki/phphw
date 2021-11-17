<?
session_start();
require_once('dbController.php');
require_once('theme.php');
$db = new dbController();
$result = $db->getRowsInDb("products");
?>
<div id="items">
    <?/*
    foreach ($result as $item) {
        */?><!--
        <div class="item">
            <img src="<?/*echo $item['img'];*/?>" alt="" width="200px">
            <div class="title"><?/*echo $item['title'];*/?></div>
            <div class="description"><?/*echo $item['description'];*/?></div>
            <div class="price"><?/*echo $item['price'];*/?></div>
        </div>
        --><?/*
    }
    */?>
</div>
<script>
    $.ajax({
        method: "POST",
        url: "getProducts.php",
        success(data) {
            var json = JSON.parse(data, false);
            sortData(json, "down", "price");
            json = filterByVendor(json, ['amd','intel']);
            console.log(json);
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
            result += "<div class='item'>";
            result += "<img src="+data[i].img+" width='200px'>";
            result += "<div class='title'>"+ data[i].title +"</div>";
            result += "<div class='description'>"+ data[i].description +"</div>";
            result += "<div class='vendor'>"+ data[i].vendor +"</div>";
            result += "<div class='price'>"+ data[i].price +"</div>";
            result += "</div>";
        }
        items.innerHTML = result;
    }

</script>
</body>
</html>
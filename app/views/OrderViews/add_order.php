<div class="order-container child-component">
    <div class="left-content">
        <div class="food">
            <div class="title">
                <h3>Chọn món: </h3>
            </div>
            <div class="test">
                <?php echo isset($list_food001) ? ($list_food001) : ''; ?>
            </div>
            <div class="content">
                <?php
                foreach ($list_food as $key => $value) { ?>
                                <a class="item card food-item" data-food="<?php echo $value['name'] ?>">
                                    <?php
                                    if (isset($value['imageName'])) { ?>
                                                    <img src="<?php echo _WEB_ROOT ?>/public/static/imgs/uploadfiles/<?php echo $value['imageName'] ?>"
                                                        class="card-img-top">
                                                    <?php
                                    } else {
                                        ?>
                                                    <img src="<?php echo _WEB_ROOT ?>/public/static/imgs/uploadfiles/empty.png" class="card-img-top">
                                                    <?php
                                    }
                                    ?>
                                    <p class="card-body d-flex flex-column p-0">
                                        <span>
                                            <?php echo $value['name'] ?>
                                        </span>
                                        <span>
                                            <?php echo number_format($value['price'], 0, ',', '.') . ' đ' ?>
                                        </span>

                                    </p>
                                </a>
                                <?php
                } ?>
            </div>
        </div>
        <div class="table">
            <div class="title">
                <h3>Chọn bàn: </h3>
            </div>
            <div class="content">
                <?php
                foreach ($list_table as $key => $value) { ?>
                                <a class="item table-item" data-table="<?php echo $value['name'] ?>">
                                    <?php
                                    echo $value['name'];
                                    if ($value['status'] == 1) {
                                        echo '(Đang dùng)';
                                    } ?>
                                </a>
                                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="center-content">
        <div class="form-order">
            <div class="title-form">
                <h3>Thông tin đơn đặt</h3>
            </div>
            <div class="alert p-0 m-0">
                <?php if (isset($isReplaced)) {
                    echo $isReplaced;
                } else if (isset($isNull)) {
                    echo $isNull;
                } else if (isset($isSucessed)) {
                    echo $isSucessed;
                } ?>
            </div>
            <div class="form">
                <div class="order">
                </div>
                <div class="d-flex list-food-item">
                    <!-- <div class="food-quantity-item" data-food-quantity="0">
                    </div> -->
                </div>
                <div class="table">
                    <div><span>Bàn: </span></div>
                    <select name="table_name">
                        <option value="">Chọn bàn</option>
                        <?php
                        foreach ($list_table as $key1 => $value1) {
                            ?>
                                        <option value="<?php echo $value1['name'] ?>">
                                            <?php echo $value1['status'] == 0 ? $value1['name'] : $value1['name'] . ' (đang dùng)' ?>
                                        </option>
                                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="btn-add-order">
                    <input class="btn-submit-add-order" type="submit" name="btn-add-order" value="Đặt món">
                </div>
            </div>
        </div>
        <div class="bill-item text-center">
        </div>
    </div>
    <div class="right-content">
        <div class="billadded">
            <?php
            if (isset($bill_added)) {
                echo $bill_added;
            }
            ?>
        </div>
        <div class="order-item">
        </div>
    </div>
</div>
<!-- </div> -->
<script>
    const formOrder = $('.form-order');
    const leftContent = $('.left-content');
    const foodItem = leftContent.find('.food-item');
    const foodSelect = formOrder.find('.food select');
    const foodSelectOption = foodSelect.find('option');
    const centerContent = $('.center-content');
    const tableSelect = formOrder.find('.table select');
    const tableSelectOption = tableSelect.find('option');
    const tableItem = leftContent.find('.table-item');
    const billItem = $('.bill-item');

    $('.center-content .food-quantity-item .food').on('click', 'select', function () {
        const foodNameSelector = $(this).val();
        const foodNameItem = foodItem.filter('.active').attr('data-food');
        foodSelectOption.removeAttr('selected');
        foodSelectOption.each(function () {
            if ($(this).val() === foodNameSelector) {
                $(this).prop('selected', true);
            }
        });
    })

    $('.center-content .table').on('click', 'select', function () {
        const tableNameSelector = $(this).val();
        const tableNameItem = tableItem.filter('.active').attr('data-table');
        tableSelectOption.removeAttr('selected');
        tableSelectOption.each(function () {
            if ($(this).val() === tableNameSelector) {
                $(this).prop('selected', true);
            }
        });
        tableItem.removeClass('active');
        tableItem.each(function () {
            if ($(this).attr('data-table') === tableNameSelector) {
                $(this).addClass('active');
            }
        });
        if (tableNameSelector !== tableNameItem) {
            $.ajax({
                url: "<?php echo _WEB_ROOT ?>/them-don-dat",
                type: "POST",
                data: {
                    table_name: tableNameSelector
                },
                success: (response) => {
                    let data;
                    if ($(response)[2] === undefined) {
                        data = "Bàn này đang trống!";
                        $('.order').html("");
                    } else {
                        data = $(response)[2];
                    }
                    $(".bill-item").html(data);
                }
            });
        }
    })

    $('.left-content .food').on('click', '.food-item', function () {
        const foodNameItem = $(this).attr('data-food');
        if (!$(this).hasClass('active')) {
            // foodItem.removeClass('active');
            $(this).addClass('active');
            addFoodItem(foodNameItem);
        } else {
            $(this).removeClass('active');
            $('.list-food-item').find('select').each(function () {
                if ($(this).val() === foodNameItem) {
                    $(this).parent().parent().remove();
                }
            })
        }
    })
    $('.left-content .table').on('click', '.table-item', function () {
        const tableNameItem = $(this).attr('data-table');
        const tableNameSelector = tableSelect.val();
        leftContent.find('.table-item').removeClass('active');
        $(this).addClass('active');

        tableSelectOption.removeAttr('selected');
        tableSelectOption.each(function () {
            if ($(this).val() === tableNameItem) {
                $(this).prop('selected', true);
            }
        });
        if (tableNameItem !== tableNameSelector) {
            $.ajax({
                url: "<?php echo _WEB_ROOT ?>/them-don-dat",
                type: "POST",
                data: {
                    table_name: tableNameItem
                },
                success: (response) => {
                    let data;
                    if ($(response)[2] === undefined) {
                        data = "Bàn này đang trống!";
                    } else {
                        data = $(response)[2];
                    }
                    $(".bill-item").html(data);
                    if ($('.bill-item').find('.bill_id') != '') {
                        let billID = $('.bill-item').find('.bill_id').first().text();
                        $.ajax({
                            url: '<?php echo _WEB_ROOT ?>/chi-tiet-hoa-don/' + billID,
                            type: 'POST',
                            success: (response) => {
                                $('.payment-content').remove();
                                $('.right-content').append('<div class="payment-content"></div>')
                                $('.payment-content').append('<div class="content d-block"></div>')
                                $('.payment-content .content').append('<div class="info"></div>')
                                $('.payment-content .info').html($(response).find('.info').html());
                                // console.log(billID);
                            }
                        })
                    } else {
                        $('.payment-content').remove();
                    }
                }
            });
        }
    })
    const addFoodItem = function (food_name) {
        if ($('.list-food-item').find('.food-quantity-item').length === 0) {
            var DataFoodQuantity = 0;
        } else {
            var DataFoodQuantity = parseInt($('.food-quantity-item').last().attr('data-food-quantity')) + 1;
        }
        var ListFoodItem = <?php echo json_encode($list_food) ?>;
        var foodItem = `
            <div class="food-quantity-item border border-white p-1" data-food-quantity="${DataFoodQuantity}">
                <div>
                    <div class="food position-relative">
                        <span>Món: </span>
                        <span class="delete-food-quantity d-flex h-100 align-items-center justify-content-center position-absolute end-0 top-0">
                            <i class="fa-solid fa-delete-left fs-2"></i>
                        </span>
                    </div>
                    <select name="food_name">
                        <option value="">Chọn món</option>`;
        for (let i = 0; i < ListFoodItem.length; i++) {
            if (ListFoodItem[i].name === food_name) {
                foodItem += `
                    <option value="${ListFoodItem[i].name}" selected>${ListFoodItem[i].name}</option>
                `;
            } else {
                foodItem += `
                    <option value="${ListFoodItem[i].name}">${ListFoodItem[i].name}</option>
                `;
            }
        }
        foodItem += `</select>
                </div>
                <div>
                    <div class="quantity position-relative">
                        <span>Số lượng: </span>
                    </div>
                    <input type="number" name="quantity" value="1" min="1">
                </div>
            </div>`;
        // $('.list-food-item').append(foodItem);
        if ($('.list-food-item').find('.food-quantity-item').length === 0) {
            $('.list-food-item').append(foodItem);
        } else {
            $('.list-food-item').first().find('.food-quantity-item').last().after(foodItem);
        }
        $('.delete-food-quantity i').click(function () {
            let foodNameSelector = $(this).parent().parent().parent().find('select').val();
            $('.left-content .food .food-item').each(function () {
                if ($(this).attr('data-food') === foodNameSelector) {
                    $(this).removeClass('active');
                }
            })
            $(this).parent().parent().parent().parent().remove();
        });
    }

    $('.btn-submit-add-order').click(function () {
        var foodQuantity = $('.food-quantity-item');
        var foodQuantityData = [];
        foodQuantity.each(function () {
            var food_name = $(this).find('select').val();
            var quantity = $(this).find('input').val();
            if (food_name != "" && quantity != "") {
                foodQuantityData.push({
                    food_name: food_name,
                    quantity: quantity
                });
            }
        });
        if ($(this).parent().parent().find('.table select').val() == "") {
            $('.alert').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Vui lòng chọn bàn!</div>');
        } else {
            if (foodQuantityData.length <= 1 && ($(this).parent().parent().find('.food select').val() == "" || $(this).parent().parent().find('.quantity input').val() == "" || $(this).parent().parent().find('.table select').val() == "")) {
                $('.alert').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Vui lòng nhập đủ thông tin!</div>');
            } else {
                var url = "<?php echo _WEB_ROOT ?>/them-don-dat";
                var table_name = $(this).parent().parent().find('.table select').val();
                var formData = new FormData();
                formData.append('btn-add-order', true);
                if (foodQuantityData.length == 1) {
                    formData.append('food_name', foodQuantityData[0].food_name);
                    formData.append('table_name', table_name);
                    formData.append('quantity', foodQuantityData[0].quantity);
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: (response) => {
                            formData.delete('food_name');
                            formData.delete('table_name');
                            formData.delete('quantity');
                            formData.delete('btn-add-order');
                            location.reload();
                        }
                    });
                } else {
                    formData.append('list_food', JSON.stringify(foodQuantityData));
                    formData.append('table_name', table_name);
                    formData.append('btn-add-order', true);
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: (response) => {
                            formData.delete('btn-add-order');
                            location.reload();
                        }
                    });
                }
            }
        }
    })
</script>
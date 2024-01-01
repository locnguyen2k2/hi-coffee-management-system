<div class="payment-content">
    <div class="heading">
        <h3>Cập nhật đơn đặt:
            <?php echo $unpaidbill[0]['orderID'] ?>
        </h3>
    </div>
    <div class="alert">
        <?php if (isset($isReplaced)) {
            echo $isReplaced;
        } else if (isset($isNull)) {
            echo $isNull;
        } else if (isset($isSucessed)) {
            echo $isSucessed;
        } ?>
    </div>
    <div class="order-items">
        <div class="order-update-form" order-data="<?php echo $unpaidbill[0]['orderID'] ?>">
            <div class="order-detail">
                <div class="table">
                    <span>Bàn:
                    </span>
                    <span>
                        <select name="tableID">
                            <option value="<?php echo $unpaidbill[0]['tableID'] ?>">
                                <?php
                                foreach ($list_table as $key => $value) {
                                    if ($unpaidbill[0]['tableID'] == $value['id']) {
                                        echo $value['name'];
                                        break;
                                    }
                                }
                                ?>
                            </option>
                            <?php
                            foreach ($list_table as $key1 => $value1) {
                                if ($value1['id'] != $unpaidbill[0]['tableID']) {
                                    ?>
                                            <option value="<?php echo $value1['id'] ?>">
                                                <?php echo $value1['name'] ?>
                                            </option>
                                            <?php
                                }
                            }
                            ?>
                        </select>
                    </span>
                </div>
                <div class="food" data-food="<?php echo $unpaidbill[0]['foodID'] ?>">
                    <span>Tên món:
                    </span>
                    <span>
                        <select name="foodID">
                            <option value="<?php echo $unpaidbill[0]['foodID'] ?>">
                                <?php
                                foreach ($list_food as $key => $value) {
                                    if ($unpaidbill[0]['foodID'] == $value['id']) {
                                        echo $value['name'];
                                        break;
                                    }
                                }
                                ?>
                            </option>
                            <?php
                            foreach ($list_food as $key1 => $value1) {
                                if ($unpaidbill[0]['foodID'] != $value1['id']) {
                                    ?>
                                            <option value="<?php echo $value1['id'] ?>">
                                                <?php echo $value1['name'] ?>
                                            </option>
                                            <?php
                                }
                            }
                            ?>
                        </select>
                    </span>
                </div>
                <div class="type">
                    <span>Loại:
                    </span>
                    <span>
                        <?php
                        foreach ($list_type as $key => $value) {
                            if ($unpaidbill[0]['typeID'] == $value['id']) {
                                echo $value['name'];
                                break;
                            }
                        }
                        ?>
                    </span>
                </div>
                <div class="price">
                    <span>Giá món:
                    </span>
                    <span>
                        <?php echo number_format($unpaidbill[0]['price'], 0, ',', '.') . ' đ' ?>
                    </span>
                </div>
                <div class="quantity">
                    <span>Số lượng:
                    </span>
                    <span>
                        <input name="quantity" type="number" min="1" value="<?php echo $unpaidbill[0]['quantity'] ?>">
                    </span>
                </div>
                <div class="total">
                    <span>Thành tiền:
                    </span>
                    <span>
                        <?php echo number_format($unpaidbill[0]['total'], 0, ',', '.') . ' đ' ?>
                    </span>
                </div>
                <div class="status">
                    <span>Trạng thái: Chưa thanh toán
                    </span>
                </div>
                <div class="setting">
                    <div class="btn-update">
                        <input class="submit" type="submit" name="btn-update" value="Cập nhật">
                    </div>
                    <div>
                        <a href="<?php echo _WEB_ROOT ?>/them-don-dat">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('.btn-update input').click(() => {
                var formData = new FormData();
                if (
                    $('select[name="tableID"]').val() == '' ||
                    $('select[name="foodID"]').val() == '' ||
                    $('input[name="quantity"]').val() == ''
                ) {
                    $('.alert').html('<div class="alert alert-danger">Vui lòng nhập đầy đủ thông tin</div>')
                } else {
                    let orderID = $('.order-items .order-update-form').attr('order-data');
                    let tableID = $('select[name="tableID"]').val();
                    let foodID = $('select[name="foodID"]').val();
                    let quantity = $('input[name="quantity"]').val();
                    let FoodOldId = $('.order-items .order-update-form .food').attr('data-food');
                    formData.append('tableID', tableID);
                    formData.append('foodID', foodID);
                    formData.append('quantity', quantity);
                    formData.append('btn-update', true);
                    $.ajax({
                        url: '<?php echo _WEB_ROOT ?>/cap-nhat-don-dat/' + orderID + '.' + FoodOldId,
                        type: 'post',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            $.ajax({
                                url: '<?php echo _WEB_ROOT ?>/cap-nhat-don-dat/' + orderID + '.' + FoodOldId,
                                type: 'post',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: (data) => {
                                    url = '<?php echo _WEB_ROOT ?>/chi-tiet-don-dat/' + orderID + '.' + foodID;
                                    window.location.href = url;
                                }
                            })
                        }
                    })
                }
            })
        </script>
    </div>
</div>
<div class="payment-content">
    <div class="heading">
        <h3>Cập nhật đơn đặt:
            <?php echo $order_detail['id'] ?>
        </h3>
    </div>
    <div class="order-items">
        <div class="order-detail">
            <div>
                <span>Bàn:
                </span>
                <span>
                    <?php echo $table['name'] ?>
                </span>
            </div>
            <div>
                <span>Tên món:
                </span>
                <span>
                    <?php echo $food['name'] ?>
                </span>
            </div>
            <div>
                <span>Loại:
                </span>
                <span>
                    <?php echo $type['name'] ?>
                </span>
            </div>
            <div>
                <span>Giá món:
                </span>
                <span>
                    <?php echo number_format($food['price'], 0, ',', '.') . ' đ'; ?>
                </span>
            </div>
            <div>
                <span>Số lượng:
                </span>
                <span>
                    <?php echo $order_detail['quantity'] ?>
                </span>
            </div>
            <div>
                <span>Thành tiền:
                </span>
                <span>
                    <?php echo number_format($order_detail['total'], 0, ',', '.') . ' đ' ?>
                </span>
            </div>
            <div>
                <span>Trạng thái: Chưa thanh toán
                </span>
            </div>
            <div class="setting">
                <div class="btn-update">
                    <a order-data="<?php echo $order_detail['orderID'] ?>.<?php echo $order_detail['foodID'] ?>">Cập
                        nhật</a>
                </div>
                <div class="btn-add-food">
                    <a>Thêm món</a>
                </div>
                <div class="btn-pay">
                    <form method="post"
                        action="<?php echo _WEB_ROOT ?>/thanh-toan-don-dat/<?php echo $order_detail['orderID'] ?>.<?php echo $order_detail['foodID'] ?>">
                        <input type="submit" name="btn-pay-order" value="Thanh toán">
                    </form>
                </div>
                <div class="btn-delete">
                    <form method="post"
                        action="<?php echo _WEB_ROOT ?>/xoa-don-dat/<?php echo $order_detail['orderID'] ?>.<?php echo $order_detail['foodID'] ?>">
                        <input type="submit" name="btn-delete-order" value="Xóa">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.btn-update a').click(() => {
        let formData = new FormData();
        var orderData = $('.btn-update a').attr('order-data');
        let url = '<?php echo _WEB_ROOT ?>/cap-nhat-don-dat/' + orderData;
        $.ajax({
            type: "POST",
            url: url,
            success: function (data) {
                console.log(data);
                $('.order-items').html($(data).find('.order-items').html());
            }
        });
    }); 
</script>
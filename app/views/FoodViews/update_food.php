<div class="alert">
    <div class="error">
        <h3>
            <?php
            if (isset($isNull)) {
                echo $isNull;
            } else if (isset($isReplaced)) {
                echo $isReplaced;
            } ?>
        </h3>
    </div>
    <div class="success">
        <h3>
            <?php if (isset($isSucessed)) {
                echo $isSucessed;
            } ?>
        </h3>
    </div>
</div>
<div class='update-item'>
    <?php require_once('app/views/blocks/list_form_nav.php'); ?>
    <div>
        <div class="list-item">
            <div class="heading">
                <span>Cập nhật món</span>
            </div>
            <div class="items">
                <div>
                    <span>
                        <input class="name" food-data="<?php echo $food['id'] ?>" type="text"
                            value="<?php echo $food['name'] ?>" name="name">
                    </span>
                </div>
                <div>
                    <span>
                        <!-- Tạo thẻ select chọn loại -->
                        <select class="type" name="type">
                            <!-- Option chứa loại của món hiệ tại -->
                            <option selected value="<?php echo $food['typeID']; ?>">
                                <?php echo $type['name'] ?>
                            </option>
                            <!-- Tạo các option chứa loại khác với loại của món đang được cập nhật -->
                            <?php foreach ($list_type as $key1 => $value1) {
                                if ($value1['id'] != $food['typeID']) { ?>
                                    <option value="<?php echo $value1['id'] ?>"><?php echo $value1['name'] ?></option>
                                <?php }
                            } ?>
                        </select>
                    </span>
                </div>
                <div>
                    <span>
                        <img class="food-image"
                            src="<?php echo _WEB_ROOT ?>/public/static/imgs/uploadfiles/<?php echo $food['imageName'] ?>"
                            alt="">
                    </span>
                </div>
                <div class="images" title="Hình ảnh trước đó của món sẽ được thay thế bởi ảnh sau khi cập nhật">
                    <div>
                        <div class="imgs"></div>
                    </div>
                    <div class="add-img-btn content"><input type="button" value="Cập nhật hình"></div>
                </div>
                <div>
                    <span>
                        <input class="price" type="number" value="<?php echo $food['price'] ?>" name="price">
                    </span>
                </div>
                <div>
                    <span>
                        <input class="status" type="number" min="0" max="1" value="<?php echo $food['status'] ?>"
                            name="status">
                    </span>
                </div>
                <div class="setting">
                    <input type="submit" class="update-food-btn" name="update-food-btn" value="Cập nhật">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.add-img-btn').click(() => {
        $('.imgs').html('<div class="img"><input class="image_upload" type="file" id="image-upload" name="image-upload" accept="image/jpeg, image/png, image/jpg"><i class="fas fa-close delete-image"></i></div>')
        $('.delete-image').click(() => {
            $('.delete-image').parent().remove();
        })
    })
    $('.update-food-btn').click(() => {
        let id = $('.name').attr('food-data');
        let fileInput = document.getElementById('image-upload');
        var formData = new FormData();
        if (fileInput != null) {
            let file = fileInput.files[0];
            formData.append('image_upload', file);
        }
        formData.append('name', $('.update-food-btn').parent().parent().find('.name').val());
        formData.append('price', $('.update-food-btn').parent().parent().find('.price').val());
        formData.append('type', $('.update-food-btn').parent().parent().find('.type').val());
        formData.append('status', $('.update-food-btn').parent().parent().find('.status').val());
        if (formData.get('name') == '' || formData.get('price') == '' || formData.get('type') == '' || formData.get('status') == '') {
            $('.alert').html('<div class="alert alert-danger">Vui lòng nhập đầy đủ thông tin</div>');
        } else {
            formData.append('update_food_btn', true);
            let url = '<?php echo _WEB_ROOT ?>/cap-nhat-mon/' + id;
            $.ajax({
                url: url,
                type: 'POST',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                data: formData,
                success: function (data) {
                    formData.delete('image_upload');
                    formData.delete('name');
                    formData.delete('price');
                    formData.delete('type');
                    formData.delete('status');
                    formData.delete('update_food_btn');
                    let freshAlert = $(data).find('.alert').html();
                    $.ajax({
                        url: url,
                        success: function (data) {
                            let freshFoodName = $(data).find('.name').val();
                            let freshFoodPrice = $(data).find('.price').val();
                            let freshFoodType = $(data).find('.type').val();
                            let freshFoodStatus = $(data).find('.status').val();
                            let freshFoodImage = $(data).find('.food-image').attr('src');

                            $('.name').val(freshFoodName);
                            $('.price').val(freshFoodPrice);
                            $('.type').val(freshFoodType);
                            $('.status').val(freshFoodStatus);
                            $('.food-image').attr('src', freshFoodImage);
                            $('.alert').html(freshAlert);
                            $('.imgs .img').remove();
                            $('.delete-image').parent().remove();
                        }
                    })
                },

            })
        }
    })
</script>
<div class="add-form">
    <?php require_once('app/views/blocks/add_form_nav.php'); ?>
    <div class="alert">
        <?php if (isset($isReplaced)) {
            echo $isReplaced;
        } else if (isset($isNull)) {
            echo $isNull;
        } else if (isset($isSucessed)) {
            echo $isSucessed;
        } ?>
    </div>
    <div class="form add-food">
        <div class="name">
            <div><span>1) Tên món: </span></div>
            <div><input type="text" name="name" placeholder="Nhập tên món"></div>
        </div>
        <div class="type">
            <div>
                <span>2) Loại loại món: </span>
            </div>
            <div>
                <?php
                foreach ($list_type as $key => $value) { ?>
                    <div class="type-item">
                        <input type="radio" value="<?php echo $value['id'] ?>" name="type">
                        <label for="type">
                            <?php echo $value['name'] ?>
                        </label>
                    </div>
                    <?php
                } ?>
            </div>
        </div>
        <div class="images">
            <div><span>3) Hình ảnh: </span></div>
            <div>
                <div class="imgs"></div>
            </div>
            <div class="add-img-btn content"><input type="button" value="Cập nhật hình"></div>
        </div>
        <div class="price">
            <div><span>4) Giá sản món: </span></div>
            <div><input type="number" name="price" placeholder="Nhập giá sản món"></div>
        </div>
        <div class="featured">
            <div><span>5) Nổi bật: </span></div>
            <div>
                <div>
                    <input type="radio" value="0" name="featured">
                    <label for="type">Không</label>
                </div>
                <div>
                    <input type="radio" value="1" name="featured">
                    <label for="type">Có</label>
                </div>
            </div>
        </div>
        <div class="add-btn"><input type="submit" name="add-food-btn" value="Thêm"></div>
    </div>
</div>
<script>
    $('.add-img-btn').click(() => {
        $('.images .imgs').html('<div class="img"><input class="image_upload" type="file" id="image-upload" name="image-upload" accept="image/jpeg, image/png, image/jpg"><i class="fas fa-close delete-image"></i></div>')
        $('.delete-image').click(() => {
            $('.delete-image').parent().remove();
        })
    })
    $('.add-btn').click(() => {
        var formData = new FormData();
        var name = $('input[name="name"]').val();
        var type = $('input[name="type"]:checked').val();
        var price = $('input[name="price"]').val();
        var featured = $('input[name="featured"]:checked').val();
        if (name == '' || type == '' || price == '' || featured == '') {
            $('.alert').html('<div class="alert alert-danger">Vui lòng nhập đầy đủ thông tin</div>');
        } else {
            formData.append('name', name);
            formData.append('type', type);
            formData.append('price', price);
            formData.append('featured', featured);
            formData.append('add-food-btn', true);
            let fileInput = document.getElementById('image-upload');
            let url = '<?php echo _WEB_ROOT ?>/them-mon';
            if (fileInput != null) {
                let file = fileInput.files[0];
                formData.append('image_upload', file);
            }
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                enctype: 'multipart/form-data',
                success: function (data) {
                    let freshAlert = $(data).find('.alert').html();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        success: function (data) {
                            $('.add-form').find('input[type="text"]').val('');
                            $('.add-form').find('input[type="number"]').val('');
                            $('.add-form').find('input[type="radio"]').prop('checked', false);
                            $('.add-form').find('.imgs').html('');
                            $('.alert').html(freshAlert);
                        }
                    })
                }
            })
        }
    })  
</script>
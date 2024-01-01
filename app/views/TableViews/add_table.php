<div class="add-form">
    <?php require_once('app/views/blocks/add_form_nav.php'); ?>
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
    <div class="form add-table">
        <div class="name">
            <div><span>1) Tên bàn: </span></div>
            <input type="text" name="name" placeholder="Nhập tên bàn">
        </div>
        <div class="area">
            <div><span>2) Chọn khu: </span></div>
            <select name="area">
                <option value="0"></option>
                <?php foreach ($list_area as $key => $value) { ?>
                    <option value="<?php echo $value['name'] ?>"><?php echo $value['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="add-btn"><input type="submit" name="add-table-btn" value="thêm"></div>
    </div>
</div>
<script>
    $('.add-btn').click(() => {
        let name = $('.add-table').find('input[name="name"]').val();
        let area = $('.add-table').find('select[name="area"]').val();
        if (name == '' || area == '') {
            $('.alert').html('<div class="alert alert-danger">Vui lòng nhập đầy đủ thông tin</div>');
        } else {
            var formData = new FormData();
            formData.append('name', name);
            formData.append('area', area);
            formData.append('add-table-btn', true);
            let url = '<?php echo _WEB_ROOT ?>/them-ban';
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    formData.delete('add-table-btn');
                    formData.delete('name');
                    formData.delete('area');
                    let freshAlert = $(data).find('.alert').html();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        success: function (data) {
                            $('.add-form').find('input[type="text"]').val('');
                            $('.add-form').find('select').val('');
                            $('.alert').html(freshAlert);
                        }
                    })
                }
            })
        }
    })  
</script>
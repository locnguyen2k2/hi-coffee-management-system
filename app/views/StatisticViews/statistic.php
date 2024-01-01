<!-- Create a date pickter: to ... from -->
<div>
    <div class="statistical">
        <div class="form-group">
            <label for="from">Từ ngày</label>
            <input type="date" class="form-control" id="from" name="from" value="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="form-group">
            <label for="to">Đến ngày</label>
            <input type="date" class="form-control" id="to" name="to" value="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="form-group">
            <label for="statistical_type">Loại thống kê</label>
            <select class="form-control" id="statistical_type" name="statistical_type">
                <option value="mon">Món</option>
                <option value="ban">Bàn</option>
                <option value="loai">Loại</option>
            </select>
        </div>
        <button type="submit" class="btn btn-dark btn-statistical">Thống kê</button>
    </div>
</div><canvas id="myChart"></canvas>

<div class="bill-picker">
    <?php
    if (isset($hoadon)) { ?>
        <!-- Write an chart with: ten_mon, so_luong, thanh_tien, ban, loai was got from $hoadon -->

    <?php } ?>
</div>
<script>
    var myChart;
    $('.statistical').on('click', '.btn-statistical', () => {
        var from = $('#from').val();
        var to = $('#to').val();
        if (from > to) {
            alert('Ngày bắt đầu không được lớn hơn ngày kết thúc');
            $('#from').val('');
            return false;
        } else if (from == '' || to == '') {
            alert('Vui lòng chọn ngày');
            return false;
        } else {
            var formData = new FormData();
            formData.append('from', from);
            formData.append('to', to);
            var ctx = document.getElementById('myChart').getContext('2d');
            if (myChart && typeof myChart !== 'undefined' && myChart instanceof Chart) {
                myChart.destroy(); // Destroy the previous chart instance
            }
            if ($('.statistical #statistical_type').val() == 'mon') {
                formData.append('statistical_object', 'mon');
            } else if ($('.statistical #statistical_type').val() == 'ban') {
                formData.append('statistical_object', 'ban');
            } else {
                formData.append('statistical_object', 'loai');
            }
            if (from == to) {
                formData.append('statistical_type', 'day');
                url = '<?php echo _WEB_ROOT ?>/StatisticController/getDailyInvoiceStatistic/';
            } else {
                formData.append('statistical_type', 'range');
                url = '<?php echo _WEB_ROOT ?>/StatisticController/getInvoiceStatisticsInRange/';
            }
            $.ajax({
                url: url,
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function (data) {
                    var hoadon = JSON.parse(data);
                    var ten_mon = [];
                    var so_luong = [];
                    var thanh_tien = [];
                    var ban = [];
                    var loai = [];
                    var tong_tien = 0;
                    for (var i in hoadon) {
                        ten_mon.push(hoadon[i].ten_mon);
                        so_luong.push(hoadon[i].so_luong);
                        thanh_tien.push(hoadon[i].thanh_tien);
                        ban.push(hoadon[i].ban);
                        loai.push(hoadon[i].loai);
                        tong_tien += parseInt(hoadon[i].thanh_tien);
                    }
                    if (formData.get('statistical_object') == 'mon') {
                        var label = 'Món';
                    } else if (formData.get('statistical_object') == 'ban') {
                        var label = 'Bàn';
                    } else {
                        var label = 'Loại';
                    }
                    $('.bill-picker').html('<div class="bill-picker-header"><h3>Thống kê ' + label + ' từ ngày ' + from + ' đến ngày ' + to + '</h3><h4>Tổng tiền: ' + tong_tien + ' VNĐ</h4></div>');
                    // var ctx = document.getElementById('myChart').getContext('2d');
                    Chart.defaults.borderColor = 'black';
                    Chart.defaults.color = 'black';
                    myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: label == 'Món' ? ten_mon : label == 'Bàn' ? ban : loai,
                            datasets: [{
                                label: 'Số lượng',
                                data: so_luong,
                                backgroundColor: 'rgba(255, 99, 132, 1)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }, {
                                label: 'Thành tiền',
                                data: thanh_tien,
                                backgroundColor: 'rgba(54, 162, 235, 1)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            },
                            tooltips: {
                                callbacks: {
                                    label: function (tooltipItem, data) {
                                        var label = data.datasets[tooltipItem.datasetIndex].label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        label += tooltipItem.yLabel;
                                        return label;
                                    }
                                }
                            }
                        },
                    });
                }
            })
        }
    })
</script>
@extends('layouts.master_admin')

{{-- thay đổi nội dung phần controll --}}
<style>
    .wrapper-select-class {
        padding: 0 15px;
        margin-bottom: 10px;
    }

    .table-statistical-student {
        background-color: white
    }

    .box-header-statistical {
        padding: 10px 0;
        margin-bottom: 10px;
    }

    .box-header-statistical .box-title {
        margin: 0;
    }

    .info-box-icon {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }

    .text-point {
        text-wrap: wrap;
    }
    td {
        text-align: center;
    }
</style>
{{-- thay đổi nội dung phần content --}}
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12 wrapper-select-class">
                <select name="" id="select-class" class=" form-control ">
                    <option value="" disabled selected>Vui lòng chọn lớp</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Thống kê điểm lớp</h3>
                    </div>
                    <div class="box-body">
                        <div id="myfirstchart" style="height: 250px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon" style="background: red; color: #fff;">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </span>

                    <div class="info-box-content">
                        <span class="info-box-text">
                            <a href="#" class="text-point">Số lượng sinh viên đạt điểm kém</a></span>
                        <span class="info-box-number point-bad">
                            0
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon" style="background: #019FFA; color: #fff;">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </span>

                    <div class="info-box-content">
                        <span class="info-box-text">
                            <a href="#" class="text-point">Số lượng sinh viên đạt điểm trung bình</a>
                        </span>
                        <span class="info-box-number point-medium">
                            0
                        </span>
                    </div>
                </div>
            </div>

            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon" style="background: orange; color: #fff;">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </span>

                    <div class="info-box-content">
                        <span class="info-box-text">
                            <a href="#" class="text-point">Số lượng sinh viên đạt điểm khá</a>
                        </span>
                        <span class="info-box-number point-good">
                            0
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon" style="background: #15FC01; color: #fff;">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </span>

                    <div class="info-box-content">
                        <span class="info-box-text">
                            <a href="#" class="text-point">Số lượng sinh viên đạt điểm giỏi</a>
                        </span>
                        <span class="info-box-number point-better">
                            0
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-body table-statistical-student">
            <div class="box-header-statistical">
                <h3 class="box-title">Danh sách điểm sinh viên lớp: <span id="name-class"></span></h3>
            </div>
            <table id="list-data" class="table table-bordered table-striped" style="margin-top : 10px;">
                <thead>
                    <tr>
                        <th class="col-sm-1 text-center">Mã lớp</th>
                        <th class="col-sm-2 text-center">Tên lớp</th>
                        <th class="col-sm-1 text-center">Sinh viên</th>
                        <th class="col-sm-1 text-center">Mã sinh viên</th>
                        <th class="col-sm-1 text-center">Điểm trung bình</th>
                        <th class="col-sm-1 text-center">Xếp loại</th>
                    </tr>
                </thead>
                <tbody id="list-student">
                </tbody>
            </table>
        </div>


        <script type="text/javascript" src="{{ asset('home/js/sweetalert.min.js') }}"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
        <script>
            $(document).ready(function() {

                var data = [{
                    year: 0,
                    value: 0,
                }];

                var datatable = $('#list-data').DataTable({
                    "lengthMenu": [
                        [5, 10, 25, 50],
                        [5, 10, 15, 25, "All"]
                    ],

                    "language": {
                        "lengthMenu": "Hiển thị _MENU_ bản ghi",
                        "zeroRecords": "Xin lỗi không tìm thấy bản ghi",
                        "info": "Hiển thị _PAGE_ trên tổng số _PAGES_",
                        "infoEmpty": "Không có bản ghi nào",
                        "infoFiltered": "(filtered from _MAX_ total records)",
                        "search": "Tìm kiếm:",
                        "paginate": {
                            "first": "Đầu",
                            "last": "Cuối",
                            "next": "Tiếp",
                            "previous": "Trước"
                        },
                    },
                });


                $("#select-class").on('change', function() {
                    let value = $("#select-class option:selected").text();
                    let classId = $(this).val();

                    $("#name-class").text(value);

                    $.ajax({
                        type: "POST",
                        url: "/admin/statistical-point-class",
                        data: {
                            classId,
                            _token: "{{ csrf_token() }}",
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.dataPoint.length > 0) {
                                chart.setData(response.dataPoint);
                            }

                            $(".point-bad").text(response.dataPoint[0].count);
                            $(".point-medium").text(response.dataPoint[1].count);
                            $(".point-good").text(response.dataPoint[2].count);
                            $(".point-better").text(response.dataPoint[3].count);

                            $("#list-student").empty();
                            let dataStudents = [];
                            $.each(response.students, function(key, value) {
                                let rank = ""
                                if (0 <= value.avg_point && value.avg_point < 5) {
                                    rank = "Yếu";
                                } else if (5 <= value.avg_point && value.avg_point < 6.5) {
                                    rank = "Trung bình";
                                } else if (6.5 <= value.avg_point && value.avg_point < 8) {
                                    rank = "Khá";
                                } else {
                                    rank = "Giỏi";
                                }

                                dataStudents.push([
                                    value.credit_class.code,
                                    value.credit_class.name,
                                    value.students.account.username,
                                    value.students.account.code,
                                    value.avg_point,
                                    rank,
                                ]);
                            });

                            datatable.clear();
                            datatable.rows.add(dataStudents);
                            datatable.draw();      
                        }
                    });
                });


                var chart = new Morris.Bar({
                    element: 'myfirstchart',
                    data: data,
                    xkey: 'rank',
                    ymax: 10,
                    ykeys: ['point'],
                    labels: ['Điểm trung bình cả lớp']
                });
            });
        </script>
    </section>
    <!-- /.content -->
@endsection

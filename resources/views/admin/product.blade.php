@extends('admin.layouts.app')
@section('title', 'Sản phẩm')
@section('pageTitle', 'Sản phẩm')
@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <div class="card-tools">
                <button id="btnAdd" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm mới</button>
            </div>
        </div>
        <div class="card-body">
            <table id="tbl" class="table table-bordered table-hover table-striped w-100">
                <thead>
                <th style="width: 5%;">#</th>
                <th style="width: 10%">Tên</th>
                <th>Hình</th>
                <th>Mô tả</th>
                <th>Mới/cũ</th>
                <th>Năm</th>
                <th>Kiểu</th>
                <th>Kích thước</th>
                <th>Nhãn</th>
                <th style="width: 70px">Thao tác</th>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection
@section('footer')
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"><i class="fa fa-info"></i> <span id="modalAction"></span> Sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="frm" enctype="multipart/form-data">
                        <input type="hidden" id="hidId" name="id" data-value-type="number"/>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-row">
                                    <label for="txtFile" class="col-sm-3 col-form-label">Hình ảnh: </label>
                                    <div class="col-sm">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="txtFile" name="PROIMAGE" autocomplete="off">
                                            <label class="custom-file-label" id="txtFileLabel" for="txtFile" data-browse="Duyệt qua">Chọn hình</label>
                                        </div>
                                        <img id="imgPreview" src="" class="mt-2 img-fluid" style="height: 310px;"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-row">
                                    <label for="txtName" class="col-sm-3 col-form-label text-right">Tên sản phẩm: </label>
                                    <div class="col-sm">
                                        <input type="text" class="form-control" id="txtName" name="PRONAME"
                                               maxlength="100" placeholder="Nhập tên sản phẩm." autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label for="drpBrandID" class="col-sm-3 col-form-label text-right">Thương hiệu: </label>
                                    <div class="col-sm">
                                        <select id="drpBrandID" name="BRA_ID"></select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-row">
                                            <div class="col-sm-3"></div>
                                            <label for="txtModel" class="col-sm-3 col-form-label text-right">Năm: </label>
                                            <div class="col-sm">
                                                <input type="number" class="form-control" id="txtModel" name="PROMODEL"
                                                       maxlength="8" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-row">
                                            <label for="txtWeight" class="col-sm-6 col-form-label text-right">Trọng lượng: </label>
                                            <div class="col-sm">
                                                <input type="number" class="form-control" id="txtWeight" name="PROWEIGHT"
                                                       maxlength="8" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-row">
                                            <div class="col-sm-3"></div>
                                            <label for="txtType" class="col-sm-3 col-form-label text-right">Kiểu: </label>
                                            <div class="d-flex ml-2 mt-2">
                                                <div class="form-check mr-3">
                                                    <input class="form-check-input" type="radio" name="PROTYPE"
                                                           id="txtTypeSmall" value="0" checked>
                                                    <label class="form-check-label" for="txtTypeSmall">
                                                        Nhỏ
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="PROTYPE"
                                                           id="txtTypeLarge" value="1">
                                                    <label class="form-check-label" for="txtTypeLarge">
                                                        Lớn
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-row">
                                            <label for="txtSize" class="col-sm-6 col-form-label text-right">Kích thước: </label>
                                            <div class="col-sm">
                                                <input type="text" class="form-control" id="txtSize" name="PROSIZE"
                                                       maxlength="20" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label for="txtStatus" class="col-sm-3 col-form-label text-right">Tình trạng: </label>
                                    <div class="d-flex ml-2 mt-2">
                                        <div class="form-check mr-3">
                                            <input class="form-check-input" type="radio" name="PROSTATUS"
                                                   id="txtStatusNew" value="1" checked>
                                            <label class="form-check-label" for="txtStatusNew">
                                                Mới
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="PROSTATUS"
                                                   id="txtStatusOld" value="0">
                                            <label class="form-check-label" for="txtStatusOld">
                                                Cũ
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label for="txtDescription" class="col-sm-3 col-form-label text-right">Mô tả: </label>
                                    <div class="col-sm">
                                        <textarea class="form-control" id="txtDescription" rows="3" name="PRODESCRIPTION"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" id="btnSaveModal" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            var tbl = $('#tbl').DataTable({
                columnDefs: [{ orderable: false, targets: [0, 2, 3, 9] }],
                aLengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, '---']
                ],
                iDisplayLength: 10,
                order: [[1, 'asc'], [4, 'asc'], [5, 'asc'], [6, 'asc'], [7, 'asc'], [8, 'asc']],
                aaData: null,
                rowId: 'PRO_ID',
                columns: [
                    { data: null, className: 'text-center' },
                    { data: 'PRONAME' },
                    { data: null, render: function ( data, type, row ) {
                            return '<img class="img-fluid" src="' + base_url + '/public/data/products/' + data.PROIMAGE + '" style="width: 120px; height: 120px" alt="' + data.PRONAME +'"/>';
                        }},
                    { data: 'PRODESCRIPTION' },
                    { data: null, render: function ( data, type, row ) {
                            return data.PROSTATUS == 1 ?
                                '<span class="badge badge-success">Mới</span>' :
                                '<span class="badge badge-warning">Cũ</span>';
                        }},
                    { data: 'PROMODEL' },
                    { data: null, render: function ( data, type, row ) {
                            return data.PROTYPE == 0 ?
                                '<span class="badge badge-success">Nhỏ</span>' :
                                '<span class="badge badge-warning">Lớn</span>';
                        }},
                    { data: 'PROSIZE' },
                    { data: 'BRANAME' },
                    { data: null,  render: function ( data, type, row ) {
                            return '<i data-group="grpEdit" class="fas fa-edit text-info pointer mr-1"></i>' +
                                '<i data-group="grpDelete" class="far fa-trash-alt text-danger pointer"></i>';
                        }}
                ],
                initComplete: function (settings, json) {
                    loadTable();
                },
                drawCallback: function (settings) {
                    bindTableEvents();
                },
                rowCallback: function( row, data, iDisplayIndex ) {
                    var api = this.api();
                    var info = api.page.info();
                    var index = (info.page * info.length + (iDisplayIndex + 1));
                    $('td:eq(0)', row).html(index);
                }
            });
            function loadTable() {
                AjaxGet(api_url + '/products/get', function (result) {
                    tbl.clear().draw();
                    tbl.rows.add(result.data); // Add new data
                    tbl.columns.adjust().draw(); // Redraw the DataTable
                });
            }
            function bindTableEvents() {
                var rowId = 0;

                $('i[data-group=grpEdit]').off("click").click(function () {
                    rowId = $(this).closest('tr').attr('id');
                    AjaxGet(api_url + '/products/get/' + rowId, function (result) {
                        infoData = result.data;
                        $('#editModal').modal('show');
                    });
                });

                $('i[data-group=grpDelete]').off('click').click(function (e) {
                    rowId = $(this).closest('tr').attr('id');
                    $('#' + rowId).addClass('table-danger');
                    ShowConfirm('Xác nhận', 'Bạn có chắc chắn muốn xóa hàng đã chọn không?', 'Có', 'Không', function (yesClicked) {
                        if (yesClicked) {
                            AjaxPost(api_url + '/products/delete/' + rowId, null, function (result) {
                                if (result.error == 0) {
                                    tbl.row('#' + rowId).remove().draw();
                                    var content = 'Sản phẩm' + ' "' + result.data.PRONAME + '" đã xóa!';
                                    PNotify.success({title: 'Thành công', text: content});
                                } else {
                                    PNotify.alert({title: 'Cảnh báo', text: result.message});
                                }
                            }, function (jqXHR) {
                                PNotify.error({title: 'Lỗi', text: jqXHR.responseText});
                            });
                        }
                        $('#' + rowId).removeClass('table-danger');
                    });
                });
            }

            // ----------- select2 -----------------
            loadBrands();
            function loadBrands() {
                $('#drpBrandID').val(null).empty().trigger('change');
                AjaxGet(api_url+'/brands/get', function(result) {
                    var optionData = [{ id: 0, text: '-----', html: '-----' }];
                    $.each(result.data, function (i, el) {
                        optionData.push({ id: el.BRA_ID, text: el.BRANAME, html: '<span>' + el.BRANAME + '</span>' });
                    });

                    $("#drpBrandID").select2({
                        dropdownParent: $('#editModal'),
                        width: '100%',
                        data: optionData,
                        escapeMarkup: function (markup) {
                            return markup;
                        },
                        templateResult: function (data) {
                            return data.html;
                        },
                        templateSelection: function (data) {
                            return data.text;
                        }
                    });
                });
            }
            // ----------- end: select2 ------------


            $('#btnAdd').click(function(){
                infoData = null;
                $('#editModal').modal('show');
            });

            $("#txtFile").change(function(e){
                ReadImageUrl(this, "imgPreview", "txtFileLabel");
            });

            var validator = $('#frm').validate({
                rules: {
                    PRONAME: 'required',
                    BRA_ID: 'required',
                },
                messages: {
                    PRONAME: 'Hãy nhập tên sản phảm.',
                    BRA_ID: 'Hãy chọn thương hiệu.',
                }
            });

            $('#editModal').modal({ show: false }).on('show.bs.modal', function (e) {
                validator.resetForm();
                // check infoData edit or add new
                if (infoData != null) {
                    $('#modalAction').text('Chỉnh sửa');

                    $('#hidId').val(infoData.PRO_ID);
                    $('#txtName').val(infoData.PRONAME);
                    $('#drpBrandID').val(infoData.BRA_ID);
                    $('#txtModel').val(infoData.PROMODEL);
                    $('#txtWeight').val(infoData.PROWEIGHT);
                    $('#txtType').val(infoData.PROTYPE);
                    $('#txtSize').val(infoData.PROSIZE);
                    $('#txtDescription').val(infoData.PRODESCRIPTION);


                    $("#txtFileLabel").text(infoData.PROIMAGE);
                    if (infoData.PROIMAGE != null)
                        $("#imgPreview").attr('src',base_url +'/public/data/products/' + infoData.PROIMAGE);
                    else {
                        $("#txtFileLabel").text('Chọn hình');
                        $("#imgPreview").attr('src', '');
                    }
                } else {
                    $('#modalAction').text('Thêm');
                    $('#hidId').val('0');
                    $('#txtName').val();
                    $('#drpBrandID').val();
                    $('#txtModel').val();
                    $('#txtWeight').val();
                    $('#txtType').val();
                    $('#txtSize').val();
                    $('#txtDescription').val();

                    $("#txtFileLabel").text('Chọn hình');
                    $("#imgPreview").attr('src', '');
                }
            }).on('shown.bs.modal', function () {
                $('#txtName').focus();
            });

            $('#btnSaveModal').click(function(){
                if ($('#frm').valid()) {
                    // save data
                    var form = $("#frm")[0]; // high importance!, here you need change "yourformname" with the name of your form
                    var formdata = new FormData(form); // high importance!
                    id = $('#hidId').val();
                    if (id > 0) { // update
                        AjaxPostForm(api_url + '/products/update', formdata, function(res) {
                            if (res.error == 0) {
                                PNotify.success({title: 'Thành công', text: 'Sản phẩm đã được cập nhật thành công.'});
                                $('#editModal').modal('hide');
                                loadTable();
                            } else {
                                PNotify.alert({title: 'Cảnh báo', text: res.message});
                            }
                        });
                    } else { // add
                        AjaxPostForm(api_url + '/products/add', formdata, function(res) {
                            if (res.error == 0) {
                                PNotify.success({title: 'Thành công', text: 'Sản phẩm đã được thêm thành công.'});
                                $('#editModal').modal('hide');
                                loadTable();
                            } else {
                                PNotify.alert({title: 'Cảnh báo', text: res.message});
                            }
                        });
                    }
                }
            });
        });
    </script>
@endsection

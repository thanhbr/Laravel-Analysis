@extends('admin.layouts.app')
@section('title', 'Thương hiệu')
@section('pageTitle', 'Thương hiệu')
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
                <th style="width: 40px;">#</th>
                <th>Tên thương hiệu</th>
                <th>Điạ chỉ</th>
                <th>Email</th>
                <th>Số điện thoai</th>
                <th style="width: 70px">Thao tác</th>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection
@section('footer')
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"><i class="fa fa-info"></i> <span id="modalAction"></span> Thương hiệu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="frm" enctype="multipart/form-data">
                        <input type="hidden" id="hidId" name="id" data-value-type="number"/>
                        <div class="form-group form-row">
                            <label for="txtName" class="col-sm-3 col-form-label">Tên thương hiệu: </label>
                            <div class="col-sm">
                                <input type="text" class="form-control" id="txtName" name="BRANAME"
                                       maxlength="100" placeholder="Nhập tên thương hiệu." autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label for="txtAddress" class="col-sm-3 col-form-label">Địa chỉ: </label>
                            <div class="col-sm">
                                <input type="text" class="form-control" id="txtAddress" name="BRAADDRESS"
                                       maxlength="100" placeholder="Nhập địa chỉ." autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label for="txtEmail" class="col-sm-3 col-form-label">Email: </label>
                            <div class="col-sm">
                                <input type="email" class="form-control" id="txtEmail" name="BRAEMAIL"
                                       maxlength="100" placeholder="Nhập email." autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label for="txtPhone" class="col-sm-3 col-form-label">Số điện thoại: </label>
                            <div class="col-sm">
                                <input type="text" class="form-control" id="txtPhone" name="BRAPHONE"
                                       maxlength="20" placeholder="Nhập số điện thoại." autocomplete="off">
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
                columnDefs: [{ orderable: false, targets: [0, 5] }],
                aLengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, '---']
                ],
                iDisplayLength: 10,
                order: [[1, 'asc'], [2, 'asc'], [3, 'asc'], [4, 'asc']],
                aaData: null,
                rowId: 'BRA_ID',
                columns: [
                    { data: null, className: 'text-center' },
                    { data: 'BRANAME' },
                    { data: 'BRAADDRESS' },
                    { data: 'BRAEMAIL' },
                    { data: 'BRAPHONE' },
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
                AjaxGet(api_url + '/brands/get', function (result) {
                    tbl.clear().draw();
                    tbl.rows.add(result.data); // Add new data
                    tbl.columns.adjust().draw(); // Redraw the DataTable
                });
            }
            function bindTableEvents() {
                var rowId = 0;

                $('i[data-group=grpEdit]').off("click").click(function () {
                    rowId = $(this).closest('tr').attr('id');
                    AjaxGet(api_url + '/brands/get/' + rowId, function (result) {
                        infoData = result.data;
                        $('#editModal').modal('show');
                    });
                });

                $('i[data-group=grpDelete]').off('click').click(function (e) {
                    rowId = $(this).closest('tr').attr('id');
                    $('#' + rowId).addClass('table-danger');
                    ShowConfirm('Xác nhận', 'Bạn có chắc chắn muốn xóa hàng đã chọn không?', 'Có', 'Không', function (yesClicked) {
                        if (yesClicked) {
                            AjaxPost(api_url + '/brands/delete/' + rowId, null, function (result) {
                                if (result.error == 0) {
                                    tbl.row('#' + rowId).remove().draw();
                                    var content = 'Thương hiệu' + ' "' + result.data.BRANAME + '" đã xóa!';
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

            $('#btnAdd').click(function(){
                infoData = null;
                $('#editModal').modal('show');
            });

            var validator = $('#frm').validate({
                rules: {
                    BRANAME: 'required',
                },
                messages: {
                    BRANAME: 'Hãy nhập tên thương hiệu.',
                }
            });

            $('#editModal').modal({ show: false }).on('show.bs.modal', function (e) {
                validator.resetForm();
                // check infoData edit or add new
                if (infoData != null) {
                    $('#modalAction').text('Chỉnh sửa');

                    $('#hidId').val(infoData.BRA_ID);
                    $('#txtName').val(infoData.BRANAME);
                    $('#txtAddress').val(infoData.BRAADDRESS);
                    $('#txtEmail').val(infoData.BRAEMAIL);
                    $('#txtPhone').val(infoData.BRAPHONE);

                } else {
                    $('#modalAction').text('Thêm');
                    $('#hidId').val('0');
                    $('#txtName').val();
                    $('#txtAddress').val();
                    $('#txtEmail').val();
                    $('#txtPhone').val();
                }
            }).on('shown.bs.modal', function () {
                $('#txtID').focus();
            });

            $('#btnSaveModal').click(function(){
                if ($('#frm').valid()) {
                    // save data
                    data = $('#frm').serializeJSON();
                    id = $('#hidId').val();
                    if (id > 0) { // update
                        AjaxPost(api_url + '/brands/update', data, function(res) {
                            if (res.error == 0) {
                                PNotify.success({title: 'Thành công', text: 'Thương hiệu đã được cập nhật thành công.'});
                                $('#editModal').modal('hide');
                                loadTable();
                            } else {
                                PNotify.alert({title: 'Cảnh báo', text: res.message});
                            }
                        });
                    } else { // add
                        AjaxPost(api_url + '/brands/add', data, function(res) {
                            if (res.error == 0) {
                                PNotify.success({title: 'Thành công', text: 'Thương hiệu đã được thêm thành công.'});
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

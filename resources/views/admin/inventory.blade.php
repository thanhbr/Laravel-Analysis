@extends('admin.layouts.app')
@section('title', 'Kho')
@section('pageTitle', 'Kho')
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
                <th>Mã kho</th>
                <th>Tên kho</th>
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
                    <h5 class="modal-title" id="modalTitle"><i class="fa fa-info"></i> <span id="modalAction"></span> Kho</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="frm" enctype="multipart/form-data">
                        <input type="hidden" id="hidId" name="id" data-value-type="number"/>
                        <div class="form-group form-row">
                            <label for="txtID" class="col-sm-3 col-form-label">Mã kho: </label>
                            <div class="col-sm">
                                <input type="text" class="form-control" id="txtID" name="INVID"
                                       maxlength="20" placeholder="Nhập mã kho." autocomplete="off"/>
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label for="txtName" class="col-sm-3 col-form-label">Tên kho: </label>
                            <div class="col-sm">
                                <input type="text" class="form-control" id="txtName" name="INVNAME"
                                       maxlength="100" placeholder="Nhập tên kho." autocomplete="off">
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
                columnDefs: [{ orderable: false, targets: [0, 3] }],
                aLengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, '---']
                ],
                iDisplayLength: 10,
                order: [[1, 'asc'], [2, 'asc']],
                aaData: null,
                rowId: 'INV_ID',
                columns: [
                    { data: null, className: 'text-center' },
                    { data: 'INVID' },
                    { data: 'INVNAME' },
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
                AjaxGet(api_url + '/inventories/get', function (result) {
                    tbl.clear().draw();
                    tbl.rows.add(result.data); // Add new data
                    tbl.columns.adjust().draw(); // Redraw the DataTable
                });
            }
            function bindTableEvents() {
                var rowId = 0;

                $('i[data-group=grpEdit]').off("click").click(function () {
                    rowId = $(this).closest('tr').attr('id');
                    AjaxGet(api_url + '/inventories/get/' + rowId, function (result) {
                        infoData = result.data;
                        $('#editModal').modal('show');
                    });
                });

                $('i[data-group=grpDelete]').off('click').click(function (e) {
                    rowId = $(this).closest('tr').attr('id');
                    $('#' + rowId).addClass('table-danger');
                    ShowConfirm('Xác nhận', 'Bạn có chắc chắn muốn xóa hàng đã chọn không?', 'Có', 'Không', function (yesClicked) {
                        if (yesClicked) {
                            AjaxPost(api_url + '/permissions/delete/' + rowId, null, function (result) {
                                if (result.error == 0) {
                                    tbl.row('#' + rowId).remove().draw();
                                    var content = 'Kho' + ' "' + result.data.INVNAME + '" đã xóa!';
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
                    INVNAME: 'required',
                },
                messages: {
                    INVNAME: 'Hãy nhập tên kho.',
                }
            });

            $('#editModal').modal({ show: false }).on('show.bs.modal', function (e) {
                validator.resetForm();
                // check infoData edit or add new
                if (infoData != null) {
                    $('#modalAction').text('Chỉnh sửa');

                    $('#hidId').val(infoData.INV_ID);
                    $('#txtID').val(infoData.INVID);
                    $('#txtName').val(infoData.INVNAME);

                } else {
                    $('#modalAction').text('Thêm');
                    $('#hidId').val('0');
                    $('#txtID').val();
                    $('#txtName').val();
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
                        AjaxPost(api_url + '/inventories/update', data, function(res) {
                            if (res.error == 0) {
                                PNotify.success({title: 'Thành công', text: 'Kho đã được cập nhật thành công.'});
                                $('#editModal').modal('hide');
                                loadTable();
                            } else {
                                PNotify.alert({title: 'Cảnh báo', text: res.message});
                            }
                        });
                    } else { // add
                        AjaxPost(api_url + '/inventories/add', data, function(res) {
                            if (res.error == 0) {
                                PNotify.success({title: 'Thành công', text: 'Kho đã được thêm thành công.'});
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

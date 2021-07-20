@extends('admin.layouts.app')
@section('title', 'Nhân viên')
@section('pageTitle', 'Nhân viên')
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
                <th>Tên tài khoản</th>
                <th>Chức vụ</th>
                <th>Họ và tên</th>
                <th>Email</th>
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
                    <h5 class="modal-title" id="modalTitle"><i class="fa fa-info"></i> <span id="modalAction"></span> Nhân viên</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="frm" enctype="multipart/form-data">
                        <input type="hidden" id="hidId" name="id" data-value-type="number"/>
                        <div class="form-group form-row">
                            <label for="txtUserName" class="col-sm-3 col-form-label">Tên tài khoản: </label>
                            <div class="col-sm">
                                <input type="text" class="form-control" id="txtUserName" name="username"
                                       maxlength="50" placeholder="Nhập tên tài khoản" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label for="drpRoleId" class="col-sm-3 col-form-label">Chức vụ: </label>
                            <div class="col-sm">
                                <select id="drpRoleId" name="ROLE_ID"></select>
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label for="txtPassword" class="col-sm-3 col-form-label">Mật khẩu: </label>
                            <div class="col-sm">
                                <input type="password" class="form-control" id="txtPassword" name="password"
                                       maxlength="50" placeholder="Nhập mật khẩu" />
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label for="txtFullName" class="col-sm-3 col-form-label">Họ và tên: </label>
                            <div class="col-sm">
                                <input type="text" class="form-control" id="txtFullName" name="fullname"
                                       maxlength="50" placeholder="Nhập họ và tên" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label for="txtEmail" class="col-sm-3 col-form-label">Email: </label>
                            <div class="col-sm">
                                <input type="email" class="form-control" id="txtEmail" name="email"
                                       maxlength="50" placeholder="Nhập email" autocomplete="off">
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
                rowId: 'USE_ID',
                columns: [
                    { data: null, className: 'text-center' },
                    { data: 'username'},
                    { data: 'ROLENAME'},
                    { data: 'fullname' },
                    { data: 'email' },
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
                AjaxGet(api_url + '/users/get', function (result) {
                    tbl.clear().draw();
                    tbl.rows.add(result.data); // Add new data
                    tbl.columns.adjust().draw(); // Redraw the DataTable
                });
            }
            function bindTableEvents() {
                var rowId = 0;

                $('i[data-group=grpEdit]').off("click").click(function () {
                    rowId = $(this).closest('tr').attr('id');
                    AjaxGet(api_url + '/users/get/' + rowId, function (result) {
                        infoData = result.data;
                        $('#editModal').modal('show');
                    });
                });

                $('i[data-group=grpDelete]').off('click').click(function (e) {
                    rowId = $(this).closest('tr').attr('id');
                    $('#' + rowId).addClass('table-danger');
                    ShowConfirm('Xác nhận', 'Bạn có chắc chắn muốn xóa hàng đã chọn không?', 'Có', 'Không', function (yesClicked) {
                        if (yesClicked) {
                            AjaxPost(api_url + '/users/delete/' + rowId, null, function (result) {
                                if (result.error == 0) {
                                    tbl.row('#' + rowId).remove().draw();
                                    var content = 'Tài khoản' + ' "' + result.data.username + '" đã xóa!';
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
            loadRoles();
            function loadRoles() {
                $('#drpRoleId').val(null).empty().trigger('change');
                AjaxGet(api_url+'/roles/get', function(result) {
                    var optionData = [{ id: 0, text: '-----', html: '-----' }];
                    $.each(result.data, function (i, el) {
                        optionData.push({ id: el.ROLE_ID, text: el.ROLENAME, html: '<span>' + el.ROLENAME + '</span>' });
                    });

                    $("#drpRoleId").select2({
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

            var validator = $('#frm').validate({
                rules: {
                    username: 'required',
                    ROLE_ID: 'required',
                    fullname: 'required',
                    password: 'required',
                    email: 'required',
                },
                messages: {
                    username: 'Hãy nhập tên tài khoản.',
                    ROLE_ID: 'Hãy nhập chức vụ.',
                    fullname: 'Hãy nhập họ và tên.',
                    password: 'Hãy nhập mật khẩu.',
                    email: 'Hãy nhập email.',
                }
            });

            $('#editModal').modal({ show: false }).on('show.bs.modal', function (e) {
                validator.resetForm();
                // check infoData edit or add new
                if (infoData != null) {
                    $('#modalAction').text('Chỉnh sửa');

                    $('#hidId').val(infoData.USE_ID);
                    $('#txtUserName').val(infoData.username);
                    $('#drpRoleId').val(infoData.ROLE_ID);
                    $('#txtPassword').val(infoData.password);
                    $('#txtFullName').val(infoData.fullname);
                    $('#txtEmail').val(infoData.email);
                } else {
                    $('#modalAction').text('Thêm');
                    $('#hidId').val('0');
                    $('#txtUserName').val();
                    $('#drpRoleId').val();
                    $('#txtPassword').val();
                    $('#txtFullName').val();
                    $('#txtEmail').val();
                }
            }).on('shown.bs.modal', function () {
                $('#txtUserName').focus();
            });

            $('#btnSaveModal').click(function(){
                if ($('#frm').valid()) {
                    // save data
                    data = $('#frm').serializeJSON();
                    id = $('#hidId').val();
                    if (id > 0) { // update
                        AjaxPost(api_url + '/users/update', data, function(res) {
                            if (res.error == 0) {
                                PNotify.success({title: 'Thành công', text: 'Người dùng đã được cập nhật thành công.'});
                                $('#editModal').modal('hide');
                                loadTable();
                                loadRoles();
                            } else {
                                PNotify.alert({title: 'Cảnh báo', text: res.message});
                            }
                        });
                    } else { // add
                        AjaxPost(api_url + '/users/add', data, function(res) {
                            if (res.error == 0) {
                                PNotify.success({title: 'Thành công', text: 'Người dùng đã được thêm thành công.'});
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

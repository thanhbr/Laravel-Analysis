@extends('admin.layouts.app')
@section('title', 'Chức vụ')
@section('pageTitle', 'Chức vụ')
@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <div class="card-tools d-flex justify-content-between">
                <div>
                    <select data-column="0" class="form-control filter-select">
                        <option value="">Chọn tên</option>
                        @foreach($names as $name)
                            <option value="{{ $name }}">{{$name}}</option>
                        @endforeach
                    </select>
                </div>
                <button id="btnAdd" type="button" class="btn btn-primary ml-3"><i class="fas fa-plus"></i> Thêm mới</button>
            </div>
        </div>
        <div class="card-body">
            <table id="tbl" class="table table-bordered table-hover table-striped w-100">

                <thead>
                    <th style="width: 40px;">#</th>
                    <th>Tên chức vụ</th>
                    <th>Ghi chú</th>
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
                <h5 class="modal-title" id="modalTitle"><i class="fa fa-info"></i> <span id="modalAction"></span> Chức vụ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frm" enctype="multipart/form-data">
                    <input type="hidden" id="hidId" name="id" data-value-type="number"/>
                    <div class="form-group form-row">
                        <label for="txtName" class="col-sm-3 col-form-label">Tên chức vụ: </label>
                        <div class="col-sm">
                            <input type="text" class="form-control" id="txtName" name="ROLENAME"
                                   maxlength="50" placeholder="Nhập tên chức vụ." autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label for="txtNote" class="col-sm-3 col-form-label">Ghi chú: </label>
                        <div class="col-sm">
                            <textarea class="form-control" id="txtNote" rows="3" name="ROLENOTE"></textarea>
                        </div>
                    </div>

                    <div class="form-group form-row">
                        <label for="txtNote" class="col-sm-3 col-form-label">Quyền: </label>
                        <div class="col-sm">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                                <label class="form-check-label" for="defaultCheck2">
                                    Xem trang chủ
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Quản lý kho
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Xem danh sách kho
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Quản lý hóa đơn
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Xem danh sách hóa đơn
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Quản lý sản phẩm
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                                <label class="form-check-label" for="defaultCheck2">
                                    Xem danh sách sản phẩm
                                </label>
                            </div>
                        </div>
                    </div>
{{--                    <div class="form-group form-row">--}}
{{--                        <label for="dropPermissionID" class="col-sm-3 col-form-label">Quyền: </label>--}}
{{--                        <div class="col-sm">--}}
{{--                            <select id="dropPermissionID" name="permissions[]" class="form-control permissions" multiple="multiple"></select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
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
            columnDefs: [{ orderable: false, targets: [0, 2, 3] }],
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, '---']
            ],
            iDisplayLength: 10,
            order: [[1, 'asc']],
            aaData: null,
            rowId: 'ROLE_ID',
            columns: [
                { data: null, className: 'text-center' },
                { data: 'ROLENAME' },
                { data: 'ROLENOTE' },
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
            AjaxGet(api_url + '/roles/get', function (result) {
                tbl.clear().draw();
                tbl.rows.add(result.data); // Add new data
                tbl.columns.adjust().draw(); // Redraw the DataTable
            });
        }
        function bindTableEvents() {
            var rowId = 0;

            $('i[data-group=grpEdit]').off("click").click(function () {
                rowId = $(this).closest('tr').attr('id');
                AjaxGet(api_url + '/roles/get/' + rowId, function (result) {
                    infoData = result.data;
                    $('#editModal').modal('show');
                });
            });

            $('i[data-group=grpDelete]').off('click').click(function (e) {
                rowId = $(this).closest('tr').attr('id');
                $('#' + rowId).addClass('table-danger');
                ShowConfirm('Xác nhận', 'Bạn có chắc chắn muốn xóa hàng đã chọn không?', 'Có', 'Không', function (yesClicked) {
                    if (yesClicked) {
                        AjaxPost(api_url + '/roles/delete/' + rowId, null, function (result) {
                            if (result.error == 0) {
                                tbl.row('#' + rowId).remove().draw();
                                var content = 'Chức vụ' + ' "' + result.data.ROLENAME + '" đã xóa!';
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

        $('.filter-select').change(function () {
            tbl.search($(this).val()).draw();
        })

        $('#btnAdd').click(function(){
            infoData = null;
            $('#editModal').modal('show');
        });

        loadPermissions();
        function loadPermissions() {
            $('.permissions').val(null).empty().trigger('change');
            AjaxGet(api_url+'/permissions/get', function(result) {
                var optionData = [];
                $.each(result.data, function (i, el) {
                    optionData.push({ id: el.PER_ID, text: el.PERNAME, html: '<span>' + el.PERNAME + '</span>' });
                });

                $(".permissions").select2({
                    placeholder: "Chọn quyền.",
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
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                });
            });
        }

        var validator = $('#frm').validate({
            rules: {
                ROLENAME: {
                    required: true,
                }
            },
            messages: {
                ROLENAME: {
                    required: 'Hãy nhập tên.',
                }
            }
        });

        $('#editModal').modal({ show: false }).on('show.bs.modal', function (e) {
            validator.resetForm();
            // check infoData edit or add new
            if (infoData != null) {
                $('#modalAction').text('Chỉnh sửa');

                $('#hidId').val(infoData.ROLE_ID);
                $('#txtName').val(infoData.ROLENAME);
                $('#txtNote').val(infoData.ROLENOTE);
                if ($('.permissions').find("option[value='" + infoData.PER_ID + "']").length) {
                    $('.permissions').val(infoData.PER_ID).trigger('change');
                } else {
                    var newOption = new Option(infoData.text, infoData.PER_ID, true, true);
                    $('.permissions').append(newOption).trigger('change');
                }
                // $('.permissions').val(infoData.PER_ID).trigger('change');

            } else {
                $('#modalAction').text('Thêm');
                $('#hidId').val('0');
                $('#txtName').val();
                $('#txtNote').val();
                $('.permissions').val();
            }
        }).on('shown.bs.modal', function () {
            $('#txtName').focus();
        });

        $('#btnSaveModal').click(function(){
            if ($('#frm').valid()) {
                // save data
                data = $('#frm').serializeJSON();
                id = $('#hidId').val();
                if (id > 0) { // update
                    AjaxPost(api_url + '/roles/update', data, function(res) {
                        if (res.error == 0) {
                            PNotify.success({title: 'Thành công', text: 'Chức vụ đã được cập nhật thành công.'});
                            $('#editModal').modal('hide');
                            loadTable();
                            loadPermissions();
                        } else {
                            PNotify.alert({title: 'Cảnh báo', text: res.message});
                        }
                    });
                } else { // add
                    AjaxPost(api_url + '/roles/add', data, function(res) {
                        if (res.error == 0) {
                            PNotify.success({title: 'Thành công', text: 'Chức vụ đã được cập nhật thành công.'});
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

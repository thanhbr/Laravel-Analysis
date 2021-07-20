@extends('admin.layouts.app')
@section('title', 'Bình luận')
@section('pageTitle', 'Bình luận')
@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
{{--            <div class="card-tools">--}}
{{--                <button id="btnAdd" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm mới</button>--}}
{{--            </div>--}}
        </div>
        <div class="card-body">
            <table id="tbl" class="table table-bordered table-hover table-striped w-100">
                <thead>
                <th style="width: 40px;">#</th>
                <th>Khách hàng</th>
                <th>Sản phẩm</th>
                <th>Tên bình luận</th>
                <th>Nội dung</th>
                <th>Ngày</th>
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
                    <h5 class="modal-title" id="modalTitle"><i class="fa fa-info"></i> <span id="modalAction"></span> Bình luận</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="frm" enctype="multipart/form-data">
                        <input type="hidden" id="hidId" name="id" data-value-type="number"/>
                        <div class="form-group form-row">
                            <label for="drpCustomerId" class="col-sm-3 col-form-label">Khách hàng: </label>
                            <div class="col-sm">
                                <select id="drpCustomerId" name="CUS_ID"></select>
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label for="drpProductId" class="col-sm-3 col-form-label">Sản phẩm: </label>
                            <div class="col-sm">
                                <select id="drpProductId" name="PRO_ID"></select>
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label for="txtTitle" class="col-sm-3 col-form-label">Tên bình luận: </label>
                            <div class="col-sm">
                                <input type="text" class="form-control" id="txtTitle" name="COMTITLE"
                                       maxlength="50" placeholder="Nhập tên bình luận" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label for="txtDesc" class="col-sm-3 col-form-label">Nội dung: </label>
                            <div class="col-sm">
                                <textarea rows="3" class="form-control" id="txtDesc" name="COMDESC"></textarea>
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label for="txtDate" class="col-sm-3 col-form-label">Ngày: </label>
                            <div class="col-sm">
                                <input type="date" class="form-control" id="txtDate" name="COMDATE">
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
                columnDefs: [{ orderable: false, targets: [0, 3, 4, 6] }],
                aLengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, '---']
                ],
                iDisplayLength: 10,
                order: [[1, 'asc'], [2, 'asc'], [5, 'asc']],
                aaData: null,
                rowId: 'COM_ID',
                columns: [
                    { data: null, className: 'text-center' },
                    { data: 'CUSNAME'},
                    { data: 'PRONAME'},
                    { data: 'COMTITLE' },
                    { data: 'COMDESC' },
                    { data: 'COMDATE' },
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
                AjaxGet(api_url + '/comments/get', function (result) {
                    tbl.clear().draw();
                    tbl.rows.add(result.data); // Add new data
                    tbl.columns.adjust().draw(); // Redraw the DataTable
                });
            }
            function bindTableEvents() {
                var rowId = 0;

                $('i[data-group=grpEdit]').off("click").click(function () {
                    rowId = $(this).closest('tr').attr('id');
                    AjaxGet(api_url + '/comments/get/' + rowId, function (result) {
                        infoData = result.data;
                        $('#editModal').modal('show');
                    });
                });

                $('i[data-group=grpDelete]').off('click').click(function (e) {
                    rowId = $(this).closest('tr').attr('id');
                    $('#' + rowId).addClass('table-danger');
                    ShowConfirm('Xác nhận', 'Bạn có chắc chắn muốn xóa hàng đã chọn không?', 'Có', 'Không', function (yesClicked) {
                        if (yesClicked) {
                            AjaxPost(api_url + '/comments/delete/' + rowId, null, function (result) {
                                if (result.error == 0) {
                                    tbl.row('#' + rowId).remove().draw();
                                    var content = 'Bình luận' + ' "' + result.data.COMTITLE + '" đã xóa!';
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
            loadCustomers();
            function loadCustomers() {
                $('#drpCustomerId').val(null).empty().trigger('change');
                AjaxGet(api_url+'/customers/get', function(result) {
                    var optionData = [{ id: 0, text: '-----', html: '-----' }];
                    $.each(result.data, function (i, el) {
                        optionData.push({ id: el.CUS_ID, text: el.CUSNAME, html: '<span>' + el.CUSNAME + '</span>' });
                    });

                    $("#drpCustomerId").select2({
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
            loadProducts();
            function loadProducts() {
                $('#drpProductId').val(null).empty().trigger('change');
                AjaxGet(api_url+'/products/get', function(result) {
                    var optionData = [{ id: 0, text: '-----', html: '-----' }];
                    $.each(result.data, function (i, el) {
                        optionData.push({ id: el.PRO_ID, text: el.PRONAME, html: '<span>' + el.PRONAME + '</span>' });
                    });

                    $("#drpProductId").select2({
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
                    COMTITLE: 'required',
                    CUS_ID: 'required',
                    PRO_ID: 'required',
                },
                messages: {
                    COMTITLE: 'Hãy nhập tên bình luận.',
                    CUS_ID: 'Hãy nhập khách hàng.',
                    PRO_ID: 'Hãy nhập sản phẩm.',
                }
            });

            $('#editModal').modal({ show: false }).on('show.bs.modal', function (e) {
                validator.resetForm();
                // check infoData edit or add new
                if (infoData != null) {
                    $('#modalAction').text('Chỉnh sửa');

                    $('#hidId').val(infoData.COM_ID);
                    $('#txtTitle').val(infoData.COMTITLE);
                    $('#drpCustomerId').val(infoData.CUS_ID);
                    $('#drpProductId').val(infoData.PRO_ID);
                    $('#txtDesc').val(infoData.COMDESC);
                    $('#txtDate').val(infoData.COMDATE);
                } else {
                    $('#modalAction').text('Thêm');
                    $('#hidId').val('0');
                    $('#txtTitle').val();
                    $('#drpCustomerId').val();
                    $('#drpProductId').val();
                    $('#txtDesc').val();
                    $('#txtDate').val();
                }
            }).on('shown.bs.modal', function () {
                $('#txtTitle').focus();
            });

            $('#btnSaveModal').click(function(){
                if ($('#frm').valid()) {
                    // save data
                    data = $('#frm').serializeJSON();
                    id = $('#hidId').val();
                    if (id > 0) { // update
                        AjaxPost(api_url + '/comments/update', data, function(res) {
                            if (res.error == 0) {
                                PNotify.success({title: 'Thành công', text: 'Bình luận đã được cập nhật thành công.'});
                                $('#editModal').modal('hide');
                                loadTable();
                            } else {
                                PNotify.alert({title: 'Cảnh báo', text: res.message});
                            }
                        });
                    } else { // add
                        AjaxPost(api_url + '/comments/add', data, function(res) {
                            if (res.error == 0) {
                                PNotify.success({title: 'Thành công', text: 'Bình luận đã được thêm thành công.'});
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

@extends('admin.layouts.app')
@section('title', 'Category')
@section('pageTitle', 'Category')
@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <div class="card-tools">
                <button id="btnAdd" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Add</button>
            </div>
        </div>
        <div class="card-body">
            <table id="tbl" class="table table-bordered table-hover table-striped">
                <thead>
                    <th style="width: 40px;">#</th>
                    <th>Name</th>
                    <th>Display Order</th>
                    <th style="width: 60px"></th>
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
                <h5 class="modal-title" id="modalTitle"><i class="fa fa-info"></i> <span id="modalAction"></span> Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frm" enctype="multipart/form-data">
                    <input type="hidden" id="hidId" name="id" data-value-type="number"/>
                    <div class="form-group form-row">
                        <label for="drpParentId" class="col-sm-3 col-form-label">Parent</label>
                        <div class="col-sm">
                            <select id="drpParentId" name="PARENT_ID"></select>
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label for="txtName" class="col-sm-3 col-form-label">Category name</label>
                        <div class="col-sm">
                            <input type="text" class="form-control" id="txtName" name="Name" maxlength="200" placeholder="Category name" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label for="txtDisplayOrder" class="col-sm-3 col-form-label">Display order</label>
                        <div class="col-sm">
                            <input type="text" class="form-control" id="txtDisplayOrder" name="DisplayOrder" maxlength="8" placeholder="Display order" data-value-type="number" style="width: 80px"/>
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label for="chkIsPublished" class="col-sm-3 col-form-label">Is Published</label>
                        <div class="col-sm">
                            <input type="checkbox" id="chkIsPublished" name="IsPublished" data-off-color="danger" data-on-color="primary" value="true">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btnSaveModal" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
        var tbl = $('#tbl').DataTable({
            // columnDefs: [{ orderable: false, targets: [0, 3] }],
            // aLengthMenu: [
            //     [10, 25, 50, 100, -1],
            //     [10, 25, 50, 100, '---']
            // ],
            // iDisplayLength: 50,
            // order: [[2, 'asc']],
            paging: false,
            ordering: false,
            aaData: null,
            rowId: 'CAT_ID',
            columns: [
                { data: null, className: 'text-center' },
                { data: null,  render: function ( data, type, row ) {
                    return '<span class="ml_' + (data.Depth * 15) + '">' + data.Name + '</span>';
                }},
                { data: 'DisplayOrder' },
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
            AjaxGet(api_url + '/categories/get', function (result) {
                tbl.clear().draw();
                tbl.rows.add(result.data); // Add new data
                tbl.columns.adjust().draw(); // Redraw the DataTable
            });
        }
        function bindTableEvents() {
            var rowId = 0;

            $('i[data-group=grpEdit]').off("click").click(function () {
                rowId = $(this).closest('tr').attr('id');
                AjaxGet(api_url + '/categories/get/' + rowId, function (result) {
                    infoData = result.data;
                    $('#editModal').modal('show');
                });
            });

            $('i[data-group=grpDelete]').off('click').click(function (e) {
                rowId = $(this).closest('tr').attr('id');
                $('#' + rowId).addClass('table-danger');
                ShowConfirm('Confirmation', 'Are you sure you want to delete selected row?', 'Yes', 'No', function (yesClicked) {
                    if (yesClicked) {
                        AjaxPost(api_url + '/categories/delete/' + rowId, null, function (result) {
                            if (result.error == 0) {
                                tbl.row('#' + rowId).remove().draw();
                                var content = 'Category' + ' "' + result.data.Name + '" has been deleted!';
                                PNotify.success({title: 'Info', text: content});
                            } else {
                                PNotify.alert({title: 'Warning', text: result.message});
                            }
                        }, function (jqXHR) {
                            PNotify.error({title: 'Error', text: jqXHR.responseText});
                        });
                    }
                    $('#' + rowId).removeClass('table-danger');
                });
            });
        }

        // ----------- select2 -----------------
        loadCategories();
        function loadCategories() {
            $('#drpParentId').val(null).empty().trigger('change');
            AjaxGet(api_url+'/categories/get-parent-list', function(result) {
                var optionData = [{ id: 0, text: '-----', html: '-----' }];
                $.each(result.data, function (i, el) {
                    depth = el.Depth > 0 ? el.Depth + 2 : 0;
                    optionData.push({ id: el.CAT_ID, text: el.Name, html: '<span class="ml-' + depth + '">' + el.Name + '</span>' });
                });

                $("#drpParentId").select2({
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
                Name: 'required',
                DisplayOrder: {
                    required: true,
                    digits: true
                }
            },
            messages: {
                Name: 'Please enter name.',
                DisplayOrder: {
                    required: 'Please enter number.',
                    digits: 'Number is invalid!.'
                }
            }
        });

        $('#editModal').modal({ show: false }).on('show.bs.modal', function (e) {
            validator.resetForm();
            // check infoData edit or add new
            if (infoData != null) {
                $('#modalAction').text('Update');

                $('#hidId').val(infoData.CAT_ID);
                $('#txtName').val(infoData.Name);
                $('#txtDisplayOrder').val(infoData.DisplayOrder);
                $('#chkIsPublished').bootstrapSwitch('state', infoData.IsPublished);
            } else {
                $('#modalAction').text('New');
                $('#hidId').val('0');
                $('#txtName').val('');
                $('#txtDisplayOrder').val('1');
                $('#chkIsPublished').bootstrapSwitch('state', true);
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
                    AjaxPost(api_url + '/categories/update', data, function(res) {
                        if (res.error == 0) {
                            PNotify.success({title: 'Info', text: 'Category has been updated successfully.'});
                            $('#editModal').modal('hide');
                            loadTable();
                            loadCategories();
                        } else {
                            PNotify.alert({title: 'Warning', text: res.message});
                        }
                    });
                } else { // add
                    AjaxPost(api_url + '/categories/add', data, function(res) {
                        if (res.error == 0) {
                            PNotify.success({title: 'Info', text: 'Category has been added successfully.'});
                            $('#editModal').modal('hide');
                            loadTable();
                            loadCategories();
                        } else {
                            PNotify.alert({title: 'Warning', text: res.message});
                        }
                    });
                }
            }
        });
    });
</script>
@endsection

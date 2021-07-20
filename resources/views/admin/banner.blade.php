@extends('admin.layouts.app')
@section('title', 'Banner')
@section('pageTitle', 'Banner')
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
                    <th>Title</th>
                    <th>Image</th>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"><i class="fa fa-info"></i> <span id="modalAction"></span> Banner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frm" enctype="multipart/form-data">
                    <input type="hidden" id="hidId" name="id" data-value-type="number"/>
                    <div class="form-group form-row">
                        <label for="txtTitle" class="col-sm-3 col-form-label">Banner title</label>
                        <div class="col-sm">
                            <input type="text" class="form-control" id="txtTitle" name="Title" maxlength="200" placeholder="Banner title" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label for="txtFile" class="col-sm-3 col-form-label">Image (1920x1080)</label>
                        <div class="col-sm">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="txtFile" name="Image" autocomplete="off">
                                <label class="custom-file-label" id="txtFileLabel" for="txtFile" data-browse="Browse">Upload image</label>
                            </div>
                            <img id="imgPreview" src="" class="mt-2 img-fluid"/>
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
            columnDefs: [{ orderable: false, targets: [0, 2, 4] }],
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, '---']
            ],
            iDisplayLength: 50,
            order: [[3, 'asc']],
            aaData: null,
            rowId: 'BAN_ID',
            columns: [
                { data: null, className: 'text-center' },
                { data: 'Title', className: 'text-center' },
                { data: null,  render: function ( data, type, row ) {
                    return '<img class="img-fluid" src="' + base_url + '/public/data/banners/' + data.Banner + '"/>';
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
            AjaxGet(api_url + '/banners/get', function (result) {
                tbl.clear().draw();
                tbl.rows.add(result.data); // Add new data
                tbl.columns.adjust().draw(); // Redraw the DataTable
            });
        }
        function bindTableEvents() {
            var rowId = 0;

            $('i[data-group=grpEdit]').off("click").click(function () {
                rowId = $(this).closest('tr').attr('id');
                AjaxGet(api_url + '/banners/get/' + rowId, function (result) {
                    infoData = result.data;
                    $('#editModal').modal('show');
                });
            });

            $('i[data-group=grpDelete]').off('click').click(function (e) {
                rowId = $(this).closest('tr').attr('id');
                $('#' + rowId).addClass('table-danger');
                ShowConfirm('Confirmation', 'Are you sure you want to delete selected row?', 'Yes', 'No', function (yesClicked) {
                    if (yesClicked) {
                        AjaxPost(api_url + '/banners/delete/' + rowId, null, function (result) {
                            if (result.error == 0) {
                                tbl.row('#' + rowId).remove().draw();
                                var content = 'Banner' + ' "' + result.data.Name + '" has been deleted!';
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

        $("#txtFile").change(function(e){
            ReadImageUrl(this, "imgPreview", "txtFileLabel");
        });

        $('#btnAdd').click(function(){
            infoData = null;
            $('#editModal').modal('show');
        });

        var validator = $('#frm').validate({
            rules: {
                Title: 'required',
                DisplayOrder: {
                    required: true,
                    digits: true
                }
            },
            messages: {
                Title: 'Please enter name.',
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

                $('#hidId').val(infoData.BAN_ID);
                $('#txtTitle').val(infoData.Title);
                $('#txtDisplayOrder').val(infoData.DisplayOrder);
                $('#chkIsPublished').bootstrapSwitch('state', infoData.IsPublished);

                $("#txtFileLabel").text(infoData.Banner);
                if (infoData.Banner != null)
                    $("#imgPreview").attr('src',base_url +'/public/data/banners/' + infoData.Banner);
                else {
                    $("#txtFileLabel").text('Upload image');
                    $("#imgPreview").attr('src','');
                }
                
            } else {
                $('#modalAction').text('New');
                $('#hidId').val('0');
                $('#txtTitle').val('');
                $('#txtDisplayOrder').val('1');
                $('#chkIsPublished').bootstrapSwitch('state', true);

                $("#txtFileLabel").text('Upload image');
                $("#imgPreview").attr('src','');
            }
        }).on('shown.bs.modal', function () {
            $('#txtTitle').focus();
        });

        $('#btnSaveModal').click(function(){
            if ($('#frm').valid()) {
                // save data
                var form = $("#frm")[0]; // high importance!, here you need change "yourformname" with the name of your form
                var formdata = new FormData(form); // high importance! 
                id = $('#hidId').val();
                if (id > 0) { // update
                    AjaxPostForm(api_url + '/banners/update', formdata, function(res) {
                        if (res.error == 0) {
                            PNotify.success({title: 'Info', text: 'Banner has been updated successfully.'});
                            $('#editModal').modal('hide');
                            loadTable();
                        } else {
                            PNotify.alert({title: 'Warning', text: res.message});
                        }
                    });
                } else { // add
                    AjaxPostForm(api_url + '/banners/add', formdata, function(res) {
                        if (res.error == 0) {
                            PNotify.success({title: 'Info', text: 'Banner has been added successfully.'});
                            $('#editModal').modal('hide');
                            loadTable();
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

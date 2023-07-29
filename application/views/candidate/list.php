<!DOCTYPE html>
<html>
    <head>
        <title>R17 - Test Candidate</title>
        <meta charset="utf-8">
        <meta name="app-url" content="<?php echo base_url('/') ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/bootstrap.min.css">
        <link href="<?php echo base_url() ?>/assets/datatables/css/dataTables.bootstrap.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h1 class="mt-4">Candidate</h1>
            <div class="ml-auto mr-3 mb-4">
                <button class="btn btn-success" onclick="addCandidate()"><i class="glyphicon glyphicon-plus"></i> Tambah Candidate</button>
                <button class="btn btn-info" onclick="importCandidate()"><i class="glyphicon glyphicon-import"></i> Import Data</button>
            </div>
            <br>
            <br>
            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th style="width:150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="gridview">
                     
                </tbody>
            </table>

            <?php $this->load->view("candidate/_partials/modal.php") ?>

            <script src="<?php echo base_url() ?>/assets/jquery/jquery.js"></script>
            <script src="<?php echo base_url() ?>/assets/js/bootstrap.min.js"></script>
            <script src="<?php echo base_url() ?>/assets/datatables/js/jquery.dataTables.min.js"></script>
            <script src="<?php echo base_url() ?>/assets/datatables/js/dataTables.bootstrap.js"></script>
            <script type="text/javascript">

            var save_method; //for save method string
            var table;

            $(document).ready(function() {

                //datatables
                table = $('#table').DataTable({

                    "processing": true, 
                    "serverSide": true, 
                    "order": [],
                    "ajax": {
                        "url": "index.php/candidate/ajax_list",
                        "type": "POST"
                    },
                    "columnDefs": [
                        {
                            "targets": [ 0 ], 
                            "orderable": false, 
                        },
                        {
                            "targets": [ -1 ], 
                            "orderable": false, 
                        },

                    ],
                    "fnInitComplete": function (oSettings, json) {
                        var total = json.recordsTotal;
                        if (total < 100){
                            $('#importModal').modal({backdrop: 'static', keyboard: false});
                            $('#importModal').find('.close').hide();
                            $('#importModal').find('.btn-default').hide();
                            $('#importModal').modal('show');
                        }

                    }


                });

                $("input").change(function(){
                    $(this).parent().parent().removeClass('has-error');
                    $(this).next().empty();
                });
                $("textarea").change(function(){
                    $(this).parent().parent().removeClass('has-error');
                    $(this).next().empty();
                });
                $("select").change(function(){
                    $(this).parent().parent().removeClass('has-error');
                    $(this).next().empty();
                });

            });

            function addCandidate()
            {
                save_method = 'add';
                $('input').val('');
                $('select').val('');
                $('textarea').val('');
                $('.form-group').removeClass('has-error'); 
                $('.help-block').empty(); 
                $('.modal-title').text('Add'); 
                $('#itemModal').modal('show');
                $('.modal-title').text('Tambah Candidate'); 
            }

            function importCandidate()
            {
                $('input').val('');
                $('#importModal').find('.close').show();
                $('#importModal').find('.btn-default').show();
                $('#importModal .modal-title').text('Import Data'); 
                $('#importModal').modal('show'); // show bootstrap modal
            }

            function editCandidate(id)
            {
                save_method = 'update';
                $('.form-group').removeClass('has-error'); 
                $('.help-block').empty();  

                //Ajax Load data from ajax
                $.ajax({
                    url : "index.php/candidate/ajax_edit/"+id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {

                        $('[name="id"]').val(data.id);
                        $('[name="nama"]').val(data.nama);
                        $('[name="jabatan"]').val(data.jabatan);
                        $('[name="jenis_kelamin"]').val(data.jenis_kelamin);
                        $('[name="alamat"]').val(data.alamat);
                        $('#itemModal').modal('show'); 
                        $('.modal-title').text('Edit'); 

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error getting data from ajax');
                    }
                });
            }

            function reloadTable()
            {
                table.ajax.reload(null,false); 
            }

            function save()
            {
                $('#btnSave').text('saving...');
                $('#btnSave').attr('disabled',true);
                var url;

                if(save_method == 'add') {
                    url = "index.php/candidate/ajax_add";
                } else {
                    url = "index.php/candidate/ajax_update";
                }

                // ajax adding data to database
                $.ajax({
                    url : url,
                    type: "POST",
                    data: $('#form').serialize(),
                    dataType: "JSON",
                    success: function(data)
                    {

                        if(data.status) 
                        {
                            $('#itemModal').modal('hide');
                            reloadTable();
                        }
                        else
                        {
                            for (var i = 0; i < data.inputerror.length; i++)
                            {
                                $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
                                $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); 
                            }
                        }
                        $('#btnSave').text('Save');
                        $('#btnSave').attr('disabled',false); 


                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error adding / update data');
                        $('#btnSave').text('Save'); //change button text
                        $('#btnSave').attr('disabled',false); //set button enable

                    }
                });
            }

            function deleteCandidate(id)
            {
                if(confirm('Apakah Anda yakin menghapus data ini?'))
                {
                    // ajax delete data to database
                    $.ajax({
                        url : "index.php/candidate/ajax_delete/"+id,
                        type: "POST",
                        dataType: "JSON",
                        success: function(data)
                        {
                            //if success reload ajax table
                            $('#itemModal').modal('hide');
                            reloadTable();
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error deleting data');
                        }
                    });

                }
            }

            function importData()
            {
                $('#btnSaveImport').text('importing...'); //change button text
                $('#btnSaveImport').attr('disabled',true); //set button disable
                $('#importModal .modal-title').text('Import Data'); 
                var url = "index.php/candidate/import_data";
                console.log($('#url').val());
                if($('#url').val() == ''){
                    alert('URL wajib diisi.');
                    return;
                }
                $.ajax({
                    url : url,
                    type: "POST",
                    data: $('#importModal #form').serialize(),
                    dataType: "JSON",
                    success: function(data)
                    {
                        if(data){
                            alert('Import data berhasil.');
                            $('#importModal').modal('hide');
                            reloadTable();
                        }else{
                            alert('Import data gagal.');
                        }
                        $('#btnSaveImport').text('Import');
                        $('#btnSaveImport').attr('disabled',false);
                        
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Import data gagal.');
                    }
                });
            }

            </script>
        </div>
    </body>
</html>
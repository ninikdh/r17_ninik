<!-- Add/Edit Item Modal -->
<div id="itemModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Candidate Form</h4>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label class="control-label col-md-3">Nama:</label>
                        <div class="col-md-9">
                            <input name="nama" placeholder="" class="form-control" type="text" id="nama">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Jabatan:</label>
                        <div class="col-md-9">
                            <input name="jabatan" placeholder="" class="form-control" type="text" id="jabatan">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Jenis Kelamin:</label>
                        <div class="col-md-9">
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                            <option value="">Pilih</option>
                            <option value="perempuan">Perempuan</option>
                            <option value="laki-laki">Laki-laki</option>
                        </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Alamat:</label>
                        <div class="col-md-9">
                            <textarea class="form-control" id="alamat" name="alamat"></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnSave" onclick="save()">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Import Modal -->
<div id="importModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Import Data</h4>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Url</label>
                            <div class="col-md-9">
                                <input name="url" placeholder="" class="form-control" type="text" id="url">
                                <span class="help-block"></span>
                            </div>
                            <small class="col-sm-6 col-sm-offset-3">Contoh: <a href="https://r17group.id/test-candidate" target="_blank">https://r17group.id/test-candidate</a> </small>
                        </div>
                    </div>
                </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnSaveImport" onclick="importData()">Import</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>





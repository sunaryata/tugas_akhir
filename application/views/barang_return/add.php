<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-dark">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-dark">
                            Form Input Barang return
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('barangreturn') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">
                                Kembali
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <?= form_open('', [], ['id_barang_return' => $id_barang_return, 'user_id' => $this->session->userdata('login_session')['user']]); ?>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="id_barang_return">ID Transaksi Barang return</label>
                    <div class="col-md-4">
                        <input value="<?= $id_barang_return; ?>" type="text" readonly="readonly" class="form-control">
                        <?= form_error('id_barang_return', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="tanggal_return">Tanggal return</label>
                    <div class="col-md-4">
                        <input value="<?= set_value('tanggal_return', date('Y-m-d')); ?>" name="tanggal_return" id="tanggal_return" type="text" class="form-control date" placeholder="Tanggal Masuk...">
                        <?= form_error('tanggal_return', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="id_supplier">Supplier</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <select name="id_supplier" id="id_supplier" class="custom-select">
                                <option value="" selected disabled>Pilih Supplier</option>
                                <?php foreach ($supplier as $s) : ?>
                                    <option <?= set_select('id_supplier', $s['id_supplier']) ?> value="<?= $s['id_supplier'] ?>"><?= $s['nama_supplier'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <!-- <div class="input-group-append">
                                <a class="btn btn-danger" href="<?= base_url('supplier/add'); ?>"><i class="fa fa-plus"></i></a>
                            </div> -->
                        </div>
                        <?= form_error('id_supplier', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col offset-md-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
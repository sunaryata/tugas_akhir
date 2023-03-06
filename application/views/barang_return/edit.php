<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-dark">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-danger">
                            Form Edit Barang return
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
                <?= form_open('', [], ['id_barang_return' => $barang['id_barang_return']]); ?>

                <div class="row form-group">

                    <label class="col-md-3 text-md-right" for="barang_id">Nama Barang</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <select name="barang_id" id="barang_id" class="custom-select">
                                <option value="" selected disabled>Pilih supplier Barang</option>
                                <?php foreach ($barangku as $s) : ?>
                                    <option <?= $barang['barang_id'] == $s['id_barang'] ? 'selected' : ''; ?> <?= set_select('id_barang', $s['id_barang']) ?> value="<?= $s['id_barang'] ?>"><?= $s['nama_barang'] ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <?= form_error('supplier_id', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="jumlah_return">Jumlah return</label>
                    <div class="col-md-9">
                        <input value="<?= set_value('jumlah_return', $barang['jumlah_return']); ?>" name="jumlah_return" id="jumlah_return" type="text" class="form-control" placeholder="Nama Barang...">
                        <?= form_error('jumlah_return', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>



                <div class="row form-group">
                    <div class="col-md-9 offset-md-3">
                        <button type="submit" class="btn btn-danger">Simpan</button>
                        <button type="reset" class="btn btn-secondary">Reset</bu>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-dark">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-danger">
                            Form Edit Barang mas
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('barangmasuk') ?>" class="btn btn-sm btn-secondary btn-icon-split">
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
                <?= form_open('', [], ['id_barang_masuk' => $barang['id_barang_masuk']]); ?>
                <!-- <?= form_open('', [], ['stok' => 0, 'id_barang_masuk' => $barang['id_barang_masuk']]); ?> -->
                <!-- <?= form_open('', [], ['stok' => 0, 'id_barang' => $barang['id_barang']]); ?> -->

                <div class="row form-group">

                    <label class="col-md-3 text-md-right" for="supplier_id">supplier Barang</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <select name="supplier_id" id="supplier_id" class="custom-select">
                                <option value="" selected disabled>Pilih supplier Barang</option>
                                <?php foreach ($supplier as $s) : ?>
                                    <option <?= $barang['barang_id'] == $s['id_supplier'] ? 'selected' : ''; ?> <?= set_select('id_supplier', $s['id_supplier']) ?> value="<?= $s['id_supplier'] ?>"><?= $s['nama_supplier'] ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <?= form_error('supplier_id', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
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

                <!-- <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="stok">stok</label>
                    <div class="col-md-5">
                        <input readonly="readonly" id="stok" type="number" class="form-control">
                    </div>
                </div> -->

                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="jumlah_masuk">Jumlah Masuk</label>
                    <div class="col-md-9">
                        <input value="<?= set_value('jumlah_masuk', $barang['jumlah_masuk']); ?>" name="jumlah_masuk" id="jumlah_masuk" type="text" class="form-control" placeholder="Jumlah masuk">
                        <?= form_error('jumlah_masuk', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                
                
                <!-- <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="total_stok">Total Stok</label>
                    <div class="col-md-5">
                        <input readonly="readonly" id="total_stok" name="total_stok" type="number" class="form-control" value=""> 
                    </div>
                </div> -->

                <!-- <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="jumlahku">Jumlah Masuk</label>
                    <div class="col-md-9">
                        <input value="" name="jumlahku" id="jumlahku" type="text" class="form-control" placeholder="Jumlahku">
                        <?= form_error('jumlah_masuk', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                 -->


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
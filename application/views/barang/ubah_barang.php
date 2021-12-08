<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-9">
            <form action="<?= base_url('barang/ubahBarang'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="hidden">
                        <input type="hidden" id="id" name="id" value="<?= $barang[0]['id']; ?>">
                        <input type="hidden" id="old_pict" name="old_pict" value="<?= $barang[0]['image']; ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="nama_barang" name="nama_barang" placeholder="Masukkan Nama Barang" value="<?= $barang[0]['nama_barang'];?>">
                    </div>
                    <div class="form-group">
                        <select name="id_kategori" class="form-control form-control-user">
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($kategori as $k) { ?>
                                <option value="<?= $k['id_kategori']; ?>" <?= ($k['id_kategori']==$barang[0]['id_kategori'])?'selected':'' ?>><?= $k['kategori']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="harga" name="harga" placeholder="Masukkan jumlah harga" value="<?= $barang[0]['harga'];?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="stok" name="stok" placeholder="Masukkan nominal stok" value="<?= $barang[0]['stok'];?>">
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control form-control-user" id="image" name="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
<div class="card">
    <div class="card-header">
        Advanced Filter
        <a class="card-header-down float-right">
            <span data-feather="chevron-down"></span>
        </a>
    </div>
    <div class="card-body card-filter" style="display: none;">
        <form class="form row" id="wrap-filter">
            <input type="hidden" name="kategori" value="{{ $data->kategori }}">
            <div class="col-4">
                <select name="type" id="type-filter" class="form-control">
                    <option value="" selected>---pilih status---</option>
                    <option value="1">available</option>
                    <option value="9">not available</option>
                </select>
            </div>
            <div class="col-4">
                <select name="merk" id="merk-filter" class="form-control">
                    <option value="" selected>---pilih jenis---</option>
                    <option value="Jenis1">Jenis1</option>
                    <option value="Jenis2">Jenis2</option>
                    <option value="Jenis2">Jenis2</option>
                </select>
            </div>
            <div class="col-4">
                <div class="form-label-group input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">harga >=</div>
                    </div>
                    <input type="text" id="merk" name="merk" class="form-control" placeholder="Merk Barang" required>
                </div>
            </div>
        </form>
    </div>
</div>

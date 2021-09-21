<div class="card">
    <div class="card-header">
        Form Input
        <a class="card-header-down float-right">
            <span data-feather="chevron-down"></span>
        </a>
    </div>
    <div class="card-body card-form"
        {{-- style="display: none;" --}}
        >
        <div class="row">
            <div class="col-md-3">
                <img src="/img/client.jpg" class="img img-reponsive" style="width: 100%">
            </div>

            <div class="col-md-9 pt-4">
                <form method="POST" action="/api/v1/jasa?model={{ $data->model }}" class="form form-horizontal" id="form-submit" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-label-group col-10">
                                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Client Name" value="" required>
                                    <label for="nama">Name</label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label-group col-10">
                                    <input type="number" id="kontak" name="kontak" class="form-control" placeholder="Client Name" required>
                                    <label for="kontak">Contact</label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label-group col-10">
                                    <textarea id="keterangan" name="keterangan" class="form-control" placeholder="keterangan Client" required></textarea>
                                    <label for="keterangan">Information</label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-label-group col-10">
                                    <textarea id="alamat" name="alamat" class="form-control" placeholder="Alamat Client" required></textarea>
                                    <label for="alamat">Address</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <img src="/img/ktp-temp.jpg" style="width: 270px;">
                            <input type="file" name="photo" class="form-control" accept="image/*" />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-md-12 mt-4">
                            <button type="submit" class="btn btn-primary btn-square float-right" id="submit" data-action="/api/v1/jasa?model={{ $data->model }}"><span class="fa fa-check-circle"></span> Save</button>
                            <a class="btn btn-secondary btn-square float-right text-white mr-2" id="btn-cancel"> Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

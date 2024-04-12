<div class="container">
    @if ($errors->any())
        <div class="pt-3">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    @if (session()->has('message'))
        <div class="pt-3">
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        </div>
    @endif
    <!-- START FORM -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <form>
            <div class="mb-3 row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model="nama">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" wire:model="email">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model="alamat">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    @if ($updateData)
                        <button type="button" class="btn btn-success" name="submit"
                            wire:click="update()">UPDATE</button>
                    @else
                        <button type="button" class="btn btn-primary" name="submit"
                            wire:click="store()">SIMPAN</button>
                    @endif
                    <button type="button" class="btn btn-secondary" name="submit" wire:click="clear()">CLEAR</button>
                </div>
            </div>
        </form>
    </div>
    <!-- AKHIR FORM -->

    <!-- START DATA -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h1>Data Pegawai</h1>
        <div class="py-3">
            <input wire:model.live="keyword" type="text" class="form-control mb-3 w-25" placeholder="Search">
        </div>
        @if ($employee_selected_id)
            <a class="btn btn-danger btn-md mb-3" wire:click="delete_confirmation('')" data-bs-toggle="modal"
                data-bs-target="#deleteModal">Hapus {{ count($employee_selected_id) }} data</a>
        @endif
        <table class="table table-striped table-sortable">
            <thead>
                <tr>
                    <th></th>
                    <th class="col-md-1">No</th>
                    <th class="col-md-4 sort @if ($sortColumn == 'nama') {{ $sortDirection }} @endif" wire:click="sort('nama')">
                        Nama</th>
                    <th class="col-md-3 sort @if ($sortColumn == 'email') {{ $sortDirection }} @endif" wire:click="sort('email')">Email</th>
                    <th class="col-md-2 sort @if ($sortColumn == 'alamat') {{ $sortDirection }} @endif" wire:click="sort('alamat')">Alamat</th>
                    <th class="col-md-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataEmployees as $key => $value)
                    <tr>
                        <td>
                            <input type="checkbox" wire:key="{{ $value->id }}" value="{{ $value->id }}"
                                wire:model.live="employee_selected_id">
                        </td>
                        <td>{{ $dataEmployees->firstItem() + $key }}</td>
                        <td>{{ $value->nama }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->alamat }}</td>
                        <td>
                            <a wire:click="edit({{ $value->id }})" class="btn btn-warning btn-sm">Edit</a>
                            <a wire:click="delete_confirmation({{ $value->id }})" class="btn btn-danger btn-sm"
                                data-bs-toggle="modal" data-bs-target="#deleteModal">Hapus</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deleteModalLabel">Hapus Data Pegawai</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Yakin Ingin Menghapus Data?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            wire:click="delete()">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
        {{ $dataEmployees->links() }}
    </div>
    <!-- AKHIR DATA -->
</div>

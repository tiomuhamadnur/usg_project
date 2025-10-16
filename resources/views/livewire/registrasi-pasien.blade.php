<div>
    <div class="block-content block-content-full">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="py-2">
                    <label for="code" class="form-label fw-semibold">🔎 Cari Pasien</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light">
                            <i class="fa fa-user-injured text-primary"></i>
                        </span>
                        <input type="text" class="form-control" name="value" id="value"
                            wire:model.live.debounce.300ms='value' placeholder="Cari Data Pasien............" autofocus
                            required autocomplete="off">
                        <span class="btn btn-primary">
                            <i class="fa fa-search text-white"></i> Cari
                        </span>
                    </div>
                    <small class="text-muted">
                        Bisa menggunakan nama, nik ktp, no. hp atau kode member.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        @if ($pasiens->count() > 0)
            <ul class="list-group w-100">
                @foreach ($pasiens as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $item->name }}</strong><br>
                            NIK: {{ $item->nik ?? '-' }} <br>
                            HP: {{ $item->no_hp ?? '-' }} <br>
                            Member ID: {{ $item->member_code ?? '-' }}
                        </div>
                        <a href="{{ route('registrasi.create', ['uuid' => $item->uuid]) }}"
                            class="btn btn-lg btn-primary">
                            <i class="fa fa-thumbs-up"></i> Pilih
                        </a>
                    </li>
                @endforeach
            </ul>
        @elseif($value)
            <div class="alert alert-warning mt-3">
                Tidak ada pasien ditemukan.
            </div>
        @endif
    </div>
</div>

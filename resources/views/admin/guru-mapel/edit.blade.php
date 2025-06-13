@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Penugasan Guru</h1>
                <p class="text-gray-600">Edit penugasan guru ke mata pelajaran</p>
            </div>
            <div>
                <a href="{{ route('admin.guru-mapel.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Current Assignment Info -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
        <div class="flex items-center mb-2">
            <i class="fas fa-info-circle text-yellow-600 mr-2"></i>
            <h3 class="text-lg font-medium text-yellow-800">Penugasan Saat Ini</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
            <div>
                <span class="text-yellow-700 font-medium">Guru:</span>
                <div class="text-yellow-900">{{ $guru->nama }}</div>
            </div>
            <div>
                <span class="text-yellow-700 font-medium">Mata Pelajaran:</span>
                <div class="text-yellow-900">{{ $mapel->mapel }}</div>
            </div>
            <div>
                <span class="text-yellow-700 font-medium">Kurikulum:</span>
                <div class="text-yellow-900">{{ $kurikulum->nama_kurikulum }}</div>
            </div>
            <div>
                <span class="text-yellow-700 font-medium">Kelas:</span>
                <div class="text-yellow-900">{{ $currentKelas->nama_kelas }}</div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.guru-mapel.update', [$guru->guru_id, $mapel->mapel_id, $kurikulum->kurikulum_id, $currentKelas->kelas_id]) }}" method="POST" id="editForm">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Section -->
            <div class="lg:col-span-2">
                <div class="space-y-6">
                    <!-- Guru Selection -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-chalkboard-teacher mr-2"></i>Pilih Guru Baru
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label for="new_guru_id" class="block text-sm font-medium text-gray-700 mb-2">Guru <span class="text-red-500">*</span></label>
                                <select name="new_guru_id" id="new_guru_id" required 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('new_guru_id') border-red-500 @enderror">
                                    <option value="">Pilih Guru</option>
                                    @foreach($gurus as $g)
                                        <option value="{{ $g->guru_id }}" 
                                                {{ (old('new_guru_id', $guru->guru_id) == $g->guru_id) ? 'selected' : '' }}
                                                data-nama="{{ $g->nama }}" 
                                                data-nip="{{ $g->nip }}" 
                                                data-nuptk="{{ $g->nuptk }}" 
                                                data-jabatan="{{ $g->jabatan }}"
                                                data-foto="{{ $g->foto ? asset('storage/' . $g->foto) : '' }}">
                                            {{ $g->nama }} - {{ $g->jabatan }}
                                            @if($g->nip)
                                                (NIP: {{ $g->nip }})
                                            @elseif($g->nuptk)
                                                (NUPTK: {{ $g->nuptk }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('new_guru_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Subject Selection -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-book mr-2"></i>Mata Pelajaran Baru
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label for="new_mapel_id" class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran <span class="text-red-500">*</span></label>
                                <select name="new_mapel_id" id="new_mapel_id" required 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('new_mapel_id') border-red-500 @enderror">
                                    <option value="">Pilih Mata Pelajaran</option>
                                    @foreach($mapels as $m)
                                        <option value="{{ $m->mapel_id }}" 
                                                {{ (old('new_mapel_id', $mapel->mapel_id) == $m->mapel_id) ? 'selected' : '' }}
                                                data-nama="{{ $m->mapel }}" 
                                                data-kode="{{ $m->kode_mapel }}" 
                                                data-deskripsi="{{ $m->deskripsi }}">
                                            {{ $m->kode_mapel }} - {{ $m->mapel }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('new_mapel_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                  <!-- Kurikulum & Kelas -->
<div class="bg-gray-50 p-6 rounded-lg">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">
        <i class="fas fa-graduation-cap mr-2"></i>Kurikulum & Kelas Baru
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Kurikulum Select -->
        <div>
            <label for="new_kurikulum_id" class="block text-sm font-medium text-gray-700 mb-2">
                Kurikulum <span class="text-red-500">*</span>
            </label>
            <select name="new_kurikulum_id" id="new_kurikulum_id" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('new_kurikulum_id') border-red-500 @enderror">
                <option value="">Pilih Kurikulum</option>
                @foreach($kurikulums as $k)
                    <option value="{{ $k->kurikulum_id }}"
                        {{ (old('new_kurikulum_id', $kurikulum->kurikulum_id ?? '') == $k->kurikulum_id) ? 'selected' : '' }}>
                        {{ $k->nama_kurikulum }} ({{ $k->tahun_ajaran }})
                    </option>
                @endforeach
            </select>
            @error('new_kurikulum_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kelas Select -->
        <div>
            <label for="new_kelas_id" class="block text-sm font-medium text-gray-700 mb-2">
                Kelas <span class="text-red-500">*</span>
            </label>
            <select name="new_kelas_id" id="new_kelas_id" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('new_kelas_id') border-red-500 @enderror">
                <option value="">Pilih Kelas</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->kelas_id }}"
                        data-kurikulum="{{ $k->kurikulum_id }}"
                        {{ (old('new_kelas_id', $currentKelas->kelas_id ?? '') == $k->kelas_id) ? 'selected' : '' }}>
                        {{ $k->nama_kelas }} - Tingkat {{ $k->tingkat }} ({{ $k->kurikulum->nama_kurikulum }})
                    </option>
                @endforeach
            </select>
            @error('new_kelas_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3 pt-6 border-t">
                        <a href="{{ route('admin.guru-mapel.index') }}" 
                           class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                            <i class="fas fa-save mr-2"></i>Update Penugasan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Preview Section -->
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg p-6 sticky top-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-eye mr-2"></i>Preview Penugasan Baru
                    </h3>
                    
                    <!-- Guru Preview -->
                    <div class="mb-6" id="guruPreview">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Guru</h4>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="flex items-center space-x-3">
                                <img id="previewGuruFoto" src="{{ $guru->foto ? asset('storage/' . $guru->foto) : '' }}" alt="" class="w-12 h-12 rounded-full object-cover border-2 border-gray-200" style="{{ $guru->foto ? 'display: block;' : 'display: none;' }}">
                                <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center" id="previewGuruIcon" style="{{ $guru->foto ? 'display: none;' : 'display: flex;' }}">
                                    <i class="fas fa-user text-gray-500"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900" id="previewGuruNama">{{ $guru->nama }}</div>
                                    <div class="text-sm text-gray-500" id="previewGuruNip">
                                        @if($guru->nip)
                                            NIP: {{ $guru->nip }}
                                        @elseif($guru->nuptk)
                                            NUPTK: {{ $guru->nuptk }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                    <div class="text-xs text-blue-600" id="previewGuruJabatan">{{ $guru->jabatan }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mapel Preview -->
                    <div class="mb-6" id="mapelPreview">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Mata Pelajaran</h4>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="font-medium text-gray-900" id="previewMapelNama">{{ $mapel->mapel }}</div>
                            <div class="text-sm text-gray-500" id="previewMapelKode">{{ $mapel->kode_mapel }}</div>
                            <div class="text-xs text-gray-400 mt-1" id="previewMapelDeskripsi">{{ $mapel->deskripsi ?: 'Tidak ada deskripsi' }}</div>
                        </div>
                    </div>

                    <!-- Kurikulum & Kelas Preview -->
                    <div class="mb-6" id="kurikulumPreview">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Kurikulum & Kelas</h4>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">Kurikulum:</span>
                                <span class="font-medium text-gray-900" id="previewKurikulumNama">{{ $kurikulum->nama_kurikulum }}</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">Tahun Ajaran:</span>
                                <span class="font-medium text-gray-900" id="previewKurikulumTahun">{{ $kurikulum->tahun_ajaran }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Kelas:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800" id="previewKelas">{{ $kelas }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Changes Summary -->
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Ringkasan Perubahan</h4>
                        <div class="space-y-2 text-xs" id="changesSummary">
                            <div class="text-gray-500">Tidak ada perubahan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    const originalValues = {
        guru_id: '{{ $guru->guru_id }}',
        guru_nama: '{{ $guru->nama }}',
        mapel_id: '{{ $mapel->mapel_id }}',
        mapel_nama: '{{ $mapel->mapel }}',
        kurikulum_id: '{{ $kurikulum->kurikulum_id }}',
        kurikulum_nama: '{{ $kurikulum->nama_kurikulum }}',
        kelas: '{{ $currentKelas->nama_kelas }} - {{ $currentKelas->tingkat }} ({{ $kurikulum->nama_kurikulum }})'
    };

    document.getElementById('new_guru_id').addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        document.getElementById('previewGuruNama').textContent = opt.getAttribute('data-nama');
        document.getElementById('previewGuruNip').textContent = opt.getAttribute('data-nip') ? `NIP: ${opt.getAttribute('data-nip')}` : (opt.getAttribute('data-nuptk') ? `NUPTK: ${opt.getAttribute('data-nuptk')}` : '-');
        document.getElementById('previewGuruJabatan').textContent = opt.getAttribute('data-jabatan');

        const foto = opt.getAttribute('data-foto');
        if (foto) {
            document.getElementById('previewGuruFoto').src = foto;
            document.getElementById('previewGuruFoto').style.display = 'block';
            document.getElementById('previewGuruIcon').style.display = 'none';
        } else {
            document.getElementById('previewGuruFoto').style.display = 'none';
            document.getElementById('previewGuruIcon').style.display = 'flex';
        }
        updateChangesSummary();
    });

    document.getElementById('new_mapel_id').addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        document.getElementById('previewMapelNama').textContent = opt.getAttribute('data-nama');
        document.getElementById('previewMapelKode').textContent = opt.getAttribute('data-kode');
        document.getElementById('previewMapelDeskripsi').textContent = opt.getAttribute('data-deskripsi') || 'Tidak ada deskripsi';
        updateChangesSummary();
    });

    document.getElementById('new_kurikulum_id').addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        document.getElementById('previewKurikulumNama').textContent = opt.getAttribute('data-nama');
        document.getElementById('previewKurikulumTahun').textContent = opt.getAttribute('data-tahun');
        updateChangesSummary();
    });

    document.getElementById('new_kelas_id').addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        document.getElementById('previewKelas').textContent = opt.text;
        updateChangesSummary();
    });

    function updateChangesSummary() {
        const changes = [];
        const newGuruId = document.getElementById('new_guru_id').value;
        const newMapelId = document.getElementById('new_mapel_id').value;
        const newKurikulumId = document.getElementById('new_kurikulum_id').value;
        const newKelasEl = document.getElementById('new_kelas_id');
        const newKelasVal = newKelasEl.value;
        const newKelasText = newKelasEl.options[newKelasEl.selectedIndex]?.text || '';

        if (newGuruId && newGuruId !== originalValues.guru_id) {
            const nama = newKelasEl.form.querySelector('#new_guru_id option:checked').getAttribute('data-nama');
            changes.push(`<div class="text-blue-600">• Guru: ${originalValues.guru_nama} → ${nama}</div>`);
        }
        if (newMapelId && newMapelId !== originalValues.mapel_id) {
            const nama = document.querySelector('#new_mapel_id option:checked').getAttribute('data-nama');
            changes.push(`<div class="text-blue-600">• Mata Pelajaran: ${originalValues.mapel_nama} → ${nama}</div>`);
        }
        if (newKurikulumId && newKurikulumId !== originalValues.kurikulum_id) {
            const nama = document.querySelector('#new_kurikulum_id option:checked').getAttribute('data-nama');
            changes.push(`<div class="text-blue-600">• Kurikulum: ${originalValues.kurikulum_nama} → ${nama}</div>`);
        }
        if (newKelasVal && newKelasText !== originalValues.kelas) {
            changes.push(`<div class="text-blue-600">• Kelas: ${originalValues.kelas} → ${newKelasText}</div>`);
        }

        const changesSummary = document.getElementById('changesSummary');
        changesSummary.innerHTML = changes.length ? changes.join('') : '<div class="text-gray-500">Tidak ada perubahan</div>';
    }

    document.getElementById('editForm').addEventListener('submit', function(e) {
        if (!document.getElementById('new_guru_id').value || !document.getElementById('new_mapel_id').value || !document.getElementById('new_kurikulum_id').value || !document.getElementById('new_kelas_id').value) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang diperlukan!');
        }
    });

    updateChangesSummary();
</script>
@endsection
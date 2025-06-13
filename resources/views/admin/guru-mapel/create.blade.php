@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tambah Penugasan Guru</h1>
                <p class="text-gray-600">Tambahkan penugasan guru ke mata pelajaran</p>
            </div>
            <div>
                <a href="{{ route('admin.guru-mapel.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.guru-mapel.store') }}" method="POST" id="createForm">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Section -->
            <div class="lg:col-span-2">
                <div class="space-y-6">
                    <!-- Guru Selection -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-chalkboard-teacher mr-2"></i>Pilih Guru
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label for="guru_id" class="block text-sm font-medium text-gray-700 mb-2">Guru <span class="text-red-500">*</span></label>
                                <select name="guru_id" id="guru_id" required 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('guru_id') border-red-500 @enderror">
                                    <option value="">Pilih Guru</option>
                                    @foreach($gurus as $guru)
                                        <option value="{{ $guru->guru_id }}" {{ old('guru_id') == $guru->guru_id ? 'selected' : '' }}
                                                data-nama="{{ $guru->nama }}" 
                                                data-nip="{{ $guru->nip }}" 
                                                data-nuptk="{{ $guru->nuptk }}" 
                                                data-jabatan="{{ $guru->jabatan }}"
                                                data-foto="{{ $guru->foto ? asset('storage/' . $guru->foto) : '' }}">
                                            {{ $guru->nama }} - {{ $guru->jabatan }}
                                            @if($guru->nip)
                                                (NIP: {{ $guru->nip }})
                                            @elseif($guru->nuptk)
                                                (NUPTK: {{ $guru->nuptk }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('guru_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Subject Selection -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-book mr-2"></i>Mata Pelajaran
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label for="mapel_id" class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran <span class="text-red-500">*</span></label>
                                <select name="mapel_id" id="mapel_id" required 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mapel_id') border-red-500 @enderror">
                                    <option value="">Pilih Mata Pelajaran</option>
                                    @foreach($mapels as $mapel)
                                        <option value="{{ $mapel->mapel_id }}" {{ old('mapel_id') == $mapel->mapel_id ? 'selected' : '' }}
                                                data-nama="{{ $mapel->mapel }}" 
                                                data-kode="{{ $mapel->kode_mapel }}" 
                                                data-deskripsi="{{ $mapel->deskripsi }}">
                                            {{ $mapel->kode_mapel }} - {{ $mapel->mapel }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('mapel_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Curriculum and Class -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-graduation-cap mr-2"></i>Kurikulum & Kelas
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="kurikulum_id" class="block text-sm font-medium text-gray-700 mb-2">Kurikulum <span class="text-red-500">*</span></label>
                                <select name="kurikulum_id" id="kurikulum_id" required 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kurikulum_id') border-red-500 @enderror">
                                    <option value="">Pilih Kurikulum</option>
                                    @foreach($kurikulums as $kurikulum)
                                        <option value="{{ $kurikulum->kurikulum_id }}" {{ old('kurikulum_id') == $kurikulum->kurikulum_id ? 'selected' : '' }}
                                                data-nama="{{ $kurikulum->nama_kurikulum }}" 
                                                data-tahun="{{ $kurikulum->tahun_ajaran }}">
                                            {{ $kurikulum->nama_kurikulum }} ({{ $kurikulum->tahun_ajaran }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('kurikulum_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-2">Kelas <span class="text-red-500">*</span></label>
                                <select name="kelas_id" id="kelas_id" required 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kelas_id') border-red-500 @enderror">
                                    <option value="">Pilih Kelas</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->kelas_id }}" {{ old('kelas_id') == $k->kelas_id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }} - {{ $k->tingkat }} ({{ $k->kurikulum->nama_kurikulum }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('kelas_id')
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
                            <i class="fas fa-save mr-2"></i>Simpan Penugasan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Preview Section -->
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg p-6 sticky top-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-eye mr-2"></i>Preview Penugasan
                    </h3>
                    
                    <!-- Guru Preview -->
                    <div class="mb-6" id="guruPreview" style="display: none;">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Guru</h4>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="flex items-center space-x-3">
                                <img id="previewGuruFoto" src="{{ asset('/storage/uploads/guru/' . $guru->foto) }}" alt="" class="w-12 h-12 rounded-full object-cover border-2 border-gray-200" style="display: none;">
                                <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center" id="previewGuruIcon">
                                    <i class="fas fa-user text-gray-500"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900" id="previewGuruNama">-</div>
                                    <div class="text-sm text-gray-500" id="previewGuruNip">-</div>
                                    <div class="text-xs text-blue-600" id="previewGuruJabatan">-</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mapel Preview -->
                    <div class="mb-6" id="mapelPreview" style="display: none;">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Mata Pelajaran</h4>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="font-medium text-gray-900" id="previewMapelNama">-</div>
                            <div class="text-sm text-gray-500" id="previewMapelKode">-</div>
                            <div class="text-xs text-gray-400 mt-1" id="previewMapelDeskripsi">-</div>
                        </div>
                    </div>

                    <!-- Kurikulum & Kelas Preview -->
                    <div class="mb-6" id="kurikulumPreview" style="display: none;">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Kurikulum & Kelas</h4>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">Kurikulum:</span>
                                <span class="font-medium text-gray-900" id="previewKurikulumNama">-</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">Tahun Ajaran:</span>
                                <span class="font-medium text-gray-900" id="previewKurikulumTahun">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Kelas:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800" id="previewKelas">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Validation Status -->
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Status Validasi</h4>
                        <div class="space-y-2">
                            <div class="flex items-center" id="statusGuru">
                                <i class="fas fa-circle text-gray-300 text-xs mr-2"></i>
                                <span class="text-sm text-gray-500">Guru belum dipilih</span>
                            </div>
                            <div class="flex items-center" id="statusMapel">
                                <i class="fas fa-circle text-gray-300 text-xs mr-2"></i>
                                <span class="text-sm text-gray-500">Mata pelajaran belum dipilih</span>
                            </div>
                            <div class="flex items-center" id="statusKurikulum">
                                <i class="fas fa-circle text-gray-300 text-xs mr-2"></i>
                                <span class="text-sm text-gray-500">Kurikulum belum dipilih</span>
                            </div>
                            <div class="flex items-center" id="statusKelas">
                                <i class="fas fa-circle text-gray-300 text-xs mr-2"></i>
                                <span class="text-sm text-gray-500">Kelas belum dipilih</span>
                            </div>
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
    // Update preview when guru is selected
    document.getElementById('guru_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const guruPreview = document.getElementById('guruPreview');
        const statusGuru = document.getElementById('statusGuru');
        
        if (this.value) {
            const nama = selectedOption.getAttribute('data-nama');
            const nip = selectedOption.getAttribute('data-nip');
            const nuptk = selectedOption.getAttribute('data-nuptk');
            const jabatan = selectedOption.getAttribute('data-jabatan');
            const foto = selectedOption.getAttribute('data-foto');
            
            document.getElementById('previewGuruNama').textContent = nama;
            document.getElementById('previewGuruNip').textContent = nip ? `NIP: ${nip}` : (nuptk ? `NUPTK: ${nuptk}` : '-');
            document.getElementById('previewGuruJabatan').textContent = jabatan;
            
            if (foto) {
                document.getElementById('previewGuruFoto').src = foto;
                document.getElementById('previewGuruFoto').style.display = 'block';
                document.getElementById('previewGuruIcon').style.display = 'none';
            } else {
                document.getElementById('previewGuruFoto').style.display = 'none';
                document.getElementById('previewGuruIcon').style.display = 'flex';
            }
            
            guruPreview.style.display = 'block';
            statusGuru.innerHTML = '<i class="fas fa-check-circle text-green-500 text-xs mr-2"></i><span class="text-sm text-green-600">Guru dipilih</span>';
        } else {
            guruPreview.style.display = 'none';
            statusGuru.innerHTML = '<i class="fas fa-circle text-gray-300 text-xs mr-2"></i><span class="text-sm text-gray-500">Guru belum dipilih</span>';
        }
    });

    // Update preview when mapel is selected
    document.getElementById('mapel_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const mapelPreview = document.getElementById('mapelPreview');
        const statusMapel = document.getElementById('statusMapel');
        
        if (this.value) {
            const nama = selectedOption.getAttribute('data-nama');
            const kode = selectedOption.getAttribute('data-kode');
            const deskripsi = selectedOption.getAttribute('data-deskripsi');
            
            document.getElementById('previewMapelNama').textContent = nama;
            document.getElementById('previewMapelKode').textContent = kode;
            document.getElementById('previewMapelDeskripsi').textContent = deskripsi || 'Tidak ada deskripsi';
            
            mapelPreview.style.display = 'block';
            statusMapel.innerHTML = '<i class="fas fa-check-circle text-green-500 text-xs mr-2"></i><span class="text-sm text-green-600">Mata pelajaran dipilih</span>';
        } else {
            mapelPreview.style.display = 'none';
            statusMapel.innerHTML = '<i class="fas fa-circle text-gray-300 text-xs mr-2"></i><span class="text-sm text-gray-500">Mata pelajaran belum dipilih</span>';
        }
    });

    // Update preview when kurikulum is selected
    document.getElementById('kurikulum_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const statusKurikulum = document.getElementById('statusKurikulum');
        
        if (this.value) {
            const nama = selectedOption.getAttribute('data-nama');
            const tahun = selectedOption.getAttribute('data-tahun');
            
            document.getElementById('previewKurikulumNama').textContent = nama;
            document.getElementById('previewKurikulumTahun').textContent = tahun;
            
            statusKurikulum.innerHTML = '<i class="fas fa-check-circle text-green-500 text-xs mr-2"></i><span class="text-sm text-green-600">Kurikulum dipilih</span>';
            updateKurikulumPreview();
        } else {
            statusKurikulum.innerHTML = '<i class="fas fa-circle text-gray-300 text-xs mr-2"></i><span class="text-sm text-gray-500">Kurikulum belum dipilih</span>';
            updateKurikulumPreview();
        }
    });

    // Update preview when kelas is selected
    document.getElementById('kelas_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const statusKelas = document.getElementById('statusKelas');
        
        if (this.value) {
            const namaKelas = selectedOption.textContent.trim();
            document.getElementById('previewKelas').textContent = namaKelas;
            statusKelas.innerHTML = '<i class="fas fa-check-circle text-green-500 text-xs mr-2"></i><span class="text-sm text-green-600">Kelas dipilih</span>';
            updateKurikulumPreview();
        } else {
            statusKelas.innerHTML = '<i class="fas fa-circle text-gray-300 text-xs mr-2"></i><span class="text-sm text-gray-500">Kelas belum dipilih</span>';
            updateKurikulumPreview();
        }
    });

    function updateKurikulumPreview() {
        const kurikulumId = document.getElementById('kurikulum_id').value;
        const kelasId = document.getElementById('kelas_id').value;
        const kurikulumPreview = document.getElementById('kurikulumPreview');
        
        if (kurikulumId || kelasId) {
            kurikulumPreview.style.display = 'block';
        } else {
            kurikulumPreview.style.display = 'none';
        }
    }

    // Form validation
    document.getElementById('createForm').addEventListener('submit', function(e) {
        const guru = document.getElementById('guru_id').value;
        const mapel = document.getElementById('mapel_id').value;
        const kurikulum = document.getElementById('kurikulum_id').value;
        const kelas = document.getElementById('kelas_id').value;
        
        if (!guru || !mapel || !kurikulum || !kelas) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang diperlukan!');
            return false;
        }
    });
</script>
@endsection
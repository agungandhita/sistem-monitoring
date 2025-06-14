@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tambah Jadwal Pelajaran</h1>
                <p class="text-gray-600">Tambahkan jadwal pelajaran baru ke dalam sistem</p>
            </div>
            <a href="{{ route('admin.jadwal.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('admin.jadwal.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Hari -->
            <div>
                <label for="hari" class="block text-sm font-medium text-gray-700 mb-1">Hari <span class="text-red-500">*</span></label>
                <select id="hari" name="hari" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('hari') border-red-500 @enderror" required>
                    <option value="">Pilih Hari</option>
                    @foreach($hari as $h)
                        <option value="{{ $h }}" {{ old('hari', request('hari')) == $h ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                </select>
                @error('hari')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jam Ke -->
            <div>
                <label for="jam_ke" class="block text-sm font-medium text-gray-700 mb-1">Jam Ke <span class="text-red-500">*</span></label>
                <select id="jam_ke" name="jam_ke" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('jam_ke') border-red-500 @enderror" required>
                    <option value="">Pilih Jam Ke</option>
                    @foreach($jamKe as $jk)
                        <option value="{{ $jk }}" {{ old('jam_ke') == $jk ? 'selected' : '' }}>{{ $jk }}</option>
                    @endforeach
                </select>
                @error('jam_ke')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jam Mulai -->
            <div>
                <label for="jam_mulai" class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai <span class="text-red-500">*</span></label>
                <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('jam_mulai') border-red-500 @enderror" required>
                @error('jam_mulai')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jam Selesai -->
            <div>
                <label for="jam_selesai" class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai <span class="text-red-500">*</span></label>
                <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('jam_selesai') border-red-500 @enderror" required>
                @error('jam_selesai')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kelas -->
            <div>
                <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-1">Kelas <span class="text-red-500">*</span></label>
                <select id="kelas_id" name="kelas_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('kelas_id') border-red-500 @enderror" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->kelas_id }}" {{ old('kelas_id') == $k->kelas_id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kurikulum -->
            <div>
                <label for="kurikulum_id" class="block text-sm font-medium text-gray-700 mb-1">Kurikulum <span class="text-red-500">*</span></label>
                <select id="kurikulum_id" name="kurikulum_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('kurikulum_id') border-red-500 @enderror" required>
                    <option value="">Pilih Kurikulum</option>
                    @foreach($kurikulums as $kurikulum)
                        <option value="{{ $kurikulum->kurikulum_id }}" {{ old('kurikulum_id') == $kurikulum->kurikulum_id ? 'selected' : '' }}>{{ $kurikulum->nama_kurikulum }}</option>
                    @endforeach
                </select>
                @error('kurikulum_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Guru -->
            <div>
                <label for="guru_id" class="block text-sm font-medium text-gray-700 mb-1">Guru <span class="text-red-500">*</span></label>
                <select id="guru_id" name="guru_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('guru_id') border-red-500 @enderror" required>
                    <option value="">Pilih Guru</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->guru_id }}" {{ old('guru_id') == $guru->guru_id ? 'selected' : '' }}>{{ $guru->nama }}</option>
                    @endforeach
                </select>
                @error('guru_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mapel -->
            <div>
                <label for="mapel_id" class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran <span class="text-red-500">*</span></label>
                <select id="mapel_id" name="mapel_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('mapel_id') border-red-500 @enderror" required>
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->mapel_id }}" {{ old('mapel_id') == $mapel->mapel_id ? 'selected' : '' }}>{{ $mapel->mapel }}</option>
                    @endforeach
                </select>
                @error('mapel_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tahun Ajaran -->
            <div>
                <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran <span class="text-red-500">*</span></label>
                <input type="text" id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran') }}" placeholder="Contoh: 2023/2024" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('tahun_ajaran') border-red-500 @enderror" required>
                @error('tahun_ajaran')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select id="status" name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('status') border-red-500 @enderror" required>
                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Catatan -->
        <div>
            <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
            <textarea id="catatan" name="catatan" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('catatan') border-red-500 @enderror">{{ old('catatan') }}</textarea>
            @error('catatan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.jadwal.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition duration-200">Batal</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">Simpan</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const guruSelect = document.getElementById('guru_id');
        const kurikulumSelect = document.getElementById('kurikulum_id');
        const mapelSelect = document.getElementById('mapel_id');
        const originalMapelOptions = [...mapelSelect.options].map(option => {
            return {
                value: option.value,
                text: option.text
            };
        });
        
        // Function to update mapel options based on guru and kurikulum
        function updateMapelOptions() {
            const guruId = guruSelect.value;
            const kurikulumId = kurikulumSelect.value;
            
            // If either guru or kurikulum is not selected, reset to original options
            if (!guruId || !kurikulumId) {
                resetMapelOptions();
                return;
            }
            
            // Show loading state
            mapelSelect.disabled = true;
            mapelSelect.innerHTML = '<option value="">Loading...</option>';
            
            // Fetch mapels for the selected guru and kurikulum
            fetch(`{{ route('admin.jadwal.get-mapels-by-guru') }}?guru_id=${guruId}&kurikulum_id=${kurikulumId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Check if response contains error
                    if (data.error) {
                        mapelSelect.innerHTML = '<option value="">Error: ' + data.error + '</option>';
                        mapelSelect.disabled = false;
                        return;
                    }
                    
                    // Clear existing options
                    mapelSelect.innerHTML = '<option value="">Pilih Mata Pelajaran</option>';
                    
                    if (data.length === 0) {
                        mapelSelect.innerHTML = '<option value="">Tidak ada mata pelajaran tersedia</option>';
                    } else {
                        data.forEach(mapel => {
                            const option = document.createElement('option');
                            option.value = mapel.mapel_id;
                            // Perbaikan: gunakan 'mapel.mapel' bukan 'mapel.nama_mapel'
                            option.textContent = mapel.mapel;
                            mapelSelect.appendChild(option);
                        });
                    }
                    
                    // Re-enable select
                    mapelSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error fetching mapel data:', error);
                    mapelSelect.innerHTML = '<option value="">Terjadi kesalahan saat memuat data</option>';
                    mapelSelect.disabled = false;
                });
        }
        
        // Function to reset mapel options to original state
        function resetMapelOptions() {
            mapelSelect.innerHTML = '';
            originalMapelOptions.forEach(option => {
                const newOption = document.createElement('option');
                newOption.value = option.value;
                newOption.textContent = option.text;
                mapelSelect.appendChild(newOption);
            });
        }
        
        // Add event listeners
        guruSelect.addEventListener('change', updateMapelOptions);
        kurikulumSelect.addEventListener('change', updateMapelOptions);
        
        // Initialize on page load if values are pre-selected
        if (guruSelect.value && kurikulumSelect.value) {
            updateMapelOptions();
        }
    });
</script>
@endsection
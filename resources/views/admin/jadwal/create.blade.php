@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Jadwal Pelajaran</h1>
            <p class="text-gray-600">Buat jadwal pelajaran baru</p>
        </div>
        <a href="{{ route('admin.jadwal.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.jadwal.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Hari -->
            <div>
                <label for="hari" class="block text-sm font-medium text-gray-700 mb-2">Hari <span class="text-red-500">*</span></label>
                <select name="hari" id="hari" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('hari') border-red-500 @enderror">
                    <option value="">Pilih Hari</option>
                    @foreach($hari as $h)
                        <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                </select>
                @error('hari')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jam Ke -->
            <div>
                <label for="jam_ke" class="block text-sm font-medium text-gray-700 mb-2">Jam Ke <span class="text-red-500">*</span></label>
                <select name="jam_ke" id="jam_ke" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jam_ke') border-red-500 @enderror">
                    <option value="">Pilih Jam</option>
                    @foreach($jamKe as $jam)
                        <option value="{{ $jam }}" {{ old('jam_ke') == $jam ? 'selected' : '' }}>Jam ke-{{ $jam }}</option>
                    @endforeach
                </select>
                @error('jam_ke')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jam Mulai -->
            <div>
                <label for="jam_mulai" class="block text-sm font-medium text-gray-700 mb-2">Jam Mulai <span class="text-red-500">*</span></label>
                <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai') }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jam_mulai') border-red-500 @enderror">
                @error('jam_mulai')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jam Selesai -->
            <div>
                <label for="jam_selesai" class="block text-sm font-medium text-gray-700 mb-2">Jam Selesai <span class="text-red-500">*</span></label>
                <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai') }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jam_selesai') border-red-500 @enderror">
                @error('jam_selesai')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kurikulum -->
            <div>
                <label for="kurikulum_id" class="block text-sm font-medium text-gray-700 mb-2">Kurikulum <span class="text-red-500">*</span></label>
                <select name="kurikulum_id" id="kurikulum_id" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kurikulum_id') border-red-500 @enderror">
                    <option value="">Pilih Kurikulum</option>
                    @foreach($kurikulums as $kurikulum)
                        <option value="{{ $kurikulum->kurikulum_id }}" {{ old('kurikulum_id') == $kurikulum->kurikulum_id ? 'selected' : '' }}>
                            {{ $kurikulum->nama_kurikulum }}
                        </option>
                    @endforeach
                </select>
                @error('kurikulum_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kelas -->
            <div>
                <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-2">Kelas <span class="text-red-500">*</span></label>
                <select name="kelas_id" id="kelas_id" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kelas_id') border-red-500 @enderror">
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->kelas_id }}" {{ old('kelas_id') == $k->kelas_id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Guru -->
            <div>
                <label for="guru_id" class="block text-sm font-medium text-gray-700 mb-2">Guru <span class="text-red-500">*</span></label>
                <select name="guru_id" id="guru_id" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('guru_id') border-red-500 @enderror">
                    <option value="">Pilih Guru</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->guru_id }}" {{ old('guru_id') == $guru->guru_id ? 'selected' : '' }}>
                            {{ $guru->nama_guru }} - {{ $guru->nip }}
                        </option>
                    @endforeach
                </select>
                @error('guru_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mata Pelajaran -->
            <div>
                <label for="mapel_id" class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran <span class="text-red-500">*</span></label>
                <select name="mapel_id" id="mapel_id" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mapel_id') border-red-500 @enderror">
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->mapel_id }}" {{ old('mapel_id') == $mapel->mapel_id ? 'selected' : '' }}>
                            {{ $mapel->nama_mapel }}
                        </option>
                    @endforeach
                </select>
                @error('mapel_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tahun Ajaran -->
            <div>
                <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran <span class="text-red-500">*</span></label>
                <input type="text" name="tahun_ajaran" id="tahun_ajaran" value="{{ old('tahun_ajaran', date('Y') . '/' . (date('Y') + 1)) }}" required
                       placeholder="2024/2025"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tahun_ajaran') border-red-500 @enderror">
                @error('tahun_ajaran')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                <select name="status" id="status" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                    <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Catatan -->
        <div>
            <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
            <textarea name="catatan" id="catatan" rows="3" 
                      placeholder="Catatan tambahan untuk jadwal ini..."
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('catatan') border-red-500 @enderror">{{ old('catatan') }}</textarea>
            @error('catatan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-3 pt-6 border-t">
            <a href="{{ route('admin.jadwal.index') }}" 
               class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition duration-200">
                Simpan Jadwal
            </button>
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
        
        // Function to update mapel options based on guru and kurikulum
        function updateMapelOptions() {
            const guruId = guruSelect.value;
            const kurikulumId = kurikulumSelect.value;
            
            if (guruId && kurikulumId) {
                fetch(`/admin/jadwal/get-mapels-by-guru?guru_id=${guruId}&kurikulum_id=${kurikulumId}`)
                    .then(response => response.json())
                    .then(data => {
                        mapelSelect.innerHTML = '<option value="">Pilih Mata Pelajaran</option>';
                        data.forEach(mapel => {
                            const option = document.createElement('option');
                            option.value = mapel.mapel_id;
                            option.textContent = mapel.nama_mapel;
                            mapelSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        mapelSelect.innerHTML = '<option value="">Error loading mata pelajaran</option>';
                    });
            } else {
                mapelSelect.innerHTML = '<option value="">Pilih Mata Pelajaran</option>';
            }
        }
        
        // Add event listeners
        guruSelect.addEventListener('change', updateMapelOptions);
        kurikulumSelect.addEventListener('change', updateMapelOptions);
        
        // Auto-fill jam selesai based on jam mulai (add 45 minutes)
        document.getElementById('jam_mulai').addEventListener('change', function() {
            const jamMulai = this.value;
            if (jamMulai) {
                const [hours, minutes] = jamMulai.split(':').map(Number);
                const totalMinutes = hours * 60 + minutes + 45; // Add 45 minutes
                const newHours = Math.floor(totalMinutes / 60);
                const newMinutes = totalMinutes % 60;
                
                const jamSelesai = `${String(newHours).padStart(2, '0')}:${String(newMinutes).padStart(2, '0')}`;
                document.getElementById('jam_selesai').value = jamSelesai;
            }
        });
    });
</script>
@endsection
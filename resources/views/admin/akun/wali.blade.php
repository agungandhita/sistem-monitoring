@extends('admin.layouts.main')

@section('container')
    @include('admin.dashboard._header')

    <div class="px-4 pt-24 bg-slate-200 h-screen max-h-full">
        <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Akun Wali Santri</h1>
                </div>
                <div class="sm:flex">
                    <div
                        class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                        <form class="lg:pr-3" action="/akun-wali" method="GET">
                            <label for="users-search" class="sr-only">Search</label>
                            <div class="relative mt-1 lg:w-64 xl:w-96">
                                <input type="text" name="query" id="users-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Search for users" value="{{ request('query') }}">
                            </div>
                        </form>
                    </div>
                    <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                        <button type="button"
                            class="btn inline-flex items-center justify-center w-1/2 px-3 text-sm font-medium text-center text-white rounded-lg bg-green-700 focus:ring-4 focus:ring-primary-300 sm:w-auto"
                            onclick="modalku.showModal()">
                            Buat akun
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">No</th>
                                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Nama</th>
                                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Telepon</th>
                                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Posisi</th>
                                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Alamat</th>
                                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach ($data as $no => $item)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $no + 1 }}</td>
                                        <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                            <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $item->nama }}</div>
                                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ $item->email }}</div>
                                            </div>
                                        </td>
                                        <td class="max-w-sm p-4 overflow-hidden text-base font-normal text-gray-500 truncate xl:max-w-xs dark:text-gray-400">{{ $item->telepon }}</td>
                                        <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $item->role }}</td>
                                        <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $item->alamat }}</td>
                                        <td class="p-4 space-x-2 whitespace-nowrap">
                                            <button onclick="document.getElementById('modaledit{{ $no }}').showModal()"
                                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-black hover:bg-primary-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 mr-2" fill="currentColor">
                                                    <path d="M21 6.75736L19 8.75736V4H10V9H5V20H19V17.2426L21 15.2426V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5501 3 20.9932V8L9.00319 2H19.9978C20.5513 2 21 2.45531 21 2.9918V6.75736ZM21.7782 8.80761L23.1924 10.2218L15.4142 18L13.9979 17.9979L14 16.5858L21.7782 8.80761Z"></path>
                                                </svg>
                                                Edit Wali
                                            </button>
                                            <button type="button" onclick="document.getElementById('hapus_{{ $no }}').showModal()"
                                                class="inline-flex items-center px-2 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Tambah User --}}
        <dialog id="modalku" class="modal">
            <div class="modal-box bg-white">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <form action="/akun-wali/create" method="POST">
                    @csrf
                    <label class="items-center gap-2 ">
                        <h1 class="font-semibold text-black mb-2 mt-2">Nama</h1>
                        <input type="text" name="nama" class="grow rounded-lg w-full text-black" placeholder="Nafis" />
                    </label>
                    <label class="items-center gap-2 ">
                        <h1 class="font-semibold text-black mb-2 mt-2">Email</h1>
                        <input type="email" name="email" class="grow rounded-lg w-full text-black" placeholder="nafis@gmail.com" />
                    </label>
                    <label class="items-center gap-2 ">
                        <h1 class="font-semibold text-black mb-2 mt-2">Alamat</h1>
                        <input type="text" name="alamat" class="grow rounded-lg w-full text-black" placeholder="Kepohbaru" />
                    </label>
                    <label class="items-center gap-2 ">
                        <h1 class="font-semibold text-black mb-2 mt-2">Telepon</h1>
                        <input type="number" name="telepon" class="grow rounded-lg w-full text-black" placeholder="123456789" />
                    </label>
                    <label class="items-center gap-2 ">
                        <h1 class="font-semibold text-black mb-2 mt-2">Password</h1>
                        <input type="password" name="password" class="grow rounded-lg w-full text-black" placeholder="*****" />
                    </label>
                    <label class="items-center gap-2 ">
                        <h1 class="font-semibold text-black mb-2 mt-2">Sebagai apa?</h1>
                        <select name="role" class="grow rounded-lg w-full text-black">
                            <option value="wali">Wali Santri</option>
                        </select>
                    </label>
                    <div class="mt-3 justify-end items-end">
                        <button class="bg-green-500 text-white px-3 py-2 rounded-lg" type="submit">Buat</button>
                    </div>
                </form>
            </div>
        </dialog>

        {{-- Modal Edit Akun --}}
        @foreach ($data as $update => $edit)
            <dialog id="modaledit{{ $update }}" class="modal">
                <div class="modal-box bg-white">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    </form>
                    <form action="/akun-wali/edit/{{ $edit->user_id }}" method="POST">
                        @csrf
                        <label class="items-center gap-2 ">
                            <h1 class="font-semibold text-black mb-2 mt-2">Nama</h1>
                            <input type="text" name="nama" class="grow rounded-lg w-full text-black" value="{{ $edit->nama }}" />
                        </label>
                        <label class="items-center gap-2 ">
                            <h1 class="font-semibold text-black mb-2 mt-2">Email</h1>
                            <input type="email" name="email" class="grow rounded-lg w-full text-black" placeholder="nafis@gmail.com" value="{{ $edit->email }}" />
                        </label>
                        <label class="items-center gap-2 ">
                            <h1 class="font-semibold text-black mb-2 mt-2">Alamat</h1>
                            <input type="text" name="alamat" class="grow rounded-lg w-full text-black" placeholder="Sakur" value="{{ $edit->alamat }}" />
                        </label>
                        <label class="items-center gap-2 ">
                            <h1 class="font-semibold text-black mb-2 mt-2">Telepon</h1>
                            <input type="number" name="telepon" class="grow rounded-lg w-full text-black" placeholder="123456789" value="{{ $edit->telepon }}" />
                        </label>
                        <div class="mt-3 justify-end items-end">
                            <button class="bg-green-500 text-white px-3 py-2 rounded-lg" type="submit">Edit</button>
                        </div>
                    </form>
                </div>
            </dialog>
        @endforeach

        {{-- Modal Hapus Akun --}}
        @foreach ($data as $no => $item)
            <dialog id="hapus_{{ $no }}" class="modal modal-bottom sm:modal-middle">
                <form action="/akun-wali/delete/{{ $item->user_id }}" method="POST" class="modal-box bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    @csrf
                    <p class="py-4">Apakah kamu yakin mau menghapus data ini?</p>
                    <div class="modal-action">
                        <button type="button" class="btn bg-red-600 hover:bg-red-700 border-none text-white">Tidak</button>
                        <button type="submit" class="btn bg-lime-600 hover:bg-lime-700 border-none text-white">Hapus</button>
                    </div>
                </form>
            </dialog>
        @endforeach
    </div>
@endsection

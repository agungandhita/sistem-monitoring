@extends('admin.layouts.main')

@section('container')
    @include('admin.dashboard._header')

    <div class="px-4 pt-24 bg-slate-200 dark:bg-gray-800 h-screen max-h-full">
        <div
            class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Semua Ustadz</h1>
                </div>
                <div class="sm:flex">
                    <div
                        class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                        <form class="lg:pr-3" action="/user" method="GET">
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
                            class="btn inline-flex items-center justify-center w-1/2 px-3 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto "
                            onclick="modalku.showModal()">
                            Buat akun
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($users as $no => $user)
            <dialog id="coba_{{ $no }}" class="modal">
                <div class="modal-box bg-white">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    </form>
                    <form action="/user/update/{{ $user->id }}" method="POST">
                        @csrf
                        <label class="items-center gap-2 ">
                            <h1 class="font-semibold text-black mb-2 mt-2">Email</h1>
                            <input type="email" value="{{ $user->email }}" name="email"
                                class="grow rounded-lg w-full text-black" placeholder="nafis@gmail.com" />
                        </label>
                        <label class="items-center gap-2 ">
                            <h1 class="font-semibold text-black mb-2 mt-2">Alamat</h1>
                            <input type="text" value="{{ $user->alamat }}" name="alamat"
                                class="grow rounded-lg w-full text-black" placeholder="Woro" />
                        </label>
                        <label class="items-center gap-2 ">
                            <h1 class="font-semibold text-black mb-2 mt-2">Telepon</h1>
                            <input type="number" value="{{ $user->telepon }}" name="telepon"
                                class="grow rounded-lg w-full text-black" placeholder="0822213913" />
                        </label>
                        <div class="mt-3 justify-end items-end">
                            <button class="bg-green-500 text-white px-3 py-2 rounded-lg" type="submit">edit</button>
                        </div>
                    </form>
                </div>
            </dialog>
        @endforeach

        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        No</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Nama</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Telepon</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Posisi</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Alamat</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach ($users as $no => $user)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td
                                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $no + 1 }}</td>
                                        <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                            <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                <div class="text-base font-semibold text-gray-900 dark:text-white">
                                                    {{ $user->nama }}</div>
                                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                    {{ $user->email }}</div>
                                            </div>
                                        </td>
                                        <td
                                            class="max-w-sm p-4 overflow-hidden text-base font-normal text-gray-500 truncate xl:max-w-xs dark:text-gray-400">
                                            {{ $user->telepon }}</td>
                                        <td
                                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Ustadz {{ $user->role }}</td>
                                        <td
                                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $user->alamat }}</td>
                                        <td class="p-4 space-x-2 whitespace-nowrap">
                                            <button onclick="coba_{{ $no }}.showModal()"
                                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                    </path>
                                                    <path fill-rule="evenodd"
                                                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Edit user
                                            </button>
                                            <form class="inline-block" action="/user/delete/{{ $user->user_id }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3-9a1 1 0 10-2 0v3a1 1 0 102 0v-3zm-4 0a1 1 0 10-2 0v3a1 1 0 102 0v-3z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    Delete Ustadz
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($users->isEmpty())
                            <div class="p-4 text-center">
                                <p class="text-gray-500 dark:text-gray-400">No users found</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

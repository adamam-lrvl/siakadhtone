@extends('admin.layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Selamat Datang, {{ auth()->user()->name }}!</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Guru</p>
                    <p class="text-2xl font-bold text-indigo-600">{{ \App\Models\Guru::count() }}</p>
                </div>
                <x-icon name="users" class="w-10 h-10 text-indigo-500" />
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Siswa</p>
                    <p class="text-2xl font-bold text-green-600">{{ \App\Models\Siswa::count() }}</p>
                </div>
                <x-icon name="user-check" class="w-10 h-10 text-green-500" />
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Kelas</p>
                    <p class="text-2xl font-bold text-purple-600">{{ \App\Models\Kelas::count() }}</p>
                </div>
                <x-icon name="school" class="w-10 h-10 text-purple-500" />
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Mapel</p>
                    <p class="text-2xl font-bold text-orange-600">{{ \App\Models\Mapel::count() }}</p>
                </div>
                <x-icon name="book-open" class="w-10 h-10 text-orange-500" />
            </div>
        </div>
    </div>
</div>
@endsection
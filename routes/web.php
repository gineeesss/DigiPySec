<?php

use App\Livewire\Admin\Clients\Create;
use App\Livewire\Admin\Clients\Edit;
use App\Livewire\Admin\Clients\Index;
use App\Livewire\Admin\ServicioForm;
use App\Livewire\Catalogo\ServicioShow;
use App\Livewire\Catalogo\ServiciosIndex;
use App\Livewire\Solicitud\CreateSolicitud;
use App\Livewire\Solicitud\SolicitudList;
use App\Livewire\Solicitud\SolicitudShow;
use Illuminate\Support\Facades\Route;
use Laravel\WithPagination;
use Livewire\Component;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/chat', \App\Livewire\Chat::class)->middleware('auth');  # Opcional: proteger con auth

Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/clients', Index::class)->name('clients.index');
    // Agrega aquí las demás rutas (create, edit, etc.)
});


Route::middleware(['auth'])->group(function () {
    Route::get('/admin/clients', Index::class)->name('clients.index');
    Route::get('/admin/clients/create', Create::class)->name('clients.create');
    Route::get('/admin/clients/{client}/edit', Edit::class)->name('clients.edit');
});

// routes/web.php
Route::get('/servicios', ServiciosIndex::class)->name('servicios.index');
Route::get('/servicios/{servicio:slug}', ServicioShow::class)->name('servicios.show');

// Rutas de administración (protegidas por middleware auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/servicios', ServicioForm::class)->name('admin.servicios.index');
    // Otras rutas administrativas...
});

// routes/web.php
Route::middleware(['auth'])->group(function () {
    // Solicitudes
    Route::get('/solicitudes', SolicitudList::class)->name('solicitudes.index');
    Route::get('/solicitudes/crear', CreateSolicitud::class)->name('solicitudes.create');
    Route::get('/solicitudes/{solicitud}', SolicitudShow::class)->name('solicitudes.show');
});

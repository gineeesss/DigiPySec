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

// Rutas públicas del catálogo
Route::get('/servicios', ServiciosIndex::class)->name('servicios.index');
Route::get('/servicios/{servicio:slug}', ServicioShow::class)->name('servicios.show');

// Rutas de administración (requieren autenticación)
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    // Gestión de clientes
    Route::get('/clientes', Index::class)->name('admin.clients.index');
    Route::get('/clientes/crear', Create::class)->name('admin.clients.create');
    Route::get('/clientes/{client}/editar', Edit::class)->name('admin.clients.edit');

    // Gestión de servicios
    Route::get('/servicios', ServiciosIndex::class)->name('admin.servicios.index');
    Route::get('/servicios/crear', ServicioForm::class)->name('admin.servicios.create');
    Route::get('/servicios/{servicio}/editar', ServicioForm::class)->name('admin.servicios.edit');
    Route::get('/servicios/{servicio}', ServicioShow::class)->name('admin.servicios.show');

    // Gestión de solicitudes
    Route::get('/solicitudes', SolicitudList::class)->name('admin.solicitudes.index');
    Route::get('/solicitudes/crear', CreateSolicitud::class)->name('admin.solicitudes.create');
    Route::get('/solicitudes/{solicitud}', SolicitudShow::class)->name('admin.solicitudes.show');
});

// Chat (opcional)
Route::get('/chat', \App\Livewire\Chat::class)->middleware('auth')->name('chat');

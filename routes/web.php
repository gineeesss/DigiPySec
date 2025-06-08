<?php

use App\Livewire\Admin\Clients\Create;
use App\Livewire\Admin\Clients\Edit;
use App\Livewire\Admin\Clients\Index;
use App\Livewire\Admin\Posts\AdminPostIndex;
use App\Livewire\Admin\Posts\PostForm;
use App\Livewire\Admin\Servicio\ServicioEdit;
use App\Livewire\Admin\Servicio\ServicioForm;
use App\Livewire\Blog\PostIndex;
use App\Livewire\Blog\PostShow;
use App\Livewire\Carrito;
use App\Livewire\Demos\DemosIndex;
use App\Livewire\Demos\Restaurante\Carta;
use App\Livewire\Demos\Tienda\CarritoTienda;
use App\Livewire\Demos\Tienda\CheckoutTienda;
use App\Livewire\Demos\Tienda\GraciasTienda;
use App\Livewire\Demos\Tienda\ProductosTienda;
use App\Livewire\Servicio\ServicioShow;
use App\Livewire\Servicio\ServiciosIndex;
use App\Livewire\Solicitud\CreateSolicitud;
use App\Livewire\Solicitud\SolicitudEdit;
use App\Livewire\Solicitud\SolicitudList;
use App\Livewire\Solicitud\SolicitudShow;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Laravel\WithPagination;


Route::get('/s', function () {
    return view('welcome');
});


Route::get('/', Welcome::class)->name('welcome');

Route::get('/servicios', ServiciosIndex::class)->name('servicios.index');


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
Route::get('/servicios/{servicio:slug}', ServicioShow::class)->name('servicios.show');

// Rutas públicas del blog
Route::get('/blog', PostIndex::class)->name('blog.index');
Route::get('/blog/{post:slug}', PostShow::class)->name('blog.show');


// Rutas de administración (requieren autenticación)
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    // Gestión de clientes
    Route::get('/clientes', Index::class)->name('admin.clients.index');
    Route::get('/clientes/crear', Create::class)->name('admin.clients.create');
    Route::get('/clientes/{client}/editar', Edit::class)->name('admin.clients.edit');

    // Gestión de servicios
    Route::get('/servicios', ServiciosIndex::class)->name('admin.servicios.index');
    Route::get('/servicios/crear', ServicioForm::class)->name('admin.servicios.create');
    Route::get('/servicios/{servicio}/editar', ServicioEdit::class)->name('admin.servicios.edit');
    Route::get('/servicios/{servicio}', ServicioShow::class)->name('admin.servicios.show');

    // Gestión de solicitudes
    Route::get('/solicitudes', SolicitudList::class)->name('admin.solicitudes.index');
    Route::get('/solicitudes/crear', CreateSolicitud::class)->name('admin.solicitudes.create');
    Route::get('/solicitudes/{solicitud}', SolicitudShow::class)->name('admin.solicitudes.show');
    Route::get('solicitudes/{solicitud}/edit', SolicitudEdit::class)->name('admin.solicitudes.edit');


    // Gestión de posts
    Route::get('/posts', AdminPostIndex::class)->name('admin.posts.index');
    Route::get('/posts/create', PostForm::class)->name('admin.posts.create');
    Route::get('/posts/{post}/edit',PostForm::class)->name('admin.posts.edit');
});


Route::get('/solicitudes/{solicitud}', SolicitudShow::class)->name('solicitud.show')->middleware('auth');
Route::get('/solicitudes', SolicitudList::class)->name('solicitud.index')->middleware('auth');

// Chat (opcional)
Route::get('/chat', \App\Livewire\Chat::class)->middleware('auth')->name('chat');



Route::get('/blog/create', function () {
    return redirect()->route('admin.posts.create');
})->middleware('auth');

Route::get('/carrito', Carrito::class)->name('carrito.index');

Route::get('/test-email', function () {
    Mail::raw('Este es un correo de prueba', function ($message) {
        $message->to('ginesnoseque@gmail.com')
            ->subject('Prueba desde Laravel');
    });

    return 'Correo enviado';
});


Route::get('/checkout', \App\Livewire\Checkout::class)->name('checkout')->middleware('auth');



Route::prefix('demos/restaurante')->group(function () {

    Route::middleware(['auth', 'role:restaurante_admin'])->prefix('admin')->group(function () {
    });

});

Route::get('/carta', Carta::class)->name('carta.publica');
Route::middleware(['auth', 'verified'])->prefix('admin')
    ->prefix('demos/restaurante/admin')
    ->group(function () {
        Route::get('/', App\Livewire\Demos\Restaurante\Admin\Dashboard::class)->name('restaurante.admin');
        Route::get('/nuevo', App\Livewire\Demos\Restaurante\Admin\PlatoForm::class)->name('restaurante.admin.nuevo');
        Route::get('/editar/{id}', App\Livewire\Demos\Restaurante\Admin\PlatoForm::class)->name('restaurante.admin.editar');
    });


use App\Livewire\Demos\Barberia\Reservar;
use App\Livewire\Demos\Barberia\Admin\Panel;

Route::prefix('barberia')->group(function() {
    Route::get('/reservar', Reservar::class)->name('barberia.reservar');
    Route::prefix('admin')->group(function() {
        Route::get('/', Panel::class)->name('barberia.admin');
    });
});

use App\Livewire\Demos\Barberia\Admin\Peluqueros;
use App\Livewire\Demos\Barberia\Admin\Citas;
use App\Livewire\Demos\Barberia\Admin\Horarios;

Route::prefix('barberia/admin')->group(function() {
    Route::get('/', Panel::class)->name('barberia.admin');
    Route::get('/peluqueros', Peluqueros::class)->name('barberia.admin.peluqueros');
    Route::get('/citas', Citas::class)->name('barberia.admin.citas');
    Route::get('/horarios', Horarios::class)->name('barberia.admin.horarios');
});

Route::prefix('tienda')->group(function() {
    Route::get('/', \App\Livewire\Demos\Tienda\ProductosTienda::class)->name('tienda.index');
    Route::get('/categoria/{categoriaSlug}', \App\Livewire\Demos\Tienda\ProductosTienda::class)->name('tienda.categoria');
});

Route::get('/gracias/{codigo}', \App\Livewire\Demos\Tienda\GraciasTienda::class)->name('tienda.gracias');

Route::prefix('tienda')->group(function() {
    Route::get('/', \App\Livewire\Demos\Tienda\ProductosTienda::class)->name('tienda.index');
    Route::get('/carrito', \App\Livewire\Demos\Tienda\CarritoTienda::class)->name('tienda.carrito');
    Route::get('/checkout', \App\Livewire\Demos\Tienda\CheckoutTienda::class)->name('tienda.checkout');
});

Route::prefix('demos')->group(function () {
    Route::get('/carta', Carta::class)->name('restaurante.carta.publica');

    Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
        Route::get('/', \App\Livewire\Demos\Restaurante\Admin\Dashboard::class)->name('restaurante.admin');
        Route::get('/nuevo', \App\Livewire\Demos\Restaurante\Admin\PlatoForm::class)->name('restaurante.admin.nuevo');
        Route::get('/editar/{id}', \App\Livewire\Demos\Restaurante\Admin\PlatoForm::class)->name('restaurante.admin.editar');
    });
});

Route::prefix('demos/barberia')->group(function () {
    Route::get('/reservar', Reservar::class)->name('barberia.reservar');

    Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
        Route::get('/', Panel::class)->name('barberia.admin');
        Route::get('/peluqueros', Peluqueros::class)->name('barberia.admin.peluqueros');
        Route::get('/citas', Citas::class)->name('barberia.admin.citas');
        Route::get('/horarios', Horarios::class)->name('barberia.admin.horarios');
    });
});

Route::prefix('demos/tienda')->group(function () {
    Route::get('/', ProductosTienda::class)->name('tienda.index');
    Route::get('/categoria/{categoriaSlug}', ProductosTienda::class)->name('tienda.categoria');
    Route::get('/carrito', CarritoTienda::class)->name('tienda.carrito');
    Route::get('/checkout', CheckoutTienda::class)->name('tienda.checkout');
    Route::get('/gracias/{codigo}', GraciasTienda::class)->name('tienda.gracias');
});


Route::get('/demos', DemosIndex::class)->name('demos.index');

<?php

use App\Livewire\Admin\Clients\Create;
use App\Livewire\Admin\Clients\Edit;
use App\Livewire\Admin\Clients\Index;
use App\Livewire\Admin\Posts\AdminPostIndex;
use App\Livewire\Admin\Posts\PostForm;
use App\Livewire\Admin\Servicio\ServicioForm;
use App\Livewire\Blog\PostIndex;
use App\Livewire\Blog\PostShow;
use App\Livewire\Carrito;
use App\Livewire\Servicio\ServicioShow;
use App\Livewire\Servicio\ServiciosIndex;
use App\Livewire\Solicitud\CreateSolicitud;
use App\Livewire\Solicitud\SolicitudEdit;
use App\Livewire\Solicitud\SolicitudList;
use App\Livewire\Solicitud\SolicitudShow;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Laravel\WithPagination;


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
    Route::get('/servicios/{servicio}/editar', ServicioForm::class)->name('admin.servicios.edit');
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




// routes/web.php

// Carrito

// Checkout

Route::get('/checkout', \App\Livewire\Checkout::class)->name('checkout')->middleware('auth');

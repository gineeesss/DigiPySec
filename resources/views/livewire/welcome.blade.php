{{-- resources/views/components/landing-bootstrap.blade.php --}}
{{-- Asegúrate de tener Bootstrap 5 y Bootstrap-Icons en tu <head> --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"> --}}

<style>
    /* Gradientes reutilizables */
    .hero-gradient     {background:linear-gradient(135deg,#2563eb 0%,#4f46e5 50%,#7c3aed 100%);}
    .cta-gradient      {background:linear-gradient(135deg,#2563eb 0%,#4f46e5 100%);}
    .wave-top svg,
    .wave-bottom svg   {display:block;width:100%;pointer-events:none}
    .wave-top          {position:absolute;top:0;left:0;right:0;transform:translateY(-1px);}
    .wave-bottom       {position:absolute;bottom:0;left:0;right:0;transform:translateY(1px);}
</style>

<div class="bg-white text-body">

    {{-- 1) HERO ---------------------------------------------------- --}}
    <section class="position-relative overflow-hidden py-5 text-center text-white hero-gradient">
        {{-- Onda superior --}}
        <div class="wave-top">
            <svg viewBox="0 0 1440 120"><path fill="currentColor" fill-opacity=".2"
                                              d="M0,96L48,112C96,128,192,160,288,149.3C384,139,480,85,576,90.7C672,96,768,160,864,170.7C960,181,1056,139,1152,112C1248,85,1344,75,1392,69.3L1440,64V0H0Z"/></svg>
        </div>

        <div class="container py-5" style="max-width:900px">
            <h1 class="display-4 fw-bold">¡Digitaliza tu negocio hoy!</h1>
            <p class="lead my-4">
                Automatiza procesos, mejora tu presencia online y conquista nuevos clientes
                con soluciones digitales a tu medida.
            </p>
            <a href="{{ route('checkout') }}" class="btn btn-light btn-lg fw-semibold">
                Solicita tu transformación
                <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>

        {{-- Onda inferior para cerrar la sección --}}
        <div class="wave-bottom">
            <svg viewBox="0 0 1440 120"><path fill="currentColor" fill-opacity=".2"
                                              d="M0,64L48,96C96,128,192,192,288,181.3C384,171,480,85,576,58.7C672,32,768,64,864,96C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96V120H0Z"/></svg>
        </div>
    </section>


    {{-- 2) POR QUÉ DIGITALIZAR ------------------------------------ --}}
    <section class="py-5 bg-light text-center">
        <div class="container" style="max-width:800px">
            <h2 class="h1 fw-bold mb-3">¿Por qué invertir en tu presencia digital?</h2>
            <p class="fs-5 text-muted">
                Una buena web no es un gasto, es una inversión. Mejora tu imagen, llega a más
                público y ofrece servicios 24/7. Tu competencia ya lo está haciendo.
            </p>
        </div>
    </section>


    {{-- 3) SERVICIOS DESTACADOS ----------------------------------- --}}
    @php
        $services = [
            ['title'=>'Página Web Profesional',
             'desc'=>'Desarrollamos tu web rápida, segura y 100% responsive.',
             'icon'=>'globe-alt',
             'grad'=>'linear-gradient(135deg,#60a5fa,#1e40af)'],

            ['title'=>'Tienda Online',
             'desc'=>'Vende tus productos con pasarela de pago integrada.',
             'icon'=>'shopping-cart',
             'grad'=>'linear-gradient(135deg,#6ee7b7,#047857)'],

            ['title'=>'Auditoría de Seguridad',
             'desc'=>'Detectamos y corregimos vulnerabilidades en tu sitio.',
             'icon'=>'shield-check',
             'grad'=>'linear-gradient(135deg,#fda4af,#b91c1c)'],
        ];
    @endphp

    <section class="py-5">
        <div class="container">
            <h2 class="h1 fw-bold text-center mb-5">Servicios destacados</h2>

            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($services as $s)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-lg">
                            <div class="d-flex align-items-center justify-content-center text-white"
                                 style="height:160px;background:{{ $s['grad'] }}">
                                {{-- Heroicon → recuerda cargar blade-heroicons --}}
                                @svg("heroicon-o-{$s['icon']}", 'text-white', ['width'=>'56','height'=>'56'])
                            </div>
                            <div class="card-body text-center">
                                <h3 class="h5 fw-semibold">{{ $s['title'] }}</h3>
                                <p class="text-muted mb-0">{{ $s['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- 4) KIT DIGITAL -------------------------------------------- --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center gy-4">
                <div class="col-lg-6 order-lg-2 text-center">
                    <img src="" class="img-fluid" alt="Kit Digital">
                </div>
                <div class="col-lg-6">
                    <h2 class="h1 fw-bold mb-3">
                        ¿Sabías que puedes financiar tu proyecto?
                    </h2>
                    <p class="fs-5 text-muted">
                        Gracias a subvenciones como el Kit Digital, puedes obtener ayudas para
                        digitalizar tu negocio sin coste inicial.
                    </p>
                    <a href="#contacto" class="btn btn-primary btn-lg">
                        Más información <i class="bi bi-info-circle ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>


    {{-- 5) CTA FINAL ---------------------------------------------- --}}
    <section class="position-relative py-5 text-center text-white cta-gradient">
        <div class="container py-4" style="max-width:820px">
            <h2 class="h1 fw-bold mb-3">¿Listo para empezar?</h2>
            <p class="fs-5 mb-4 opacity-90">
                Haz crecer tu negocio con soluciones tecnológicas profesionales y asequibles.
            </p>
            <a href="{{ route('checkout') }}" class="btn btn-light btn-lg fw-semibold">
                Solicitar Servicio
            </a>
        </div>
    </section>

</div>

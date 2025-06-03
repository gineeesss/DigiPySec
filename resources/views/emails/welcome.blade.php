<x-mail::message>
    # ¡Bienvenido {{ $user->name }}!

    Gracias por registrarte en DigiPySecs.

    Estamos encantados de tenerte con nosotros.
    Si tienes cualquier duda, no dudes en contactar con nosotros.

    <x-mail::button :url="url('/')">
        Ir al sitio
    </x-mail::button>

    Gracias,<br>
    El equipo de DigiPySecs
</x-mail::message>

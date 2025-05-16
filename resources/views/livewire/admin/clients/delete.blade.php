<x-button.circle icon="trash" negative
                 wire:click="delete({{ $client->id }})"
                 wire:confirm="¿Eliminar a {{ $client->name }}?" />

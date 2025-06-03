<div>
    <!-- Filtros -->
    <div class="mb-6 flex flex-col md:flex-row gap-4 items-end">
        <div class="flex-1">
            <x-label for="search" value="Buscar artículos" />
            <x-input
                wire:model.debounce.500ms="search"
                id="search"
                type="text"
                placeholder="Escribe para buscar..."
                class="w-full mt-1"
            />
        </div>

        <div class="flex-1">
            <x-label for="category" value="Filtrar por categoría" />
            <select
                wire:model="category"
                id="category"
                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            >
                <option value="">Todas las categorías</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        @if($search || $category)
            <x-button secondary wire:click="resetFilters" class="ml-2">
                Reiniciar
            </x-button>
        @endif
    </div>

    <!-- Resultados -->
    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        @forelse($posts as $post)
            <livewire:blog.post-card
                :post="$post"
                :wire:key="'post-card-'.$post->id"
            />
        @empty
            <div class="col-span-3 text-center py-12">
                <h3 class="mt-2 text-lg font-medium text-gray-900">No se encontraron artículos</h3>
                @if($search || $category)
                    <x-button secondary wire:click="resetFilters" class="mt-4">
                        Limpiar filtros
                    </x-button>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>

<div>
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />
        <style>
            .trix-content {
                min-height: 300px;
                background: white;
                padding: 1rem;
                border: 1px solid #e5e7eb;
                border-radius: 0.375rem;
            }
            .trix-button-group {
                background: #f9fafb;
                border-radius: 0.375rem;
                overflow: hidden;
            }
            trix-editor {
                min-height: 300px;
            }
        </style>
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-6">
                    {{ $post->exists ? 'Editar Post' : 'Crear Nuevo Post' }}
                </h2>

                @if(session('success'))
                    <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form wire:submit.prevent="save">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Columna izquierda -->
                        <div class="md:col-span-2 space-y-6">
                            <!-- Título -->
                            <div>
                                <x-label for="title" value="Título *" />
                                <x-input
                                    wire:model="post.title"
                                    id="title"
                                    class="w-full mt-1"
                                />
                                @error('post.title')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Extracto -->
                            <div>
                                <x-label for="excerpt" value="Extracto *" />
                                <textarea
                                    wire:model="post.excerpt"
                                    id="excerpt"
                                    rows="3"
                                    class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                ></textarea>
                                @error('post.excerpt')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Editor Trix -->
                            <div wire:ignore>
                                <x-label value="Contenido *" />
                                <input id="content" type="hidden" wire:model="postContent">
                                <trix-editor
                                    input="content"
                                    class="trix-content mt-1 w-full"
                                    x-data
                                    x-init="
                                        this.editor = this;
                                        document.addEventListener('trix-change', function(event) {
                                            @this.set('postContent', event.target.value);
                                        });
                                        // Inicializar con contenido existente
                                        if (@entangle('postContent')) {
                                            this.editor.editor.loadHTML(@entangle('postContent'));
                                        }
                                    "
                                ></trix-editor>
                                @error('postContent')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Columna derecha -->
                        <div class="space-y-6">
                            <!-- Imagen destacada -->
                            <div>
                                <x-label value="Imagen Destacada" />
                                @if($post->featured_image || $featuredImage)
                                    <img
                                        src="{{ $featuredImage ? $featuredImage->temporaryUrl() : asset('storage/'.$post->featured_image) }}"
                                        class="mt-2 mb-4 w-full h-48 object-cover rounded"
                                    >
                                @endif
                                <input
                                    type="file"
                                    wire:model="featuredImage"
                                    class="mt-1 block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-md file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-indigo-50 file:text-indigo-700
                                        hover:file:bg-indigo-100"
                                >
                                @error('featuredImage')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Categoría -->
                            <div>
                                <x-label value="Categoría *" />
                                <select
                                    wire:model="post.category_id"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                >
                                    <option value="">Seleccione...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('post.category_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tags -->
                            <div>
                                <x-label value="Etiquetas" />
                                <div class="mt-2 space-y-2 max-h-48 overflow-y-auto p-2 border rounded">
                                    @foreach($tags as $tag)
                                        <label class="inline-flex items-center">
                                            <input
                                                type="checkbox"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                value="{{ $tag->id }}"
                                                wire:model="tagsSelected"
                                            >
                                            <span class="ml-2">{{ $tag->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Fecha de publicación -->
                            <div>
                                <x-label value="Fecha de Publicación" />
                                <x-input
                                    type="datetime-local"
                                    wire:model="post.published_at"
                                    class="mt-1 block w-full"
                                />
                            </div>

                            <!-- Destacado -->
                            <div class="flex items-center">
                                <input
                                    type="checkbox"
                                    id="is_featured"
                                    wire:model="post.is_featured"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                >
                                <label for="is_featured" class="ml-2">Marcar como destacado</label>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex justify-end mt-8 space-x-4">
                        @if($post->exists)
                            <x-button secondary
                                type="button"
                                wire:click="$set('showDeleteModal', true)"
                                wire:loading.attr="disabled"
                            >
                                Eliminar
                            </x-button>
                        @endif

                        <x-button  type="submit" wire:loading.attr="disabled">
                            <span wire:loading.remove>Guardar Post</span>
                            <span wire:loading>
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Guardando...
                            </span>
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <x-confirmation-modal wire:model="showDeleteModal">
        <x-slot name="title">Eliminar Post</x-slot>
        <x-slot name="content">
            ¿Estás seguro de eliminar este post? Esta acción no se puede deshacer.
        </x-slot>
        <x-slot name="footer">
            <x-button wire:click="$set('showDeleteModal', false)">
                Cancelar
            </x-button>
            <x-button wire:click="delete" class="ml-2">
                Eliminar
            </x-button>
        </x-slot>
    </x-confirmation-modal>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
        <script>
            document.addEventListener('trix-file-accept', function(e) {
                e.preventDefault();
            });

            // Inicialización mejorada para Livewire
            document.addEventListener('livewire:init', () => {
                Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
                    respond((response) => {
                        succeed(({ snapshot, effect }) => {
                            // Recargar Trix después de actualizaciones de Livewire
                            if (component.name === 'admin.posts.post-form') {
                                const editor = document.querySelector('trix-editor');
                                if (editor) {
                                    editor.editor.loadHTML(component.get('postContent'));
                                }
                            }
                        });
                    });
                });
            });
        </script>
    @endpush
</div>

<div
    wire:key="post-card-{{ $post->id }}"
    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 h-full flex flex-col"
>
    @if($post->featured_image)
        <img
            src="{{ Storage::exists($post->featured_image) ? asset('storage/'.$post->featured_image) : $post->featured_image }}"
            alt="{{ $post->title }}"
            class="w-full h-48 object-cover"
            loading="lazy"
        >
    @endif

    <div class="p-6 flex-grow">
        <div class="flex items-center text-sm text-gray-500 mb-2">
            <span>{{ $post->published_at->format('d M Y') }}</span>
            <span class="mx-2">•</span>
            <span>{{ $post->category->name }}</span>
        </div>

        <h3 class="text-xl font-semibold mb-2 line-clamp-2">
            <a
                href="{{ route('blog.show', $post->slug) }}"
                class="hover:text-indigo-600 transition-colors"
                wire:navigate
            >
                {{ $post->title }}
            </a>
        </h3>

        <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>

        @if($post->tags->isNotEmpty())
            <div class="flex flex-wrap gap-2 mt-auto pt-4">
                @foreach($post->tags as $tag)
                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">
                        {{ $tag->name }}
                    </span>
                @endforeach
            </div>
        @endif
    </div>
</div>

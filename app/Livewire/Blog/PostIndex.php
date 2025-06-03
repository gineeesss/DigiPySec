<?php

namespace App\Livewire\Blog;

use App\Models\Category;
use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PostIndex extends Component
{
    use WithPagination;

    #[Url(history: true, keep: true)]
    public string $search = '';

    #[Url(history: true, keep: true)]
    public string $category = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedCategory()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->category = '';
        $this->resetPage();
    }

    #[On('refresh-posts')]
    public function refreshPosts()
    {
        $this->resetPage();
    }

    public function render()
    {
        $posts = Post::query()
            ->with(['category', 'author'])
            ->when($this->search, fn($q) => $q->where('title', 'like', '%'.$this->search.'%'))
            ->when($this->category, fn($q) => $q->where('category_id', $this->category))
            ->published()
            ->latest('published_at')
            ->paginate(6);

        return view('livewire.blog.post-index', [
            'posts' => $posts,
            'categories' => Category::all(),
        ])->layout('layouts.app');
    }
}

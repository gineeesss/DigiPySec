<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Category;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class AdminPostIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $perPage = 6;
    public $readyToLoad = false;

    protected $queryString = [
        'search' => ['except' => '', 'as' => 'q'],
        'category' => ['except' => '', 'as' => 'cat'],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->readyToLoad = true;
    }


    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function loadMore()
    {
        $this->perPage += 6;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->category = '';
        $this->resetPage();
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'category'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.blog.post-index', [
            'posts' => $this->readyToLoad
                ? Post::with(['category', 'author'])
                    ->when($this->search, fn($q) => $q->where('title', 'like', '%'.$this->search.'%'))
                    ->when($this->category, fn($q) => $q->where('category_id', $this->category))
                    ->published()
                    ->latest('published_at')
                    ->paginate($this->perPage)
                : collect(),
            'categories' => Category::all(),
        ])->layout('layouts.app');
    }
}

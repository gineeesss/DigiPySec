<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;

class PostForm extends Component
{
    use WithFileUploads;
    public ?string $postContent = '';

    public Post $post;
    public $tagsSelected = [];
    public $featuredImage;
    public $showDeleteModal = false;

    /*
    #[Rule('required|string')]
    public $postContent = '';

    protected $rules = [
        'post.title' => 'required|string|max:255',
        'post.excerpt' => 'required|string|max:500',
        'post.category_id' => 'required|exists:categories,id',
        'post.published_at' => 'nullable|date',
        'post.is_featured' => 'boolean',
        'featuredImage' => 'nullable|image|max:2048',
        'tagsSelected' => 'array',
    ];

*/
    protected $listeners = ['contentUpdated' => 'updateContent'];

    public function mount(Post $post)
    {
        $this->post = $post ?? new Post();
        $this->tagsSelected = $this->post->tags->pluck('id')->toArray();
        $this->postContent = $this->post->content;
    }

    public function updateContent($value)
    {
        $this->postContent = $value['content'];
    }

    public function save()
    {
        //$this->validate();

        // Asignar contenido antes de guardar
        $this->post->content = $this->postContent;

        if ($this->featuredImage) {
            $this->post->featured_image = $this->featuredImage->store('posts');
        }

        $this->post->slug = Str::slug($this->post->title);
        $this->post->user_id = auth()->id();
        $this->post->save();

        $this->post->tags()->sync($this->tagsSelected);

        session()->flash('success', 'Post '.($this->post->wasRecentlyCreated ? 'creado' : 'actualizado').' correctamente');
        return redirect()->route('admin.posts.index');
    }

    public function delete()
    {
        $this->post->delete();
        session()->flash('success', 'Post eliminado correctamente');
        return redirect()->route('admin.posts.index');
    }

    public function render()
    {
        return view('livewire.admin.posts.form', [
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ])->layout('layouts.app');
    }
}

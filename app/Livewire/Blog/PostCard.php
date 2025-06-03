<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use Livewire\Component;

class PostCard extends Component
{
    public Post $post;
    public bool $showDetails = false;

    public function render()
    {
        return view('livewire.blog.post-card')->layout('layouts.app');
    }

    public function toggleDetails()
    {
        $this->showDetails = !$this->showDetails;
    }
}

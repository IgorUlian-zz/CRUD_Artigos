<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Developer;
use App\Models\User;
use Livewire\Component;

class StatsDashboard extends Component
{
    public $developerCount;
    public $articleCount;
    public $userCount;
    public $developersWithArticleCount;

    public function mount()
    {
        $this->developerCount = Developer::count();
        $this->articleCount = Article::count();
        $this->userCount = User::count();

        $this->developersWithArticleCount = Developer::withCount('articles')->get();
    }

    public function render()
    {
        return view('livewire.stats-dashboard');
    }
}

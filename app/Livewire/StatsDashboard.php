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

    /**
     * O método mount é executado uma vez quando o componente é inicializado.
     * É ideal para buscar dados que não mudam com frequência.
     */
    public function mount()
    {
        $this->developerCount = Developer::count();
        $this->articleCount = Article::count();
        $this->userCount = User::count();

        // Carrega os desenvolvedores e a contagem de seus artigos de forma eficiente
        $this->developersWithArticleCount = Developer::withCount('articles')->get();
    }

    public function render()
    {
        return view('livewire.stats-dashboard');
    }
}

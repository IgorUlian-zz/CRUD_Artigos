<?php

namespace App\Livewire;
use App\Models\Article;
use App\Models\Developer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule; // Importe a classe Rule
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class LivewireMyArticles extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $title, $slug, $article_id;
    public $selectedDevelopers = [];
    public $isOpen = false;
    public $image;
    public $newImage;
    public $html_file;
    public $newHtmlFile;
    public $showForm = false;
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function render()
    {

        $developer = Auth::user()->developer;

        if (!$developer) {
            return view('livewire.article.livewire-my-articles', [
                'articles' => collect([])->paginate(5),
                'allDevelopers' => Developer::with('user')->get()
            ]);
        }

        $query = $developer->articles();
        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        return view('livewire.article.livewire-my-articles', [
            'articles' => $query->latest()->paginate(5),
            'allDevelopers' => Developer::with('user')->get()
        ]);
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

     public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->slug = '';
        $this->article_id = null;
        $this->selectedDevelopers = [];
        $this->image = null;
        $this->newImage = null;
        $this->html_file = null;
        $this->newHtmlFile = null;
    }

    public function store()
    {
        // Geramos o slug novamente antes da validação para garantir que ele sempre exista.
        $this->slug = Str::slug($this->title);

        $this->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('articles')->ignore($this->article_id),
            ],
            'newImage' => $this->article_id ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'newHtmlFile' => $this->article_id ? 'nullable|file|mimes:html,htm' : 'required|file|mimes:html,htm',
        ]);

        $imagePath = $this->image;
        $htmlPath = $this->html_file;

        if ($this->newImage) {
            if ($this->image) Storage::disk('public')->delete($this->image);
            $imagePath = $this->newImage->store('articles/images', 'public');
        }

        if ($this->newHtmlFile) {
            if ($this->html_file) Storage::disk('public')->delete($this->html_file);
            $htmlPath = $this->newHtmlFile->store('articles/html', 'public');
        }

        $article = Article::updateOrCreate(['id' => $this->article_id], [
            'title' => $this->title,
            'slug' => $this->slug,
            'image' => $imagePath,
            'html_file' => $htmlPath,
        ]);

        $article->developers()->sync($this->selectedDevelopers);

        session()->flash('message',
            $this->article_id ? 'Artigo atualizado com sucesso.' : 'Artigo criado com sucesso.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $article = Article::with('developers')->findOrFail($id);

        $this->article_id = $id;
        $this->title = $article->title;
        $this->slug = $article->slug;
        $this->image = $article->image;
        $this->html_file = $article->html_file;

        $this->selectedDevelopers = $article->developers->pluck('id')->toArray();

        $this->openModal();
    }

    public function delete($id)
    {
        $article = Article::findOrFail($id);

        if ($article->image) Storage::disk('public')->delete($article->image);
        if ($article->html_file) Storage::disk('public')->delete($article->html_file);

        $article->delete();
        session()->flash('message', 'Artigo deletado com sucesso.');
    }

}

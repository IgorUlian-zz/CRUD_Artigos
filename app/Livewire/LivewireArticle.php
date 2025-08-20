<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Article;
use App\Models\Developer;
use Illuminate\Support\Facades\Storage;

class LivewireArticle extends Component
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

    public function render()
    {
        return view('livewire.Article.livewire-article', [
            'showForm' => $this->showForm,
            'articles' => Article::with('developers')->paginate(5),
            'allDevelopers' => Developer::all()

        ]);
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
        $this->article_id = '';
        $this->selectedDevelopers = [];

        // Limpa as propriedades dos arquivos
        $this->image = null;
        $this->newImage = null;
        $this->html_file = null;
        $this->newHtmlFile = null;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'slug' => 'required',
            'newImage' => 'nullable|image|max:2048',
            'newHtmlFile' => 'nullable|file|mimes:html,htm|max:1024',
        ]);

        $imagePath = $this->image;
        $htmlPath = $this->html_file;

        if ($this->newImage) {
            if ($this->image) {
                Storage::disk('public')->delete($this->image);
            }
            $imagePath = $this->newImage->store('articles/images', 'public');
        }

        if ($this->newHtmlFile) {
            if ($this->html_file) {
                Storage::disk('public')->delete($this->html_file);
            }
            $htmlPath = $this->newHtmlFile->store('articles/html', 'public');
        }

        $article = Article::updateOrCreate(['id' => $this->article_id], [
            'title' => $this->title,
            'slug' => $this->slug,
            'image' => $imagePath,
            'html_file' => $htmlPath,
        ]);

        $article->developers()->sync($this->selectedDevelopers); // VERIFICAR ERRO

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
        $this->selectedDevelopers = $article->developers->pluck('id')->toArray();
        $this->image = $article->image;
        $this->html_file = $article->html_file;

        $this->openModal();
    }

    public function delete($id)
    {
        $article = Article::find($id);

        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        if ($article->html_file) {
            Storage::disk('public')->delete($article->html_file);
        }

        $article->delete();
        session()->flash('message', 'Artigo deletado com sucesso.');
    }
}

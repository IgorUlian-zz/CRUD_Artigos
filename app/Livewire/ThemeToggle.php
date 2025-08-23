<?php

namespace App\Livewire;

use Livewire\Component;

class ThemeToggle extends Component
{
    public string $theme;

    public function mount()
    {
        // Inicializa o tema com o valor da sessão, ou 'light' como padrão.
        $this->theme = session('theme', 'light');
    }

    public function toggleTheme()
    {
        // Alterna o tema
        $this->theme = $this->theme === 'light' ? 'dark' : 'light';

        // Salva a nova preferência na sessão
        session(['theme' => $this->theme]);

        // Dispara um evento para o navegador para que ele possa atualizar a classe
        $this->dispatch('theme-changed', theme: $this->theme);
    }

    public function render()
    {
        return view('livewire.theme-toggle');
    }
}

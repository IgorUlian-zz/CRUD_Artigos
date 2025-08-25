<?php

namespace App\Livewire;

use Livewire\Component;

class ThemeToggle extends Component
{
    public string $theme;

    public function mount()
    {
        $this->theme = session('theme', 'light');
    }

    public function toggleTheme()
    {
        $this->theme = $this->theme === 'light' ? 'dark' : 'light';
        session(['theme' => $this->theme]);
        $this->dispatch('theme-changed', theme: $this->theme);
    }

    public function render()
    {
        return view('livewire.theme-toggle');
    }
}

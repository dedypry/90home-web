<?php

namespace App\Livewire\Page;

use Livewire\Attributes\Title;
use Livewire\Component;

class About extends Component
{
    #[Title('Tentang Kami')]


    public function render()
    {
        return view('livewire.page.about');
    }
}

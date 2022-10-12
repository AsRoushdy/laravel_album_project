<?php

namespace App\Http\Livewire;

use App\Models\Album;
use Livewire\Component;

class ShowImage extends Component
{
    public $album;

    protected $listeners = ['pictureAdded' => '$refresh'];

    public function mount($album)
    {
        $this->album = $album;
    }

    public function render()
    {
        return view('livewire.show-image');
    }
}

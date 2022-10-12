<?php

namespace App\Http\Livewire;

use App\Models\Album;
use App\Models\Picture;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadImage extends Component
{
    use WithFileUploads;

    public $album_id;
    public $title;
    public $picture;

    public function mount($album_id)
    {
        $this->album_id = $album_id;
    }

    public function store()
    {
        $validatedData = $this->validate([
            'title' => 'required',
            'picture' => 'required|max:1024||mimes:png,jpg',
        ]);

        $album = Album::find($this->album_id);

        $imageName = time().'.'. $this->picture->extension();

        $this->picture->storeAs($album->id,$imageName,'albums');

        Picture::create([
            'album_id' => $this->album_id,
            'name' => $this->title,
            'src' => $imageName
        ]);

        $this->title = '';
        $this->picture = '';

        session()->flash('message', 'Picture Added successfully To Album.');

        $this->emit('pictureAdded', $this->album_id);
    }

    public function render()
    {
        return view('livewire.upload-image');
    }
}

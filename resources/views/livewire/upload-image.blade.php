<div>
<div class="modal-body">

    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif

    <div class="card p-2 m-2">
        <div class="mb-3">
            <label for="title" class="form-label">Picture Name</label>
            <input type="text" wire:model='title' class="form-control" id="title">
            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">Upload Picture</label>
            <input class="form-control" accept=".jpg,.png" type="file" wire:model='picture' id="picture">
            @error('picture') <span class="text-danger">{{ $message }}</span> @enderror

            <div wire:loading wire:target="picture">
                Picture Uploading Please Wait...
            </div>

            @if ($picture)
                <img src="{{ $picture->temporaryUrl() }}" class="img-fluid" alt="...">
            @endif
        </div>
    </div>


</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" wire:click.prevent='store' class="btn btn-primary">Add</button>
</div>
</div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Albums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    @livewireStyles
</head>

<body>

    <div class="container">
        <h1 class="text-center m-5">Albums</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAlbum">
            Create Album
        </button>

        <br>

        @if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session()->has('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
    @endif

        @if ($albums->count() > 0)

        <table class="table table-hover table-responsive text-center">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($albums as $album)
              <tr>
                <th scope="row">{{$album->id}}</th>
                <td>{{$album->title}}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          Manage
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="#"><button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editAlbum-{{$album->id}}">Edit</button></a></li>
                          <li><a class="dropdown-item" href="#"><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAlbum-{{$album->id}}">Delete</button></a></li>
                        <li><a class="dropdown-item" href="#"><button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addPictures-{{$album->id}}">Add Picture</button></a></li>
                        <li><a class="dropdown-item" href="#"><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#showPictures-{{$album->id}}">Show Picture</button></a></li>
                        </ul>
                      </div>

                </td>
              </tr>

              <!-- Edit Modal -->
  <div class="modal fade" id="editAlbum-{{$album->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{route('albums.update',$album->id)}}" method="POST">
            @csrf
            @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Album</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="title" class="form-label">Album Name</label>
                <input type="text" name="title" value="{{$album->title}}" class="form-control" id="title">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </form>
    </div>
  </div>


  <!-- Delete Modal -->
  <div class="modal fade" id="deleteAlbum-{{$album->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{route('albums.destroy',$album->id)}}" method="POST">
            @csrf
            @method('DELETE')
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Album</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="title" class="form-label">Album Name</label>
                <input type="text" disabled name="title" value="{{$album->title}}" class="form-control" id="title">
            </div>

            @if ($album->pictures->count() > 0)
                <h6>This Album Has Pictures You Have Two Choise</h6>

                <div class="form-check">
                    <input class="form-check-input" checked type="radio" name="selected" value="delete_all" id="delete_all-{{$album->id}}">
                    <label class="form-check-label" for="delete_all-{{$album->id}}">
                      Delete All Pictures
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="selected" value="move_all" id="move_all-{{$album->id}}">
                    <label class="form-check-label" for="move_all-{{$album->id}}">
                      Move All Pictures To Another Album
                    </label>
                </div>

                <select name="new_album" class="form-select" aria-label="Default select example">
                    <option selected>Choose Album</option>
                    @foreach ($albums as $newAlbum)
                    @if ($newAlbum->id != $album->id)
                    <option value="{{$newAlbum->id}}">{{$newAlbum->title}}</option>
                    @endif

                    @endforeach
                </select>

            @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>
    </div>
  </div>

  <!-- Add Pictures Modal -->

  <div class="modal fade" id="addPictures-{{$album->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form enctype="multipart/form-data">

      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add Picture To {{$album->title}} Album</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        @livewire('upload-image', ['album_id' => $album->id])

      </div>
    </form>
    </div>
  </div>


  <!-- Show Pictures Modal -->

  <div class="modal fade" id="showPictures-{{$album->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <form enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Show Album {{$album->title}} Pictures</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        @livewire('show-image', ['album' => $album])
      </div>
    </form>
    </div>
  </div>

              @endforeach
            </tbody>
          </table>

          @endif

    </div>


  <!-- Create Modal -->
  <div class="modal fade" id="createAlbum" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{route('albums.store')}}" method="POST">
            @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Create New Album</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="title" class="form-label">Album Name</label>
                <input type="text" name="title" class="form-control" id="title">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@livewireScripts
</body>
</html>

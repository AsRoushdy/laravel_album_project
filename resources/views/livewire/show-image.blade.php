<div>
    <div class="modal-body">

        <div class="card p-2 m-2">

            <div class="row">
                @if ($album->pictures->count() > 0)
                @foreach ($album->pictures as $picture)

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <img src="{{asset('uploads/albums')}}/{{$album->id}}/{{$picture->src}}" class="img-fluid" alt="...">
                </div>

                @endforeach

                @else
                <h6>There is no Pictures in This Album</h6>
                @endif

            </div>

        </div>


    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>

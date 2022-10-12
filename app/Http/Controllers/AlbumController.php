<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Picture;
use File;

class AlbumController extends Controller
{

    public function index()
    {
        $albums = Album::all();
        return view('albums.index',compact('albums'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
        ]);

        Album::create([
            'title' => $request->title
        ]);

        return redirect()->route('albums.index')->with('success','Album Created Successfuly!');
    }


    public function update(Request $request, Album $album)
    {
        $validated = $request->validate([
            'title' => 'required',
        ]);

        $album->update([
            'title' => $request->title
        ]);

        return redirect()->route('albums.index')->with('success','Album Updated Successfuly!');
    }


    public function destroy(Request $request, Album $album)
    {
        if($request->selected == 'move_all' && !empty($request->new_album)){
            foreach($album->pictures as $picture){
                $picture->update([
                    'album_id' => $request->new_album
                ]);

                $sourcePath=(public_path() . '/uploads/albums/' . $album->id . '/' . $picture->src);
                $destinationPath=(public_path() . '/uploads/albums/' . $request->new_album . '/' . $picture->src);

                if (file_exists( $sourcePath)) {
                    if(file_exists($destinationPath)){
                        File::move($sourcePath,$destinationPath);
                    } else {
                        File::makeDirectory(public_path() . '/uploads/albums/' . $request->new_album, 0777 , true , true);
                        File::move($sourcePath,$destinationPath);
                    }
                }
            }
        }

        $album->delete();

        return redirect()->route('albums.index')->with('success','Album Deleted Successfuly!');
    }
}

<?php

namespace App\Http\Controllers\Albums;

use App\Http\Controllers\Controller;
use App\Http\Requests\Albums\StoreAlbumsRequest;
use App\Http\Requests\Albums\UpdateAlbumRequest;
use App\Models\Albums\Album;
use App\Models\Albums\AlbumImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Mockery\Expectation;
use Ramsey\Uuid\Type\Integer;
use App\Trait\ReponseMesssage;

class AlbumController extends Controller
{
  use ReponseMesssage;
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    // return view add
    $albums = Album::with('images')->paginate(10);
    return view('albums.index', ['albums' => $albums]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {

    return view('albums.add');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreAlbumsRequest $request)
  {

    try {

      DB::beginTransaction();
      $ablum = new Album();
      $ablum->name = $request->album_name;
      $ablum->save();

      // store image 

      foreach ($request->file('image') as $index => $img) {
        $imageName = time() . '_' . $img->getClientOriginalName(); // or any custom path you prefer
        $img->move(public_path('albums/images'), $imageName);
        $image = new AlbumImage();
        $image->album_id = $ablum->id;
        $image->image = $imageName;
        $image->name = $request->image_name[$index];
        $image->save();
      }
      DB::commit();
      return $this->response('success', ' Albums Added Succesfully !.');
    } catch (\Exception $e) {
      DB::rollback();
      return $this->response('error', 'Failed to save data. Please try again.');
    }
  }


  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $album = Album::with('images')->find($id);
    if ($album) {
      return view('albums.edit', compact('album'));
    }

    return $this->response('error', 'Failed to get album.');
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateAlbumRequest $request, string $id)
  {

    try {
      $album = Album::findOrFail($id);
      DB::beginTransaction();
      $album->name = $request->album_name;
      $album->save();

      // store image       
      foreach ($request->image_name as $index => $name) { // loop for all image_name image name
        if (isset($request->image_id) && isset($request->image_id[$index])) { // check if already albums image exist 
          $album_image = AlbumImage::findOrFail($request->image_id[$index]); // get albums image and details
          if (isset($request->image) && isset($request->image[$index])) { // if has new image         
            if (File::exists(public_path('albums/images/' . $album_image->image))) { // remove this image 
              File::delete(public_path('albums/images/' . $album_image->image));
            }

            // get new image and add it in albums details
            $imageName = time() . '_' . $request->image[$index]->getClientOriginalName(); // or any custom path you prefer
            $request->image[$index]->move(public_path('albums/images'), $imageName);
            $album_image->image = $imageName;
          } // end if has image
          //dd($album_image , $album->id , $request->image_name[$index] );
          // complete albums details
          $album_image->album_id = $album->id;
          $album_image->name = $request->image_name[$index];
          $album_image->save();
        } else { // if it is new image for albums 
          if (isset($request->image) && isset($request->image[$index])) {
            $imageName = time() . '_' . $request->image[$index]->getClientOriginalName(); // or any custom path you prefer
            $request->image[$index]->move(public_path('albums/images'), $imageName);
          }

          $image = new AlbumImage();
          $image->album_id = $album->id;
          $image->image = isset($imageName) ? $imageName : '';
          $image->name = $request->image_name[$index];
          $image->save();
        }
      }
      DB::commit();
      return $this->response('success', ' Albums Added Succesfully !.');
    } catch (\Exception $e) {
      DB::rollback();
      return $this->response('error', 'Failed to save data. Please try again.');
    }
  }

  

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
    try {
      $album = Album::with('images')->findOrFail($id);
      DB::beginTransaction();
      if ($album->images()->exists()) {
        return redirect()->back()->with('error', 'Must - delete all the pictures in the album
            Or  move the pictures to another album !.');
      }
      DB::commit();
      return $this->response('success', ' Albums Added Succesfully !.');
    } catch (\Exception $e) {
      DB::rollback();
      return $this->response('error', 'Failed to save data. Please try again.');
    }
  }


  public function move($id)
  {
    try {
      $albumDtails = Album::findOrFail($id);
      $albums = Album::get();
      return view('albums.move', compact('albumDtails', 'albums'));
    } catch (\Exception $e) {
      
      return $this->response('error', 'Failed to save data. Please try again.');
    }
  }

  public function move_update(Request $request)
  {
    try {
      $from = Album::with('images')->findOrFail($request->album_from);
      $to = Album::findOrFail($request->album_to);
      DB::beginTransaction();
      foreach ($from->images as $fr) {
        $fr->album_id = $to->id;
        $fr->save();
      }
      DB::commit();
      return $this->response('success', ' Albums Added Succesfully !.');
    } catch (\Exception $e) {
      return $this->response('error', 'Failed to save data. Please try again.');
    }
  }
}

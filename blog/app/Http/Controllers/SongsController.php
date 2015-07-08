<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\CreateSongRequest;
use Illuminate\Http\Request;
use App\Songs;

class SongsController extends Controller {

    private $songs;

    // Mit Songs $songs hole ich alle Songs von der DB | holy shit wie geil :D
    public function __construct(Songs $songs){
        $this->songs = $songs;
    }
    public function index(){
        $allSongs = $this->songs->get();
        return view('songs.index', compact('allSongs'));
    }
    public function show(Songs $song){
        return view('songs.show', compact('song'));
    }
    public function edit(Songs $song){
        return view('songs.edit', compact('song'));
    }

    /**
     * @param $song
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function update(Songs $song, Request $request){
        //dd($request->get('title'));
        //$song->title = $request->get('title');
        $song->fill($request->input())->save();
        return redirect('songs');
    }

    public function create(){
        return view('songs.add');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateSongRequest $request){
        //$song->create($request->all());

        //create new Song
        $song = new Songs();

        //use title for slug
        $songTitle = $request->title;
        $songTitle = str_replace(' ', '-', $songTitle);

        //Fill Song data and save
        $song->slug = $songTitle;
        $song->fill($request->input())->save();
        return redirect()->route('songs_path');
    }

    public function destroy(Songs $song){
        $song->delete();
        return redirect()->route('songs_path');
    }

}

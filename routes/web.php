<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\DummyTable;
use Illuminate\Support\Facades\Input;


Route::get('/', function () {
    $data = DummyTable::paginate(10);
    return view('welcome')->withData($data);
});

Route::any('/search', function(){
  
    $q = Input::get('q');

    if ($q != ''){
        $data = DummyTable::where('name', 'like', '%' .$q. '%')
                          ->orWhere('email', 'like', '%' .$q. '%')
                          ->paginate(10)
                          ->setpath('');

        $data->appends( array('q'=>$q) );

        if ( count($data)>0 ){
          return view('welcome')->withData($data);
        }

        return view('welcome')->withMessage("No results found.");
    }
});

<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::model('cat', 'Cat');

View::composer('cats.edit', function($view)
{
  $breeds = Breed::all();
  if(count($breeds) > 0){
    $breed_options = array_combine($breeds->lists('id'), 
                                    $breeds->lists('name'));
  } else {
    $breed_options = array(null, 'Unspecified');
  }
  $view->with('breed_options', $breed_options);
});

Route::get('/', function()
{
	return Redirect::to('cats');
});

Route::get('about', function()
{
  return View::make('about')->with('number_of_cats', 9000);
});

Route::get('cats', function()
{
  $cats = Cat::all();
  return View::make('cats.index')
    ->with('cats', $cats);
});

Route::get('cats/breeds/{name}', function($name)
{
  $breed - Breed::whereName($name)->with('cats')->first();
  return View::make('cats.index')
    ->with('breed', $breed)
    ->with('cats', $breed->cats);
});

Route::get('cats/create', function() {
  $cat = new Cat;
  return View::make('cats.edit')
    ->with('cat', $cat)
    ->with('method', 'post');
});

Route::post('cats', function()
{
  $cat = Cat::create(Input::all());
  return Redirect::to('cats/' . $cat->id)
    ->with('message', 'Sucessfully created page!');
});


Route::get('cats/{cat}', function(Cat $cat) 
{
  return View::make('cats.single')
    ->with('cat', $cat);
});

Route::get('cats/{cat}/edit', function(Cat $cat) 
{
  return View::make('cats.edit')
    ->with('cat', $cat)
    ->with('method', 'put');
});

Route::get('cats/{cat}/delete', function(Cat $cat)
{
  return View::make('cats.edit')
    ->with('cat', $cat)
    ->with('method', 'delete');
});

Route::put('cats/{cat}', function(Cat $cat)
{
  $cat->update(Input::all());
  return Redirect::to('cats/' . $cat->id)
    ->with('message', 'Succesfully updated page!');
});

Route::delete('cats/{cat}', function(Cat $cat)
{
  $cat->delete();
  return Redirect::to('cats')
    ->with('message', 'Succesfully deleted page!');
});

Route::get('login', function()
{
  return View::make('login');
});

Route::post('login', function()
{
  if(Auth::attempt(Input::only('username', 'password'))) {
    return Redirect::intended('/');
  } else {
    return Redirect::back()
      ->withInput()
      ->with('error', "Invalid credentials");
  }
});

Route::get('logout', function()
{
  Auth::logout();
  return Redirect::to('/')->with('message', 'You are now logged out');
});

Route::group(array('before'=>'auth'), function(){
  Route::get('cats/create', function(){...});
  Route::post('cats', function(){...});
  ...
});
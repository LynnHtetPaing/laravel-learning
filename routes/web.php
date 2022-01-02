<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SessionController;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PostCommentsController;

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

Route::post('newsletter', function() {
    request()->validate(['email' => 'required|email']);

    $mailchimp = new \MailchimpMarketing\ApiClient();

    $mailchimp->setConfig([
        'apiKey' => '7fae5d99f7c9d36c5bfb49078da1114d-us20',
        'server' => 'us20'
    ]);
   try
   {
    $response = $mailchimp->lists->addListMember("c1bedae109", [
        'email_address' => request('email'),
        'status' => 'subscribed'
    ]);
   } catch(\Exception $e)
   {
       throw \Illuminate\Validation\ValidationException::withMessages([
           'email' => 'This email could not be added to our newsletter list '
       ]);
   }
    return redirect('/')->with('success', 'You are now signed up for newsletter!');
});


Route::get('/', [PostController::class,'index'])->name('home');
Route::get('posts/{post:slug}', [PostController::class,'show']);

Route::post('posts/{post:slug}/comments', [PostCommentsController::class,'store']);

Route::get('register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [SessionController::class, 'create'])->middleware('guest');
Route::post('login', [SessionController::class, 'store'])->middleware('guest');

Route::post('logout', [SessionController::class, 'destroy'])->middleware('auth');
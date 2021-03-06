<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Http\Controllers\Controller;
use App\Parents;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class ParentSignupController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Register Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users as well as their
  | validation and creation. By default this controller uses a trait to
  | provide this functionality without requiring any additional code.
  |
  */

  use RegistersUsers;

  /**
   * Where to redirect users after registration.
   *
   * @var string
   */
  protected $redirectTo = '/home';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('guest');
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
      return Validator::make($data, [
          'first_name' => 'required|string|max:255',
          'last_name' => 'required|string|max:255',
          'title' => 'required|string|max:255',
          'role'=>'required|string|in:Teacher,Parent,Leader,Student',
          'email' => 'required|string|email|max:255|unique:users',
          'password' => 'required|string|min:6|confirmed',
      ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\User
   */
  protected function create(array $data)
  {
      $user = User::create([
          'first_name' => $data['first_name'],
          'last_name' => $data['last_name'],
          'title' => $data['title'],
          'role'=>$data['role'],
          'activation_token'=>str_random(36),
          'api_token'=>str_random(36),
          'email' => $data['email'],
          'password' => bcrypt($data['password']),
      ]);

      Parents::create([
        'user_id'=>$user->id
      ]);
      return $user;
  }
}

<?php namespace App\Http\Controllers;


use App\Http\Support\TableLayout;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{


  public function index(User $users)
  {
    $users = $users::all();
    $content = '';


    if($users)
    {
      $table = new TableLayout();
      $headers = collect([
        trans('app.name'),
        trans('app.email'),
        trans('app.post'),
        trans('app.edit'),
      ]);

      $rows = collect();

      foreach ($users as $user) {
          $rows->push([
          $user->name,
          $user->email,
          trans('app.'.$user->role->name),
          link_to(route('userEdit',[$user->id]),trans('app.edit')),
        ]);
      }

      $content = $table->headers($headers)
        ->rows($rows)
        ->render();
    }

    return view('user.list',compact('content'));
  }

  public function edit($user)
  {
    $roles = Role::toSelect();
    return view('user.edit',compact('user','roles'));
  }

  public function update(Request $request,$user)
  {
    //dd($user);
    $this->validate($request, [
      'name' => 'required|max:100',
      'email' => 'required|email|unique:users,email,'.$user->id,
      'role_id' => 'required',
    ]);

    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->role_id = $request->input('role_id');
    $user->update();
    return redirect(route('home'));
  }






}
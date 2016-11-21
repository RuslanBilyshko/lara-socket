<?php namespace App\Http\ViewComposers;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\Request;


class MenuComposer {

  private $user;
  private $guest;
  private $request;

  public function __construct(Auth $auth,Request $request)
  {
    $this->user = $auth::user();
    $this->guest = $auth::guest();
    $this->request = $request;
  }

  /**
   * Compose Menu
   *
   * @param \Illuminate\Contracts\View\View $view
   * @return $this
   */
  public function compose(View $view)
  {
    $menu = collect();

    if($this->guest) {
      $menu->push($this->guestMenu());
    } else {

      switch($this->user->role_id) {
        case ROLE_ADMIN:
          $menu->push($this->adminMenu());
          break;
        case ROLE_WAITER:
          $menu->push($this->waiterMenu());
          break;
        case ROLE_COOK:
          $menu->push($this->cookMenu());
          break;



      }

      $menu->push($this->authMenu($this->user));
    }

    $menu = $menu->collapse();
    $menu = $this->isActive($menu);
    return $view->with('menu',$menu);
  }

  /**
   * Init Guest menu
   *
   * @return array
   */
  private function guestMenu()
  {
    return [
      [
        'link' => route('getLogin'),
        'title' => trans('app.getLogin'),
        'class' => 'primary',
      ],
      [
        'link' => route('getRegister'),
        'title' => trans('app.getRegister'),
        'class' => 'success',
      ]
    ];
  }

  private function waiterMenu()
  {
    return [
      [
        'link' => route('waiter.list'),
        'title' => trans('app.orderList'),
        'class' => 'default',

      ],
      [
        'link' => route('order.create'),
        'title' => trans('app.orderCreate'),
        'class' => 'success create-order',
        'icon' => 'plus',
      ],
    ];
  }

  private function cookMenu()
  {
    return [
      [
        'link' => route('cook.list'),
        'title' => trans('app.orderList'),
        'class' => 'default',

      ],
    ];
  }

  /**
   * Init Menu from Auth User
   *
   * @param $uid
   * @return array
   */
  private function authMenu($user)
  {
    return [
      [
        'link' => route('userEdit',[$user->id]),
        'title' => $user->name." (".trans('app.'.$user->role->name).")",
        'class' => 'default',
        'icon' => 'user',
        'description' => trans('app.userProfile'),
      ],
      [
        'link' => route('logout'),
        'title' => trans('app.logout'),
        'class' => 'default',
        'icon' => 'sign-out',
      ]
    ];
  }

  /**
   * Init admin Menu
   *
   * @return array
   */
  private function adminMenu()
  {
    return[
      [
        'link' => route('userList'),
        'title' => trans('app.userList'),
        'class' => 'default',
        'icon' => 'users',
      ]
    ];
  }


  /**
   * Init active menu
   * add class 'active' in active menu item
   *
   * @param \Illuminate\Support\Collection $menu
   * @return \Illuminate\Support\Collection
   */
  private function isActive(Collection $menu)
  {
    //Добавляем сласс active текущему пункту меню
    $menu->transform(function ($item, $key) {
      if($item['link'] == $this->request->url()) {
        $item['class'] .= ' active';
      }
      return $item;
    });

    return $menu;
  }

}
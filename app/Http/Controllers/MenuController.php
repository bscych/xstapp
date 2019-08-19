<?php

namespace App\Http\Controllers;

use App\Model\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Model\Constant;
use Illuminate\Support\Carbon;

class MenuController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        return View::make('backend.menu.index')->with('menus', Menu::orderBy('created_at', 'desc')->take(7)->get());
    }

    function getMenuByDateMeal($which_day, $meal_id) {
        $menuItems = DB::table('menu_menuitem')
                ->join('menus', 'menus.id', 'menu_menuitem.menu_id')
                ->join('menuitems', 'menuitems.id', 'menu_menuitem.menuItem_id')
                ->select('menuItems.name', 'menus.which_day', 'menus.meal')
                ->where('menus.which_day', '=', $which_day)
                ->where('menus.meal', '=', $meal_id)
                ->get();
        return $menuItems;
    }

    function getMealsByDate($date) {
        $meals = Constant::where('parent_id', 41)->get();
        $diners = collect();
        foreach ($meals as $meal) {
            $menuItems = DB::table('menu_menuitem')
                    ->join('menus', 'menus.id', 'menu_menuitem.menu_id')
                    ->join('menuitems', 'menuitems.id', 'menu_menuitem.menuItem_id')
                    ->select('menuItems.name')
                    ->where('menus.which_day', '=', $date->which_day)
                    ->where('menus.meal', '=', $meal->id)
                    ->get();
            $diners->push($menuItems);
        }

        return $diners;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $menuItems = \App\Model\MenuItem::all();
        return View('backend.menu.create')->with('menuItems', $menuItems);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rules = array(
            'which_day' => 'required|unique:menus',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('menu/create')
                            ->withErrors($validator);
        } else {
            $which_day = Input::get('which_day');
            $morning_snack = Input::get('morning_snack');
            $lunch = Input::get('lunch');
            $afternoon_snack = Input::get('afternoon_snack');
            $dinner = Input::get('dinner');

            $menu = new Menu();
            $menu->which_day = $which_day;
            $menu->morning_snack = json_encode($morning_snack, JSON_UNESCAPED_UNICODE);
            $menu->lunch = json_encode($lunch, JSON_UNESCAPED_UNICODE);
            $menu->afternoon_snack = json_encode($afternoon_snack, JSON_UNESCAPED_UNICODE);
            $menu->dinner = json_encode($dinner, JSON_UNESCAPED_UNICODE);

            $menu->save();
        }
        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu) {
        //
    }

    public function getMenuByDate($date) {
        $menu = Menu::all()->firstWhere('which_day', $date);
        if ($menu != null) {
            $menu->morning_snack = json_decode($menu->morning_snack, JSON_UNESCAPED_UNICODE);
            $menu->afternoon_snack = json_decode($menu->afternoon_snack, JSON_UNESCAPED_UNICODE);
            $menu->lunch = json_decode($menu->lunch, JSON_UNESCAPED_UNICODE);
            $menu->dinner = json_decode($menu->dinner, JSON_UNESCAPED_UNICODE);
            return $menu;
        }
        // return response()->json($menu)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        return null;
    }

    public function getThisweekMenu() {
         $today = Carbon::now();
        $day = $today->dayOfWeekIso;
        $menus = collect();
        for ($i = 1; $i <= 7; $i++) {
            $today = Carbon::now();
            if ($i - $day == 0) {
                $menus->push($this->getMenuByDate($today->toDateString()));
            } else {
                if ($day == 7) {
                    $menus->push($this->getMenuByDate($today->addDay($i - $day + 7)->toDateString()));
                } else {
                    $menus->push($this->getMenuByDate($today->addDay($i - $day)->toDateString()));
                }
            }
        }
        return view('backend.menu.wechatIndex')->with('menus', $menus);
    }

}

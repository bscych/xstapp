<?php

namespace App\Http\Controllers;

use App\Model\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
class MenuItemController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return View::make('backend.menuItem.index')->with('menuItems', MenuItem::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return View::make('backend.menuItem.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rules = array(
            'name' => 'required',
       
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('menuItem/create')
                            ->withErrors($validator);
        } else {

            $menuitem = new MenuItem;
            $menuitem->name = Input::get('name');
            $menuitem->ingredients = Input::get('ingredients');
            $menuitem->recipe = Input::get('recipe');
            $menuitem->is_vegetarian = Input::get('is_vegetarian');
         
            $menuitem->save();
        }
        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function show(MenuItem $menuItem) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuItem $menuItem) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuItem $menuItem) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuItem $menuItem) {
        //
    }

}

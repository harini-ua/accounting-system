<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\DataTables\PersonDataTable;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PersonDataTable $dataTable
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PersonDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Home"],
            ['name' => "People"]
        ];
        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        return $dataTable->render('pages.person.index', compact('pageConfigs', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Person $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        if ($person->delete()) {
            return response()->json(['success'=>true]);
        }
        return response()->json(['success'=>false]);
    }
}

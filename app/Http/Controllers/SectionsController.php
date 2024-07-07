<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sections.sections', ['sections' => sections::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'section_name' => 'required|unique:sections',
            'description' => 'required'
        ], [
            "section_name.unique" => 'القسم مسجل سابقا',
            "section_name.required" => 'برجاء ادخال اسم القسم',
            "description.required" => 'برجاء ادخال اسم الملاحظات',
        ]);
        // check if already exists
        sections::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'Created_by' => (Auth::user()->name)
        ]);
        session()->flash('Add', "تم اضافة القسم بنجاح");
        return redirect('/sections');
    }

    /**
     * Display the specified resource.
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, sections $sections)
    {
        $id = $request->id;
        $this->validate($request, [
            'section_name' => 'required|unique:sections,section_name,' . $id,
            'description' => 'required'
        ], [
            "section_name.unique" => 'القسم مسجل سابقا',
            "section_name.required" => 'برجاء ادخال اسم القسم',
            "description.required" => 'برجاء ادخال اسم الملاحظات',
        ]);
        $section = sections::find($id);
        $section->update([
            'section_name' => $request->section_name,
            'description' => $request->description
        ]);
        session()->flash('edit', "تم تعديل القسم بنجاح");
        return
            redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        sections::find($request->id)->delete();
        session()->flash('delete', "تم حذف القسم بنجاح");
        return
            redirect('/sections');
    }
}

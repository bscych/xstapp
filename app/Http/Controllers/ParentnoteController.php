<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Parentnote;
use Illuminate\Support\Facades\DB;
class ParentnoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parentnotes = DB::table('parentnotes')               
                ->join('students','students.id','parentnotes.student_id') 
                ->join('users','parentnotes.parent_id','users.id')
                ->join('parent_student','parent_student.user_id','parentnotes.parent_id')
                ->where('parentnotes.date',now()->format('Y-m-d'))               
                ->select('parent_student.relationship','students.name','parentnotes.note','parentnotes.created_at')->get();
       return view('backend.parent.note_list',['notes'=>$parentnotes]);
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
        $student_id = $request->input('student_id');
        $note = $request->input('note');     
        $parentnote = new Parentnote;
        $parentnote->student_id = $student_id;
        $parentnote->date = now()->format('Y-m-d');
        $parentnote->note = $note;
        $parentnote->parent_id = auth()->user()->id;
        $parentnote->save();     
        return redirect(route('student.getkidscourse',[$student_id]));
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
       
        $note = Parentnote::find($id);
        $note->note = $request->input('note');
        $note->save();
        $student_id = $request->input('student_id');
        return redirect(route('student.getkidscourse',[$student_id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

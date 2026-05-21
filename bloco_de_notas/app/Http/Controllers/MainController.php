<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Services\Operations;
use App\Models\Note;


class MainController extends Controller
{
    public function index()
    {
        // load user's notes
        $id = session('user.id');
        $notes = User::find($id)
            ->notes()
            ->whereNull('deleted_at')
            ->get()
            ->toArray();

        //show home view
        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {
        // show new note view
        return view('new_note');
    }

    public function newNoteSubmit(Request $request)
    {
        //validate request
        $request->validate(
            //
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'
            ],
            //erro messages
            [
                'text_title.required' => 'O titulo é obrigatorio',
                'text_title.min' => 'O titulo deve ter pelo menos :min caracteres',
                'text_title.max' => 'O titulo deve ter no maximo :max caracteres',
                'text_note.required' => 'A nota é obrigatoria',
                'text_note.min' => 'A nota deve ter pelo menos :min caracteres',
                'text_note.max' => 'A nota deve ter no maximo :max caracteres'
            ]
        );

        // get user id
        $id = session('user.id');

        // create new note
        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        //redirect to home
        return redirect()->route('home');
    }

    public function editNote($id)
    {
        //$id = $this->decryptId($id);
        $id = Operations::decrypt($id);

        //load note
        $note = Note::find($id);

        //show edit note view
        return view('edit_note', ['note' => $note]);
    }

    public function editNoteSubmit(Request $request)
    {
        //validate request
        $request->validate(
            //
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'
            ],
            //erro messages
            [
                'text_title.required' => 'O titulo é obrigatorio',
                'text_title.min' => 'O titulo deve ter pelo menos :min caracteres',
                'text_title.max' => 'O titulo deve ter no maximo :max caracteres',
                'text_note.required' => 'A nota é obrigatoria',
                'text_note.min' => 'A nota deve ter pelo menos :min caracteres',
                'text_note.max' => 'A nota deve ter no maximo :max caracteres'
            ]
        );

        // check if note_id exists
        if ($request->note_id == null) {
            return redirect()->route('home');
        }

        // decrypt note_id
        $id = Operations::decrypt($request->note_id);

        // load note
        $note = Note::find($id);

        // update note
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        //redirect to home
        return redirect()->route('home');
    }


    public function deleteNote($id)
    {
        //$id = $this->decryptId($id);
        $id = Operations::decrypt($id);

        // laod note
        $note = Note::find($id);

        // show delete note confirmation
        return view('delete_note', ['note' => $note]);
    }

    public function deleteNoteConfirm($id)
    {
        //check if $id is encrypted
        $id = Operations::decrypt($id);

        // load note
        $note = Note::find($id);

        // 1. hard delete:remove tudo do banco de dados
        // $note->delete();

        // 2. soft delete: marca o registro como deletado, mas não remove do banco de dados
        //$note->deleted_at = date('Y-m-d H:i:s');
        //$note->save();

        //3. soft delete (property SoftDeletes in model )
        $note->delete();

        //4.hard delete (property SoftDeletes in model )
        //$note->forceDelete();

        //redirect to home
        return redirect()->route('home');
    }
}

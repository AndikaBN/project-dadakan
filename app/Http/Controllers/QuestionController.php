<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function addQuestion(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required',
            'choice_type' => 'required|in:short answer,paragraph,date,multiple choice,dropdown,checkboxes',
            'choices' => 'required_if:choice_type,multiple choice,dropdown,checkboxes',
        ]);

        $form = Form::where('slug', $slug)->firstOrFail();

        if ($form->creator_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden access'], 403);
        }

        $question = $form->questions()->create([
            'name' => $request->name,
            'choice_type' => $request->choice_type,
            'choices' => is_array($request->choices) ? implode(',', $request->choices) : $request->choices,
            'is_required' => $request->is_required,
        ]);

        return response()->json([
            'message' => 'Add question success',
            'question' => $question,
        ], 200);
    }

    public function removeQuestion($slug, $question_id)
    {
        $form = Form::where('slug', $slug)->firstOrFail();
        $question = $form->questions()->where('id', $question_id)->firstOrFail();

        if ($form->creator_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden access'], 403);
        }

        $question->delete();

        return response()->json(['message' => 'Remove question success'], 200);
    }
}

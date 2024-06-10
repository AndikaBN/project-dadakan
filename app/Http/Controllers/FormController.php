<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:forms,slug|regex:/^[a-zA-Z0-9\-\.]+$/',
            'allowed_domains' => 'array',
        ]);

        $form = Form::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'allowed_domains' => $request->allowed_domains,
            'limit_one_response' => $request->limit_one_response,
            'creator_id' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Create form success',
            'form' => $form,
        ], 200);
    }

    public function getAllForms()
    {
        $forms = Form::where('creator_id', Auth::id())->get();

        return response()->json([
            'message' => 'Get all forms success',
            'forms' => $forms,
        ], 200);
    }

    public function getFormDetail($slug)
    {
        $form = Form::where('slug', $slug)->with('questions')->firstOrFail();

        if ($form->creator_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden access'], 403);
        }

        return response()->json([
            'message' => 'Get form success',
            'form' => $form,
        ], 200);
    }
}

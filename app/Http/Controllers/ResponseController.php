<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;

class ResponseController extends Controller
{
    public function submitResponse(Request $request, $slug)
    {
        $form = Form::where('slug', $slug)->firstOrFail();

        if ($form->limit_one_response) {
            $existingResponse = Response::where('form_id', $form->id)
                ->where('user_id', Auth::id())
                ->first();

            if ($existingResponse) {
                return response()->json(['message' => 'User already submitted response'], 403);
            }
        }

        $response = $form->responses()->create([
            'user_id' => Auth::id(),
            'answers' => $request->answers,
        ]);

        return response()->json([
            'message' => 'Submit response success',
            'response' => $response,
        ], 200);
    }

    public function getResponses($slug)
    {
        $form = Form::where('slug', $slug)->firstOrFail();

        if ($form->creator_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden access'], 403);
        }

        $responses = $form->responses()->get();

        return response()->json([
            'message' => 'Get responses success',
            'responses' => $responses,
        ], 200);
    }
}

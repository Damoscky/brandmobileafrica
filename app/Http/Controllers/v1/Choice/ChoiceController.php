<?php

namespace App\Http\Controllers\v1\Choice;

use Validator, DB;
use App\Models\Choice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $credentials = $request->only('question_id', 'description', 'is_correct_choice', 'icon_url');
        $rules = [
            ['question_id' => 'required'],
            ['description' => 'required|min:2'],
        ];

        $validateQuestion = Validator::make($credentials, $rules[0]);
        if ($validateQuestion->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Please select a question',
                'data' => null
            ]);
        }
        $validateDescription = Validator::make($credentials, $rules[1]);
        if ($validateDescription->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Please Enter a description',
                'data' => null
            ]);
        }
        // $question = Question::find($request->question_id);
        // if(!$question){
        //     return response()->json([
        //         'error' => true,
        //         'message' => 'Invalid question ID',
        //         'data' => null
        //     ]);
        // }
        DB::beginTransaction();
        try {
            $choice = Choice::create([
                'question_id' => $request->question_id,
                'description' => $request->description,
                'is_correct_choice' => $request->is_correct_choice,
                'icon_url' => $request->icon_url,
            ]);
            if (!$choice) {
                return response()->json([
                    'error' => true,
                    'message' => 'Error occured, Record was not saved',
                    'data' => null
                ]);
            }
            DB::commit();
            return response()->json([
                'error' => false,
                'message' => 'Choice saved successfully',
                'data' => $choice
            ], 201);
            DB::rollback();
        } catch (\Throwable $error) {
            return response()->json([
                'error' => true,
                'message' => $error->getMessage(),
                'data' => null
            ]);
        }
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
        try {
            $choice = Choice::find($id);
            if(!$choice){
                return response()->json([
                    'error' => true,
                    'message' => 'Record not found',
                    'data' => null
                ]);
            }
            $updateChoice = $choice->update([
                'question_id' => $request->question_id,
                'description' => $request->description,
                'is_correct_choice' => $request->is_correct_choice,
                'icon_url' => $request->icon_url
            ]);
            if(!$updateChoice){
                return response()->json([
                    'error' => true,
                    'message' => 'Record not Updated',
                    'data' => null
                ]);
            }
            return response()->json([
                'error' => false,
                'message' => 'Record updated successfully',
                'data' => $choice
            ]);
        } catch (\Throwable $error) {
            return response()->json([
                'error' => true,
                'message' => $error->getMessage(),
                'data' => null
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $choice = Choice::find($id);
            if(!$choice){
                return response()->json([
                    'error' => true,
                    'message' => 'Question not found',
                    'data' => null
                ]);
            }
            $deleteChoice = $choice->forcedelete();
            return response()->json([
                'error' => false,
                'message' => 'Record deleted successfully',
                'data' => null
            ]);
        } catch (\Throwable $error) {
            return response()->json([
                'error' => true,
                'message' => $error->getMessage(),
                'data' => null
            ]);
        }
    }
}

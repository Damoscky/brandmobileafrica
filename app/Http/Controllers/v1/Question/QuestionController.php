<?php

namespace App\Http\Controllers\v1\Question;

use Validator;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $questions = Question::orderBy('id', 'DESC')->with('choice')->with('category')->get();
            if(!$questions){
                return response()->json([
                    'error' => true,
                    'message' => 'Record not found',
                    'data' => null
                ]);
            }
            return response()->json([
                'error' => false,
                'message' => null,
                'data' => $questions
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
        $credentials = $request->only('category_id', 'question', 'is_general', 'point', 'icon_url', 'duration');
        $rules = [
            ['category_id' => 'required'],
            ['question' => 'required'],
            ['is_general' => 'required'],
            ['point' => 'required']
        ];
        $validateCategory = Validator::make($credentials, $rules[0]);
        if($validateCategory->fails()){
            return response()->json([
                'error' => true,
                'message' => 'Category is Required',
                'data' => null
            ]);
        }
        $validateQuestion = Validator::make($credentials, $rules[1]);
        if($validateQuestion->fails()){
            return response()->json([
                'error' => true,
                'message' => 'Question is Required',
                'data' => null
            ]);
        }
        try {
            $question = Question::create([
                'category_id' => $request->category_id,
                'question' => $request->question,
                'is_general' => $request->is_general,
                'point' => $request->point,
                'icon_url' => $request->icon_url,
                'duration' => $request->duration
            ]);
            if(!$question){
                return response()->json([
                    'error' => true,
                    'message' => 'Question not saved, Error occured',
                    'data' => null
                ]);
            }
            return response()->json([
                'error' => false,
                'message' => 'Question saved successfully!',
                'data' => $question
            ], 201);
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
        try {
            $question = Question::Where('id', $id)->with('category')->with('choice')->first();
            if(!$question){
                return response()->json([
                    'error' => true,
                    'message' => 'Question not found',
                    'data' => null
                ]);
            }
            return response()->json([
                'error' => false,
                'message' => null,
                'data' => $question
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
            $question = Question::find($id);
            if(!$question){
                return response()->json([
                    'error' => true,
                    'message' => 'Record not found',
                    'data' => null
                ]);
            }
            $updateQuestion = $question->update([
                'category_id' => $request->category_id,
                'question' => $request->question,
                'is_general' => $request->is_general,
                'point' => $request->point,
                'icon_url' => $request->icon_url,
                'duration' => $request->duration
            ]);
            if(!$updateQuestion){
                return response()->json([
                    'error' => true,
                    'message' => 'Record not Updated',
                    'data' => null
                ]);
            }
            return response()->json([
                'error' => false,
                'message' => 'Record updated successfully',
                'data' => $question
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
            $question = Question::find($id);
            if(!$question){
                return response()->json([
                    'error' => true,
                    'message' => 'Question not found',
                    'data' => null
                ]);
            }
            $deleteQuestion = $question->forcedelete();
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

    /**
     * Finter Question by Category
     */
    public function filterQuestion($categoryid)
    {
        try {
            $question = Question::Where('category_id', $categoryid)->with('choice')->with('category')->get();
            if(!$question){
                return response()->json([
                    'error' => true,
                    'message' => 'Record not found',
                    'data' => null
                ]);
            }
            return response()->json([
                'error' => false,
                'message' => null,
                'data' => $question
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $error->getMessage(),
                'data' => null
            ]);
        }
    }

    /**
     * Upload CSV
     */
    public function uploadQuestion(Request $request)
    {
        $rules = array(
            'question' => 'required'
        );

        $file = $request->question;
        try {
            Excel::import($file, function ($reader) {
                foreach ($reader->toArray() as $row[]) {
                    foreach($row as $data){
                        return $row['question'];
                        return $data['categories'];
                        $category = Category::where('name', $data['categories'])->first();
                        if (!$category) {
                            return response()->json([
                                'error' => true,
                                'message' => 'Invalid Category',
                                'data' => null
                            ]);
                        }else{
                            Question::firstOrCreate([
                                'question' => $data['question'],
                                'is_general' => $data['is_general'],
                                'category_id' => $category['id'],
                                'point' => $data['point'],
                                'icon_url' => $data['icon_url'],
                            ]);
                            $choice = Choice::firstOrCreate([
                                ''
                            ]);
                        }
                    }

                }
            });
            return response()->json([
                'error' => false,
                'message' => 'Record uploaded successfully',
                'data' => null
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'error' => true,
                'message' => $error->getMessage(),
                'data' => null
            ]);
        }
    }
}

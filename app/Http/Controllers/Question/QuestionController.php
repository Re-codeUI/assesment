<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    public function index(){
        $questions = Question::paginate(5);
        return view('questions.index', compact('questions'));
    }
    public function create() {
        return view('questions.create');
    }
    public function store(Request $request){
         \Log::info('Incoming request data:', $request->all());

        $this->validateRequest($request);

        $allQuestions = [];

        $allQuestions = $this->processQuestions($request->input('questions'));

         if ($this->saveQuestions($request, $allQuestions)) {
            return redirect()->back()->with('success', 'Soal berhasil disimpan!');
            } else {
                return redirect()->back()->with('error', 'Failed to save the questions.');
        }
    }
    public function edit($id){
         $question = Question::findOrFail($id);
         $questionsData = json_decode($question->questions_data, true); // Decode JSON
        //  dd($questionsData);
        // Pastikan setiap item memiliki `question_text` dan `options`
        foreach ($questionsData as &$myquestion) {
            if (!isset($myquestion['question_text'])) {
                $myquestion['question_text'] = ''; // Set default jika tidak ada
            }
            if (!isset($myquestion['options'])) {
                $myquestion['options'] = []; // Set default jika tidak ada
            }
        }

        return view('questions.edit', compact('question', 'questionsData'));
    }
    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        // Encode form data as JSON
        $questionsData = $request->input('questions');
        $question->questions_data = json_encode($questionsData);

        // Save question
        $question->save();

        return redirect()->route('questions')->with('success', 'Questions updated successfully');
    }
    private function validateRequest(Request $request){
        $request->validate([
            'namamapel' => 'required|string|max:255',
            'tahun_ajar' => 'required|string|max:10',
            'class_level' => 'required|integer',
            'jurusan' => 'required|string|max:255',
            'questions.*.question' => 'required|string|max:1000',
            'questions.*.options.*' => 'nullable|string|max:255',
            'questions.*.question_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
        ]);
    }
    private function processQuestions(array $questions){
        $allQuestions = [];

        foreach ($questions as $questionData) {
            $questionEntry = [
                'question' => $questionData['question'] ?? null,
                'options' => $this->getValidOptions($questionData),
                'question_image' => $this->handleImageUpload($questionData),
            ];

            $allQuestions[] = $questionEntry;
        }

        return $allQuestions;
    }
    private function getValidOptions(array $questionData){
        return !empty($questionData['options']) ? $questionData['options'] : [];
    }

    private function handleImageUpload(array $questionData){
        if (isset($questionData['question_image']) && $questionData['question_image']->isValid()) {
            return $questionData['question_image']->store('question_images', 'public');
        }
        return null; // Return null if no valid image is uploaded
    }

    private function saveQuestions(Request $request, array $allQuestions){
        try {
            Question::create([
                'namamapel' => $request->input('namamapel'),
                'class_level' => $request->input('class_level'),
                'jurusan' => $request->input('jurusan'),
                'tahun_ajar' => $request->input('tahun_ajar'),
                'questions_data' => json_encode($allQuestions),
            ]);
            return true;
        } catch (\Exception $e) {
            \Log::error('Database save error:', ['message' => $e->getMessage()]);
            return false; // Return false if an error occurs
        }
    }
}

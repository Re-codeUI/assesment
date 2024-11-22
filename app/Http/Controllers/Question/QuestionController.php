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
        \Log::info('Files:', $request->files->all());


        // Memastikan file ada di dalam request
        if ($request->hasFile('question_image')) {
            \Log::info('File found in question_image input.');
        } else {
            \Log::error('No file found in question_image input.');
        }
    
        $this->validateRequest($request);
    
        $allQuestions = $this->processQuestions($request->input('questions'));
    
        if ($this->saveQuestions($request, $allQuestions)) {
            return redirect()->back()->with('success', 'Soal berhasil disimpan!');
        } else {
            return redirect()->back()->with('error', 'Failed to save the questions.');
        }
    }
    public function edit($id)
    {
        // Ambil data soal berdasarkan ID
        $question = Question::findOrFail($id);
    
        // Dekode JSON questions_data untuk mempermudah manipulasi di view
        $questions = json_decode($question->questions_data, true);
    
        return view('questions.edit', compact('question', 'questions'));
    }
    
    public function update(Request $request, $id){
        // Validasi data
        $this->validateRequest($request);

        $question = Question::findOrFail($id);

        // Proses pertanyaan dan gambar
        $allQuestions = $this->processQuestions($request->input('questions'));

        // Simpan data ke database
        try {
            $question->update([
                'namamapel' => $request->input('namamapel'),
                'tahun_ajar' => $request->input('tahun_ajar'),
                'class_level' => $request->input('class_level'),
                'jurusan' => $request->input('jurusan'),
                'questions_data' => json_encode($allQuestions),
            ]);

            return redirect()->route('questions.index')->with('success', 'Soal berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Update error:', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
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
    private function processQuestions(array $questions) {
        $allQuestions = [];
    
        foreach ($questions as $index => $questionData) {
            $questionEntry = [
                'question' => $questionData['question'] ?? null,
                'options' => $this->getValidOptions($questionData),
                'question_image' => $this->handleImageUpload($questionData, $index), // Kirim indeks ke handleImageUpload
            ];
    
            $allQuestions[] = $questionEntry;
        }
    
        return $allQuestions;
    }
    
    private function getValidOptions(array $questionData){
        return !empty($questionData['options']) ? $questionData['options'] : [];
    }

    private function handleImageUpload(array $questionData, int $index) {
        // Ambil file berdasarkan indeks pertanyaan
        $file = request()->file("questions.{$index}.question_image");
    
        if ($file && $file instanceof \Illuminate\Http\UploadedFile) {
            \Log::info('File details:', [
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'path' => $file->getRealPath(),
                'size' => $file->getSize()
            ]);
    
            if ($file->isValid()) {
                try {
                    // Buat nama file unik
                    $uniqueFileName = uniqid() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('question_images', $uniqueFileName, 'public');
                    \Log::info('Stored file at path: ' . $path);
                    return $path;
                } catch (\Exception $e) {
                    \Log::error('Error uploading image: ' . $e->getMessage());
                    return null;
                }
            } else {
                \Log::error('File is not valid!');
            }
        } else {
            \Log::error("No file found in questions[{$index}][question_image] input.");
        }
    
        return null;
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

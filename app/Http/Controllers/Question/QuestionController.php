<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index(){
        $questions = Question::where('user_id', Auth::user()->id)->paginate(5);
        return view('questions.index', compact('questions'));
    }
    public function create() {
        return view('questions.create', ['context' => 'create']);
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
            flash()->success('Soal berhasil disimpan!');
        } else {
            flash()->error('Failed to save the questions.');
        }
        return redirect()->back();
    }
    public function edit($id)
    {
        $question = Question::findOrFail($id);

        return view('questions.create', [
            'context' => 'edit',
            'question' => $question,
            'existingQuestions' => json_decode($question->questions_data, true), // Decode JSON
        ]);
    }
    
    public function update(Request $request, $id) {
        \Log::info('Files in request:', request()->files->all());
        

        
        // Validasi data
        $this->validateRequest($request);
    
        $question = Question::findOrFail($id);
        // Proses pertanyaan dan gambar
        $allQuestions = collect($request->input('questions'))->map(function ($questionData, $index) {
            $data = [
                'question' => $questionData['question'],
                'options' => $this->getValidOptions($questionData),
            ];
        
            if (request()->hasFile("questions.{$index}.question_image")) {
                // Simpan gambar baru
                $data['question_image'] = $this->handleImageUpload($questionData, $index);
            } else {
                // Gunakan gambar lama jika tidak ada upload baru
                $data['question_image'] = $questionData['existing_image'] ?? null;
            }
        
            return $data;
        });
      
        \Log::info('Updated questions data:', ['questions_data' => $allQuestions]);
    
        try {
            $question->update([
                'user_id' => Auth::id(),
                'namamapel' => $request->input('namamapel'),
                'tahun_ajar' => $request->input('tahun_ajar'),
                'class_level' => $request->input('class_level'),
                'jurusan' => $request->input('jurusan'),
                'questions_data' => json_encode($allQuestions),
            ]);
    
            flash()->success('Soal berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Update error:', ['message' => $e->getMessage()]);
            flash()->error('Terjadi kesalahan saat menyimpan data.');
        }
        return redirect()->route('questions');
    }
     
    function show($id){
        $question = Question::findOrFail($id);
    
        // Dekode JSON questions_data untuk mempermudah manipulasi di view
        $questions = json_decode($question->questions_data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            abort(500, 'Data questions_data tidak valid.');
        }
    
        $letters = range('A', 'Z'); 
        return view('questions.show', compact('question', 'questions','letters'));
    }

public function destroy($id)
{
    try {
        $question = Question::findOrFail($id);
        
        // Ambil data pertanyaan dari JSON
        $questionsData = json_decode($question->questions_data, true);

        if ($questionsData) {
            foreach ($questionsData as $q) {
                if (!empty($q['question_image'])) {
                    $imagePath = 'public/question_images/' . basename($q['question_image']);
        
                    if (Storage::exists($imagePath)) {
                        Storage::delete($imagePath);
                        \Log::info("File berhasil dihapus: " . $imagePath);
                    } else {
                        \Log::error("File tidak ditemukan di storage: " . $imagePath);
                    }
        
                    // Coba metode `unlink()`
                    $filePath = storage_path("app/public/question_images/" . basename($q['question_image']));
                    if (file_exists($filePath)) {
                        unlink($filePath);
                        \Log::info("File berhasil dihapus dengan unlink: " . $filePath);
                    } else {
                        \Log::error("File tidak ditemukan di: " . $filePath);
                    }
                }
            }
        }        

        // Hapus data soal dari database
        $question->delete();

        return redirect()->route('questions')->with('success', 'Soal dan gambarnya berhasil dihapus!');
    } catch (\Exception $e) {
        return redirect()->route('questions')->with('error', 'Terjadi kesalahan saat menghapus soal.');
    }
}

    private function validateRequest(Request $request){
        
        // dd($request);

        $request->validate([
            
            'namamapel' => 'required|string|max:255',
            'tahun_ajar' => 'required|string|max:10',
            'class_level' => 'required|integer',
            'jurusan' => 'required|string|max:255',
            'questions.*.question' => 'required|string|max:2000',
            'questions.*.options.*' => 'nullable|string|max:255',
            'questions.*.question_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'questions.*.question.required' => 'Pertanyaan tidak boleh kosong.',
            'questions.*.question_image.image' => 'File harus berupa gambar.',
        ]);
    }
    
    private function processQuestions(array $questions) {
        return collect($questions)->map(function ($questionData, $index) {
            return [
                'question' => $questionData['question'] ?? null,
                'options' => $this->getValidOptions($questionData),
                'question_image' => $this->handleImageUpload($questionData, $index),
            ];
        })->toArray();
    }

    
    private function getValidOptions(array $questionData){
        return !empty($questionData['options']) ? $questionData['options'] : [];
    }

    private function handleImageUpload(array $questionData, int $index) {
        $fileKey = "questions.{$index}.question_image";
        $file = request()->file($fileKey);
    
        if ($file && $file->isValid()) {
            try {
                // Buat nama file unik
                $uniqueFileName = uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('question_images', $uniqueFileName, 'public');
    
                \Log::info("File berhasil diunggah: {$path}");
                return $path;
            } catch (\Exception $e) {
                \Log::error("Gagal mengunggah file: {$e->getMessage()}");
            }
        } else {
            \Log::warning("Tidak ada file valid di: {$fileKey}");
        }
    
        // Jika tidak ada file baru, kembalikan null
        return null;
    }
    
    
    private function saveQuestions(Request $request, array $allQuestions){
        try {
            Question::create([
                'user_id' => Auth::id(),
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

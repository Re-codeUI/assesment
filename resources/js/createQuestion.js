
let questionCount = 0;
const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
let activeQuestionId = null; // Menyimpan ID soal yang aktif

// Membuat HTML untuk opsi jawaban
function createAnswerOptionHtml(index, optionIndex) {
    const label = alphabet[optionIndex];
    return `
        <div class="mb-3" id="option-${index}-${optionIndex}">
            <label class="form-label">Opsi ${label}</label>
            <input type="text" class="form-control" name="questions[${index}][options][]">
        </div>
    `;
}

// Menambahkan opsi jawaban
function addOption(index) {
    const container = document.getElementById(`options-container-${index}`);
    if (!container) {
        console.error(`Container untuk opsi soal ${index} tidak ditemukan.`);
        return;
    }

    const options = container.querySelectorAll(".form-control");
    const optionIndex = options.length;

    if (optionIndex < alphabet.length) {
        const newOptionHtml = createAnswerOptionHtml(index, optionIndex);
        container.insertAdjacentHTML("beforeend", newOptionHtml); // Tambahkan di akhir kontainer
    } else {
        alert("Jumlah opsi maksimal sudah tercapai!");
    }
}
window.addOption = addOption;
// Membuat HTML untuk soal
function createQuestionHtml(index, question = {}) {
    return `
        <div class="row mt-3 question-item" id="question-${index}">
            <div class="col-md-10">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="math-input-${index}" class="math-field">${question.question || ''}</div>
                            <textarea id="editor-${index}" name="questions[${index}][question]" class="form-control d-none">${question.question || ''}</textarea>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" name="questions[${index}][existing_image]" value="${question.question_image || ''}">
                            <input type="file" name="questions[${index}][question_image]" class="form-control" 
                                onchange="previewImage(event, 'imagePreview_${index}')">
                            <img id="imagePreview_${index}" class="image-upload-preview" alt="Preview Gambar" 
                                style="display: ${question.question_image ? 'block' : 'none'}; max-height: 150px;"
                                src="${question.question_image ? '/storage/' + question.question_image : ''}">
                        </div>
                    </div>
                    <div class="mt-2" id="options-container-${index}">
                        ${(question.options || []).map((option, i) => `
                            <div class="option-item">
                                <input type="text" name="questions[${index}][options][${i}]" value="${option}" class="form-control mt-2">
                            </div>
                        `).join('')}
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" 
                            onclick="addOption(${index})">Tambah Opsi Baru</button>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger w-100" 
                        onclick="removeQuestion(${index})">Hapus Soal</button>
            </div>
        </div>
    `;
}


console.log('createQuestion.js berhasil dimuat');

setTimeout(() => {
    const mathInput = document.getElementById(`math-input-${index}`);
    if (mathInput) {
        mathInput.addEventListener("focus", () => {
            activeQuestionId = index;
            console.log(`Soal aktif diperbarui: ${activeQuestionId}`);
        });
    }
}, 100);

document.addEventListener("DOMContentLoaded", () => {
    console.log("Halaman dimuat");

    const mode = typeof context !== "undefined" ? context : "create";

    if (mode === "edit") {
        console.log("Mode edit aktif");
        console.log("Soal yang ada:", existingQuestions);

        if (Array.isArray(existingQuestions)) {
            existingQuestions.forEach((question, index) => {
                const questionHtml = createQuestionHtml(index, question);
                document.getElementById("questions-container").insertAdjacentHTML("beforeend", questionHtml);

                // 🔹 Setelah menambahkan soal, inisialisasi MathQuill
                setTimeout(() => {
                    initMathField(document.getElementById(`math-input-${index}`), index);
                }, 100);
            });
        }
    } else {
        console.log("Mode create aktif");
    }
});
// Menambahkan soal baru
function addQuestion() {
    console.log('addQuestion dipanggil');
    const container = document.getElementById("questions-container");
    if (!container) {
        console.error("Container untuk soal tidak ditemukan.");
        return;
    }

    const newQuestionHtml = createQuestionHtml(questionCount);
    container.insertAdjacentHTML("beforeend", newQuestionHtml);

    // Pastikan MathQuill terinisialisasi setelah elemen ada di DOM
    const mathFieldElement = document.getElementById(`math-input-${questionCount}`);
    if (mathFieldElement) {
        initMathField(mathFieldElement, questionCount);
    } else {
        console.error(`Elemen math-input-${questionCount} tidak ditemukan.`);
    }

    console.log(`Soal baru dengan ID ${questionCount} berhasil ditambahkan.`);
    questionCount++;
}


function initMathField(mathFieldElement, questionId) {
    const MQ = MathQuill.getInterface(2);
    if (!MQ) {
        console.error("MathQuill tidak dapat diakses.");
        return;
    }

    console.log(`Menginisialisasi MathQuill untuk soal ${questionId}`);

    const mathField = MQ.MathField(mathFieldElement, {
        handlers: {
            edit: function () {
                const textarea = document.getElementById(`editor-${questionId}`);
                if (textarea) {
                    textarea.value = mathField.latex();
                }
            }
        }
    });

    // Jika soal dalam mode edit, isi MathQuill dengan soal yang tersimpan
    const existingLatex = document.getElementById(`editor-${questionId}`).value;
    if (existingLatex) {
        mathField.latex(existingLatex);
    }

    // Simpan instance MathQuill ke elemen agar bisa diakses nanti
    mathFieldElement.mathFieldInstance = mathField;
}



// Pastikan addQuestion tersedia secara global
window.addQuestion = addQuestion;
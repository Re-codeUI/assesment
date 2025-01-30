// removeQuestion.js
// Menghapus soal
function removeQuestion(index) {
    const question = document.getElementById(`question-${index}`);
    if (question) {
        question.remove();
    } else {
        console.error(`Soal dengan ID question-${index} tidak ditemukan.`);
    }
}
window.removeQuestion = removeQuestion;
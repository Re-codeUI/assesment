// toolbar.js
document.addEventListener('DOMContentLoaded', function () {
    let activeQuestionId = null;

    // Fungsi untuk memperbarui ID soal aktif
    document.addEventListener("focusin", (e) => {
        const questionItem = e.target.closest(".question-item");
        if (questionItem) {
            activeQuestionId = questionItem.id.split('-')[1];
        }
    });

    // Menambahkan tombol LaTeX ke toolbar secara dinamis
    const toolbarButtons = [
        { latex: "+", label: "+" },
        { latex: "-", label: "−" },
        { latex: "\\times", label: "×" },
        { latex: "\\div", label: "÷" },
        { latex: "=", label: "=" },
        { latex: "\\neq", label: "≠" },
        { latex: "\\geq", label: "≥" },
        { latex: "\\leq", label: "≤" },
        { latex: "\\sqrt{}", label: "√" },
        { latex: "\\frac{}{}", label: "a/b" },
        { latex: "x^2", label: "x²" },
        { latex: "x^n", label: "xⁿ" },
        { latex: "\\in", label: "∈" },
        { latex: "\\notin", label: "∉" },
        { latex: "\\subset", label: "⊂" },
        { latex: "\\subseteq", label: "⊆" },
        { latex: "\\cup", label: "∪" },
        { latex: "\\cap", label: "∩" },
        { latex: "\\int", label: "∫" },
        { latex: "\\partial", label: "∂" },
        { latex: "\\nabla", label: "∇" },
        { latex: "\\sin", label: "sin" },
        { latex: "\\cos", label: "cos" },
        { latex: "\\tan", label: "tan" },
        { latex: "\\ln", label: "ln" },
        { latex: "e^x", label: "e^x" },
        { latex: "\\alpha", label: "α" },
        { latex: "\\beta", label: "β" },
        { latex: "\\pi", label: "π" },
        { latex: "\\theta", label: "θ" }
    ];

    const toolbarContainer = document.getElementById("toolbar");

    // Menambahkan tombol secara dinamis ke toolbar
    toolbarButtons.forEach(button => {
        const btn = document.createElement("button");
        btn.type = "button";
        btn.classList.add("btn", "btn-secondary");
        btn.textContent = button.label;
        btn.setAttribute("data-latex", button.latex);
        btn.onclick = function () {
            insertLatex(button.latex);
        };
        toolbarContainer.appendChild(btn);
    });

    function insertLatex(latex) {
        if (typeof activeQuestionId === "undefined" || activeQuestionId === null) {
            console.error("activeQuestionId tidak didefinisikan.");
            return;
        }
    
        const mathEditor = document.getElementById(`math-input-${activeQuestionId}`);
        if (!mathEditor) {
            console.error(`Math editor tidak ditemukan untuk soal dengan ID ${activeQuestionId}.`);
            return;
        }
    
        const MQ = MathQuill.getInterface(2);
        const mathField = mathEditor.mathFieldInstance;
        if (!mathField) {
            console.error("MathQuill instance tidak ditemukan.");
            return;
        }
    
        mathField.write(latex);
        mathField.focus();
    
        const textarea = document.getElementById(`editor-${activeQuestionId}`);
        if (textarea) {
            textarea.value = mathField.latex();
            console.log(`Latex berhasil disimpan ke textarea ${activeQuestionId}: ${textarea.value}`);
        } else {
            console.error(`Textarea untuk soal ${activeQuestionId} tidak ditemukan.`);
        }
    }
    
    
    

    // Fungsi untuk menambahkan soal baru
    function addQuestion() {
        const container = document.getElementById("questions-container");
        const newQuestionHtml = createQuestionHtml(activeQuestionId);
        container.insertAdjacentHTML("beforeend", newQuestionHtml);
    }
});
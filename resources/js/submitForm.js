// submitForm.js
document.getElementById('question-form').addEventListener('submit', function () {
    const mathEditors = document.querySelectorAll('.math-editor');
    mathEditors.forEach((editor, index) => {
        const MQ = MathQuill.getInterface(2);
        const mathField = MQ.MathField(editor);
        const textarea = document.getElementById(`editor-${index}`);
        if (textarea) {
            textarea.value = mathField.latex();
        }

        // Perbarui StaticMath
        const staticMathContainer = document.getElementById(`static-math-${index}`);
        if (staticMathContainer) {
            MQ.StaticMath(staticMathContainer).latex(mathField.latex());
        }
    });
});

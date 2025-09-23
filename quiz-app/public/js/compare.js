document.addEventListener('DOMContentLoaded', () => {
    const draftList = document.getElementById('draft-questions');

    // Use only By Category tab checkboxes
    const categoryTab = document.getElementById('by-category');
    const checkboxes = categoryTab.querySelectorAll('input[type=checkbox][id^="quiz_version_questions_"]');

    if (!draftList || checkboxes.length === 0) {
        console.warn("Compare: no draft list or checkboxes found");
        return;
    }

    function updateDraftPreview() {
        draftList.innerHTML = '';

        const selected = [];
        checkboxes.forEach(cb => {
            if (cb.checked) {
                const q = window.quizQuestions.find(item => item.id == cb.value);
                if (q) selected.push(q);
            }
        });

        // Sort alphabetically by text
        selected.sort((a, b) => a.text.localeCompare(b.text));

        selected.forEach(q => {
            const li = document.createElement('li');
            li.dataset.questionId = q.id;

            let html = `<strong>${q.text}</strong>`;
            if (q.options && Object.keys(q.options).length > 0) {
                html += '<ul>';
                for (const [key, val] of Object.entries(q.options)) {
                    html += `<li>${key}: ${val}</li>`;
                }
                html += '</ul>';
            } else {
                html += '<em>No options</em>';
            }

            html += `<div class="text-muted small">Category: ${q.category || 'Uncategorized'}</div>`;
            if (q.tags && q.tags.length > 0) {
                html += `<div class="text-muted small">Tags: ${q.tags.join(', ')}</div>`;
            }

            li.innerHTML = html;
            draftList.appendChild(li);
        });
    }


    updateDraftPreview();
    checkboxes.forEach(cb => cb.addEventListener('change', updateDraftPreview));

    const modal = document.getElementById('compareModal');
    if (modal) {
        modal.addEventListener('show.bs.modal', updateDraftPreview);
    }
});

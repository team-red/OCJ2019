window.addEventListener('load', () => {
    duration_ms = parseInt(document.getElementById('quiz-duration').innerHTML) * 1000;
    duration_ms += 5 * 1000; // 5 seconds for leniency
    setTimeout(() => {
        button = document.getElementById('submit-form');
        button.click();
    }, duration_ms);
});

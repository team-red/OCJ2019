window.addEventListener('load', () => {
    duration_s = parseInt(document.getElementById('quiz-duration-send').innerHTML)
    duration_ms = duration_s * 1000;
    function timer(){
    	document.getElementById('timer').innerHTML = (duration_s--).toString() + " secondes restantes";
    	if (duration_s >= 0){
    		setTimeout(timer, 1000)
    	}
    }
    setTimeout(() => {
        button = document.getElementById('submit-form');
        button.click();
    }, duration_ms + 5 * 1000);
    timer()
});

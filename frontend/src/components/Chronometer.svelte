<script>
    let milliSeconds = 0;
    let timeout;
    let btn;
  
  
    const startTimer = () => {
      btn.disabled = true;
      timeout = setTimeout(() => {
        milliSeconds += 100;
        startTimer(); 
      }, 100);
  
      
    };
  
    const stopTimer = () => {
      clearTimeout(timeout);
      btn.disabled = false;
    };
  
    const resetTimer = () => {
      clearTimeout(timeout);
      milliSeconds = 0;
      btn.disabled = false;
    };
  
    const formatTime = (totalMilliSeconds) => {
      const totalSeconds = Math.floor(totalMilliSeconds / 1000);
      const minutes = Math.floor((totalSeconds % 3600) / 60);
      const seconds = Math.floor(totalSeconds % 60);
      const formattedMilliseconds = Math.floor((totalMilliSeconds % 1000) / 100);
  
    
      return `${minutes} : ${seconds} : ${formattedMilliseconds} `;
    };
  
  </script>
  
  <h2>Chronométrez votre exercice</h2>
  
  <div class="wrapper">
    <i class="fa-solid fa-clock fa-beat-fade"></i>
    <div id="chrono">{formatTime(milliSeconds)}
    </div>

        <div id="buttons">
            <div class="btn-block">
                <button bind:this={btn} on:click={startTimer} id="start" class="button" aria-label="Démarrer le chronomètre">Démarrer</button>
  
                <button on:click={stopTimer} id="stop" class="button" aria-label="Mettre en pause le chronomètre">Pause</button>
  
                <button on:click={resetTimer} id="reset" class="button" aria-label="Arrêter le chronomètre">reset</button>
            </div>
        </div>
    </div>

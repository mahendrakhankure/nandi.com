const canvas = document.getElementById("kingBazarWheelCanvas");
      const ctx = canvas.getContext("2d");
      let imgLoded = 0;
      const arr = [
                {"resultText": "1", "cardUnicode":"♠"},
                {"resultText": "6", "cardUnicode":"♥"},
                {"resultText": "7", "cardUnicode":"♦"},
                {"resultText": "2", "cardUnicode":"♣"},
                {"resultText": "4", "cardUnicode":"♠"},
                {"resultText": "3", "cardUnicode":"♥"},
                {"resultText": "9", "cardUnicode":"♦"},
                {"resultText": "5", "cardUnicode":"♣"},
                {"resultText": "0", "cardUnicode":"♠"},
                {"resultText": "2", "cardUnicode":"♥"},
                {"resultText": "8", "cardUnicode":"♦"},
                {"resultText": "6", "cardUnicode":"♣"},
                {"resultText": "5", "cardUnicode":"♠"},
                {"resultText": "8", "cardUnicode":"♥"},
                {"resultText": "3", "cardUnicode":"♦"},
                {"resultText": "7", "cardUnicode":"♣"},
                {"resultText": "2", "cardUnicode":"♠"},
                {"resultText": "4", "cardUnicode":"♥"},
                {"resultText": "6", "cardUnicode":"♦"},
                {"resultText": "9", "cardUnicode":"♣"},
                {"resultText": "1", "cardUnicode":"♠"},
                {"resultText": "0", "cardUnicode":"♥"},
                {"resultText": "4", "cardUnicode":"♦"},
                {"resultText": "8", "cardUnicode":"♣"},
                {"resultText": "7", "cardUnicode":"♠"},
                {"resultText": "3", "cardUnicode":"♥"},
                {"resultText": "0", "cardUnicode":"♦"},
                {"resultText": "5", "cardUnicode":"♣"},
                {"resultText": "9", "cardUnicode":"♠"},
                {"resultText": "1", "cardUnicode":"♥"},
                {"resultText": "5", "cardUnicode":"♦"},
                {"resultText": "7", "cardUnicode":"♣"},
                {"resultText": "8", "cardUnicode":"♠"},
                {"resultText": "0", "cardUnicode":"♥"},
                {"resultText": "2", "cardUnicode":"♦"},
                {"resultText": "1", "cardUnicode":"♣"},
                {"resultText": "6", "cardUnicode":"♠"},
                {"resultText": "9", "cardUnicode":"♥"},
                {"resultText": "3", "cardUnicode":"♦"},
                {"resultText": "4", "cardUnicode":"♣"}
            ]; // Your array remains unchanged
    

      const center = { x: 0, y: 0 };
      let angle = 0;
      const sectorAngle = (2 * Math.PI) / arr.length;
      let spinning = false;

      function resizeCanvasKingBazarWheel() {
        const size = document.getElementById("wheelContainer1").offsetWidth;
        canvas.width = size;
        canvas.height = size;
        center.x = size / 2;
        center.y = size / 2;
        drawWheelKingBazarWheel();
      }

      function drawWheelKingBazarWheel() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  // Outer Wheel
  for (let i = 0; i < arr.length; i++) {
    const start = angle + i * sectorAngle;
    const end = start + sectorAngle;

    ctx.beginPath();
    ctx.moveTo(center.x, center.y);
    ctx.arc(center.x, center.y, canvas.width / 2.05, start, end);

    const gradient = ctx.createRadialGradient(center.x, center.y, 0, center.x, center.y, canvas.width / 2);
    if (i % 2 != 0) {
      gradient.addColorStop(0, '#ce0f00');
      gradient.addColorStop(0.5, '#c40d00');
      gradient.addColorStop(1, '#b31000');
    } else {
      gradient.addColorStop(0, '#d2c78f');
      gradient.addColorStop(0.5, '#f5e494');
      gradient.addColorStop(1, '#d0a942');
    }

    ctx.fillStyle = gradient;
    ctx.fill();

    // Outer Text
    ctx.save();
    ctx.translate(center.x, center.y);
    const textAngle = start + sectorAngle / 2;
    ctx.rotate(textAngle);
    
    ctx.textAlign = "center";
    ctx.textBaseline = "middle";
    ctx.lineWidth = -1;
    const outerRadius = canvas.width / 2.5;
    ctx.translate(outerRadius, 0);
    ctx.rotate(Math.PI / 2);

    const innerGradient = ctx.createRadialGradient(center.x, center.y, 0, center.x, center.y, canvas.width / 4);
    if (i % 2 === 0) {
        innerGradient.addColorStop(0, '#e04435');
        innerGradient.addColorStop(1, '#990e03');
    } else {
        innerGradient.addColorStop(0, '#f7de7a');
        innerGradient.addColorStop(1, '#ca9e35');
    }
    ctx.fillStyle = innerGradient;

    const baseFontSize = canvas.width / 12;
    ctx.font = `bold ${Math.floor(canvas.width / 12)}px Arial`;
    
    // ctx.strokeText(arr[i].cardUnicode, 0, -20);
    ctx.fillText(arr[i].cardUnicode, 0, -baseFontSize / 3); // bottom text (symbol) – you can customize this per index
    ctx.font = `bold ${Math.floor(canvas.width / 17)}px Arial`;
    
    // ctx.strokeText(arr[i].resultText, 0, 20);
    ctx.fillText(arr[i].resultText, 0, baseFontSize / 1.4);
    ctx.restore();
  }
}


    async function startSpinKingBazarWheel(win) {
        const winningIndex = await getNumber(win);
        if (spinning) return;
        spinning = true;

        const duration = 12000;
        const initialAngle = angle;
        const targetSectorAngle = (winningIndex + 0.5) * sectorAngle;
        const finalTarget = (3 * Math.PI / 2 - targetSectorAngle + 2 * Math.PI) % (2 * Math.PI);
        const fullRotations = 6 * 2 * Math.PI;
        const totalAngle = fullRotations + finalTarget;

        let startTime;

        function animateSpinKingBazarWheel(time) {
          if (!startTime) startTime = time;
          const elapsed = time - startTime;
          const progress = Math.min(elapsed / duration, 1);
          const eased = 1 - Math.pow(1 - progress, 6); // easeOutCubic

          angle = initialAngle + (totalAngle - initialAngle) * eased;
          drawWheelKingBazarWheel();

          if (progress < 1) {
            requestAnimationFrame(animateSpinKingBazarWheel);
          } else {
            spinning = false;
            angle %= 2 * Math.PI;
            console.log("Landed on:", arr[winningIndex].resultText);
          }
        }

        requestAnimationFrame(animateSpinKingBazarWheel);
      }

      $("#startWheel1").click(function () {
        const randomIndex = Math.floor(Math.random() * arr.length);

        startSpinKingBazarWheel(randomIndex);
      });

      $(window).on("resize", resizeCanvasKingBazarWheel);
      resizeCanvasKingBazarWheel();
   
    async function getNumber(akda){
        const arr = {
            '0':[8,21,26,33],
            '1':[0,20,29,35],
            '2':[3,9,16,34],
            '3':[5,14,25,38],
            '4':[4,17,22,39],
            '5':[7,12,27,30],
            '6':[1,11,18,36],
            '7':[2,15,24,31],
            '8':[10,13,23,32],
            '9':[6,28,37,19]
        };
        return arr[akda][Math.floor(Math.random() * 4)];
    }
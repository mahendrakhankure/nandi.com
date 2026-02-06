
      const canvas = document.getElementById("wheelCanvas1");
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

    function resizeCanvasRedAndBlack() {
        const size = document.getElementById("wheelContainer1").offsetWidth;
        canvas.width = size;
        canvas.height = size;
        center.x = size / 2;
        center.y = size / 2;
        drawWheelRedAndBlack();
    }

    function drawWheelRedAndBlack() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        for (let i = 0; i < arr.length; i++) {
            const start = angle + i * sectorAngle;
            const end = start + sectorAngle;
            ctx.beginPath();
            ctx.moveTo(center.x, center.y);
            ctx.arc(center.x, center.y, canvas.width / 2.05, start, end);

            const gradient = ctx.createRadialGradient(center.x, center.y, 0, center.x, center.y, canvas.width / 2);
            if (i % 2 != 0) {
            gradient.addColorStop(0, '#0e6dd9');
            gradient.addColorStop(1, '#050016');
            } else {
            gradient.addColorStop(0, '#ffdb8f');
            gradient.addColorStop(1, '#e3a102');
            }

            ctx.fillStyle = gradient;
            ctx.fill();

            const gradientRedial = ctx.createRadialGradient(center.x, center.y, 0, center.x, center.y, canvas.width / 2);
            gradientRedial.addColorStop(0, '#ec9f00');
            gradientRedial.addColorStop(0.7, '#fff');
            gradientRedial.addColorStop(1, '#ffdb8f');
            ctx.strokeStyle = gradientRedial;

            ctx.lineWidth = 3;
            ctx.stroke();
            
            // Draw vertical text
            ctx.save();
            ctx.translate(center.x, center.y);
            const textAngle = start + sectorAngle / 2;
            ctx.rotate(textAngle);
            
            ctx.strokeStyle = 'blue'//"#0076c4";      // Color of the outline
            
            ctx.fillStyle = "#fff";
            ctx.textAlign = "center";
            ctx.textBaseline = "middle";

            const radius = canvas.width / 2.7; // distance from center to text
            ctx.translate(radius, 0); // move out from center
            ctx.rotate(Math.PI / 2);  // rotate to make text vertical upright
            ctx.font = `bold ${Math.floor(canvas.width / 14)}px Arial`;
            ctx.strokeText(arr[i].cardUnicode, 0, -20);
            ctx.fillText(arr[i].cardUnicode, 0, -20); // bottom text (symbol) – you can customize this per index
            ctx.font = `bold ${Math.floor(canvas.width / 20)}px Arial`;
            ctx.strokeText(arr[i].resultText, 0, 20);
            ctx.fillText(arr[i].resultText, 0, 20);
            ctx.restore();
        }
    }


      async function startSpinTheWheel(win) {
        const winningIndex = await getNumber(win);
        if (spinning) return;
        spinning = true;

        const duration = 10000;
        const initialAngle = angle;
        const targetSectorAngle = (winningIndex + 0.5) * sectorAngle;
        const finalTarget = (3 * Math.PI / 2 - targetSectorAngle + 2 * Math.PI) % (2 * Math.PI);
        const fullRotations = 6 * 2 * Math.PI;
        const totalAngle = fullRotations + finalTarget;

        let startTime;

        function animateSpinRedAndBlack(time) {
          if (!startTime) startTime = time;
          const elapsed = time - startTime;
          const progress = Math.min(elapsed / duration, 1);
          const eased = 1 - Math.pow(1 - progress, 6); // easeOutCubic

          angle = initialAngle + (totalAngle - initialAngle) * eased;
          drawWheelRedAndBlack();

          if (progress < 1) {
            requestAnimationFrame(animateSpinRedAndBlack);
          } else {
            spinning = false;
            angle %= 2 * Math.PI;
            console.log("Landed on:", arr[winningIndex].resultText);
          }
        }

        requestAnimationFrame(animateSpinRedAndBlack);
      }

      $("#startWheel1").click(function () {
        // const randomIndex = Math.floor(Math.random() * arr.length);
        // startSpinTheWheel(0);
      });

      $(window).on("resize", resizeCanvasRedAndBlack);
      resizeCanvasRedAndBlack();

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

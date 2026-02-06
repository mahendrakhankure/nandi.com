$(document).ready(function () {
    console.log('am inside of crazy matka')
    const canvas = document.getElementById("wheelCanvas1");
    const ctx = canvas.getContext("2d");

    const arr = [
              {"color1":"#da217e", "type": "string", "value": "1", "color2":"#90144e", "resultText": "200X"},
              {"color1":"#6e4d76", "type": "string", "value": "2", "color2":"#533a58", "resultText": "25X"},
              {"color1":"#533a58", "type": "string", "value": "3", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#212529", "type": "string", "value": "4", "color2":"#2368b0", "resultText": "10X"}, 
              {"color1":"#eeb83b", "type": "string", "value": "5", "color2":"#dd7925", "resultText": "50X"},
              {"color1":"#6e4d76", "type": "string", "value": "6", "color2":"#533a58", "resultText": "25X"},
              {"color1":"#533a58", "type": "string", "value": "7", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#533a58", "type": "string", "value": "8", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#533a58", "type": "string", "value": "9", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#6e4d76", "type": "string", "value": "10", "color2":"#533a58", "resultText": "25X"},
              {"color1":"#d3bd3b", "type": "string", "value": "11", "color2":"#8ba525", "resultText": "100X"},
              {"color1":"#533a58", "type": "string", "value": "12", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#533a58", "type": "string", "value": "13", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#6e4d76", "type": "string", "value": "14", "color2":"#533a58", "resultText": "25X"},
              {"color1":"#533a58", "type": "string", "value": "15", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#533a58", "type": "string", "value": "16", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#eeb83b", "type": "string", "value": "17", "color2":"#dd7925", "resultText": "50X"},
              {"color1":"#6e4d76", "type": "string", "value": "18", "color2":"#533a58", "resultText": "25X"},
              {"color1":"#533a58", "type": "string", "value": "19", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#533a58", "type": "string", "value": "20", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#533a58", "type": "string", "value": "21", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#eeb83b", "type": "string", "value": "22", "color2":"#dd7925", "resultText": "50X"},
              {"color1":"#6e4d76", "type": "string", "value": "23", "color2":"#533a58", "resultText": "25X"},
              {"color1":"#533a58", "type": "string", "value": "24", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#6e4d76", "type": "string", "value": "13", "color2":"#533a58", "resultText": "25X"},
              {"color1":"#533a58", "type": "string", "value": "14", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#533a58", "type": "string", "value": "15", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#eeb83b", "type": "string", "value": "16", "color2":"#dd7925", "resultText": "50X"},
              {"color1":"#6e4d76", "type": "string", "value": "17", "color2":"#533a58", "resultText": "25X"},
              {"color1":"#533a58", "type": "string", "value": "18", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#533a58", "type": "string", "value": "19", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#533a58", "type": "string", "value": "20", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#eeb83b", "type": "string", "value": "21", "color2":"#dd7925", "resultText": "50X"},
              {"color1":"#6e4d76", "type": "string", "value": "22", "color2":"#533a58", "resultText": "25X"},
              {"color1":"#533a58", "type": "string", "value": "23", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#533a58", "type": "string", "value": "25", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#d3bd3b", "type": "string", "value": "26", "color2":"#8ba525", "resultText": "100X"},
              {"color1":"#6e4d76", "type": "string", "value": "27", "color2":"#533a58", "resultText": "25X"},
              {"color1":"#533a58", "type": "string", "value": "28", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#533a58", "type": "string", "value": "29", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#eeb83b", "type": "string", "value": "30", "color2":"#dd7925", "resultText": "50X"},
              {"color1":"#6e4d76", "type": "string", "value": "31", "color2":"#533a58", "resultText": "25X"},
              {"color1":"#533a58", "type": "string", "value": "32", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#533a58", "type": "string", "value": "33", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#eeb83b", "type": "string", "value": "34", "color2":"#dd7925", "resultText": "50X"},
              {"color1":"#6e4d76", "type": "string", "value": "35", "color2":"#533a58", "resultText": "25X"},
              {"color1":"#533a58", "type": "string", "value": "36", "color2":"#2368b0", "resultText": "10X"},
              {"color1":"#533a58", "type": "string", "value": "37", "color2":"#2368b0", "resultText": "10X"}
          ]; // Your array remains unchanged
  

    const center = { x: 0, y: 0 };
    let angle = 0;
    const sectorAngle = (2 * Math.PI) / arr.length;
    let spinning = false;

    function resizeCanvasCrazyMatka() {
      const size = document.getElementById("crezyWheelWin").offsetWidth;
      canvas.width = size;
      canvas.height = size;
      center.x = size / 2;
      center.y = size / 2;
      drawWheelCrazyMatka();
    }

    function drawWheelCrazyMatka() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      for (let i = 0; i < arr.length; i++) {
        const start = angle + i * sectorAngle;
        const end = start + sectorAngle;
        ctx.beginPath();
        ctx.moveTo(center.x, center.y);
        ctx.arc(center.x, center.y, canvas.width / 2.05, start, end);

        const gradient = ctx.createRadialGradient(center.x, center.y, 0, center.x, center.y, canvas.width / 2);
        gradient.addColorStop(0, arr[i].color1);
        gradient.addColorStop(1, arr[i].color2);
        ctx.fillStyle = gradient;
        ctx.fill();

        ctx.strokeStyle = "#F3B00F";
        ctx.lineWidth = 1;
        ctx.stroke();
        ctx.save();
          ctx.translate(center.x, center.y);
          ctx.rotate(start + sectorAngle / 2);
          ctx.fillStyle = "#fff";
          ctx.font = `bold ${Math.floor(canvas.width / 30)}px Arial`;
          const offset = arr[i].type === 'image' ? canvas.width / 4.5 : canvas.width / 2.5;
          // ctx.font = `bold ${Math.floor(canvas.width / arr[i].type === 'image' ? 12 : 20)}px Arial`;
          // const offset = arr[i].type === 'image' ? canvas.width / 7 : canvas.width / 2.8;
          ctx.fillText(arr[i].resultText, offset, 3);
          ctx.restore();

      }
    }

    function startSpinCrazyMatka(winningIndex) {
      if (spinning) return;
      spinning = true;

      const duration = 9000;
      const initialAngle = angle;
      const targetSectorAngle = (winningIndex + 0.5) * sectorAngle;
      const finalTarget = (3 * Math.PI / 2 - targetSectorAngle + 2 * Math.PI) % (2 * Math.PI);
      const fullRotations = 6 * 2 * Math.PI;
      const totalAngle = fullRotations + finalTarget;

      let startTime;

      function animateSpinCrazyMatka(time) {
        if (!startTime) startTime = time;
        const elapsed = time - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 6); // easeOutCubic

        angle = initialAngle + (totalAngle - initialAngle) * eased;
        drawWheelCrazyMatka();

        if (progress < 1) {
          requestAnimationFrame(animateSpinCrazyMatka);
        } else {
          spinning = false;
          angle %= 2 * Math.PI;
          console.log("Landed on:", arr[winningIndex].resultText);
        }
      }

      requestAnimationFrame(animateSpinCrazyMatka);
    }

    $("#startWheel1").click(function () {
      drawWheelCrazyMatka();
      const randomIndex = Math.floor(Math.random() * arr.length);
      startSpinCrazyMatka(resultSector1);
    });

    $(window).on("resize", resizeCanvasCrazyMatka);
    resizeCanvasCrazyMatka();
  });
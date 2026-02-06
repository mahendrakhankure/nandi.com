$(document).ready(function () {
    const canvas = document.getElementById("wheelCanvas2");
    const ctx = canvas.getContext("2d");
    let imgLoded = 0;
    const arr = [
              {"color1":"#ff0000", "type": "image", "value": "0", "color2":"#ff0000", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/badam_left.png"},
              {"color1":"#212529", "type": "image", "value": "1", "color2":"#212529", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/chidi_Left.png"},
              {"color1":"#ff0000", "type": "image", "value": "2", "color2":"#ff0000", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/playcardn2+(1).png"},
              {"color1":"#212529", "type": "image", "value": "3", "color2":"#212529", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/playcardn4+(2).png"}, 
              {"color1":"#ff0000", "type": "image", "value": "4", "color2":"#ff0000", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/badam_left.png"},
              {"color1":"#212529", "type": "image", "value": "5", "color2":"#212529", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/chidi_Left.png"},
              {"color1":"#ff0000", "type": "image", "value": "6", "color2":"#ff0000", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/playcardn2+(1).png"},
              {"color1":"#212529", "type": "image", "value": "7", "color2":"#212529", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/playcardn4+(2).png"},
              {"color1":"#ff0000", "type": "image", "value": "8", "color2":"#ff0000", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/badam_left.png"},
              {"color1":"#212529", "type": "image", "value": "9", "color2":"#212529", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/chidi_Left.png"},
              {"color1":"#ff0000", "type": "image", "value": "10", "color2":"#ff0000", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/playcardn2+(1).png"},
              {"color1":"#212529", "type": "image", "value": "11", "color2":"#212529", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/playcardn4+(2).png"},
              {"color1":"#ff0000", "type": "image", "value": "12", "color2":"#ff0000", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/badam_left.png"},
              {"color1":"#212529", "type": "image", "value": "13", "color2":"#212529", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/chidi_Left.png"},
              {"color1":"#ff0000", "type": "image", "value": "14", "color2":"#ff0000", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/playcardn2+(1).png"},
              {"color1":"#212529", "type": "image", "value": "15", "color2":"#212529", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/playcardn4+(2).png"},
              {"color1":"#ff0000", "type": "image", "value": "16", "color2":"#ff0000", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/badam_left.png"},
              {"color1":"#212529", "type": "image", "value": "17", "color2":"#212529", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/chidi_Left.png"},
              {"color1":"#ff0000", "type": "image", "value": "18", "color2":"#ff0000", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/playcardn2+(1).png"},
              {"color1":"#212529", "type": "image", "value": "19", "color2":"#212529", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/playcardn4+(2).png"},
              {"color1":"#ff0000", "type": "image", "value": "20", "color2":"#ff0000", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/badam_left.png"},
              {"color1":"#212529", "type": "image", "value": "21", "color2":"#212529", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/chidi_Left.png"},
              {"color1":"#ff0000", "type": "image", "value": "22", "color2":"#ff0000", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/playcardn2+(1).png"},
              {"color1":"#212529", "type": "image", "value": "23", "color2":"#212529", "resultText": "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/playcardn4+(2).png"}
          ]; // Your array remains unchanged

    const center = { x: 0, y: 0 };
    let angle = 0;
    const sectorAngle = (2 * Math.PI) / arr.length;
    let spinning = false;

    function resizeCanvasRedAndBlack() {
      const size = document.getElementById("crezyWheel2").offsetWidth;
    // const size = (Math.min(window.innerWidth, window.innerHeight) * 1.5);
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
        gradient.addColorStop(0, arr[i].color1);
        gradient.addColorStop(1, arr[i].color2);
        ctx.fillStyle = gradient;
        ctx.fill();

        ctx.strokeStyle = "#F3B00F";
        ctx.lineWidth = 2;
        ctx.stroke();
      const img = new Image();
      img.src = arr[i].resultText; // Assuming arr[i].img is a valid image URL
      if(imgLoded==0){
          img.onload = () => {
              imgLoded = 1;
              ctx.save();
              ctx.translate(center.x, center.y);
              ctx.rotate(start + sectorAngle / 2);

              const drawWidth = 28;  // desired width
              const drawHeight = 28; // desired height
              const imageX = canvas.width / 2.2 - drawWidth / 1.2;
              const imageY = -drawHeight / 2;

              ctx.drawImage(img, imageX, imageY, drawWidth, drawHeight); // draw with size
              ctx.restore();
          }
      }
      ctx.save();
      ctx.translate(center.x, center.y);
      ctx.rotate(start + sectorAngle / 2);

      const drawWidth = 28;  // desired width
      const drawHeight = 28; // desired height
      const imageX = canvas.width / 2.2 - drawWidth / 1.2;
      const imageY = -drawHeight / 2;

      ctx.drawImage(img, imageX, imageY, drawWidth, drawHeight); // draw with size
      ctx.restore();

      }
    }

    function startSpinRedAndBlack(winningIndex) {
      if (spinning) return;
      spinning = true;

      const duration = 5000;
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
        const eased = 1 - Math.pow(1 - progress, 3); // easeOutCubic

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

    $("#startWheel2").click(function () {
      const randomIndex = Math.floor(Math.random() * arr.length);
      startSpinRedAndBlack(resultSector2);
    });

    $(window).on("resize", resizeCanvasRedAndBlack);
    resizeCanvasRedAndBlack();
  });
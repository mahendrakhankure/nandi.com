$(document).ready(function () {
    const canvas = document.getElementById("wheelCanvas");
    const ctx = canvas.getContext("2d");

    // Fixed array data
    const arr = [
        {"color1":"#eeb83b", "type": "string", "value": "0", "color2":"#dd7925", "resultText": "0 ♠"},
        {"color1":"#3baedd", "type": "string", "value": "3", "color2":"#2368b0", "resultText": "3 ♥"},
        {"color1":"#d3bd3b", "type": "string", "value": "9", "color2":"#8ba525", "resultText": "9 ♦"},
        {"color1":"#6e4d76", "type": "string", "value": "1", "color2":"#533a58", "resultText": "1 ♣"}, 
        {"color1":"#eeb83b", "type": "string", "value": "0", "color2":"#dd7925", "resultText": "0 ♠"},
        {"color1":"#3baedd", "type": "string", "value": "5", "color2":"#2368b0", "resultText": "5 ♥"},
        {"color1":"#d3bd3b", "type": "string", "value": "4", "color2":"#8ba525", "resultText": "4 ♦"},
        {"color1":"#6e4d76", "type": "string", "value": "3", "color2":"#533a58", "resultText": "3 ♣"},
        {"color1":"#eeb83b", "type": "string", "value": "6", "color2":"#dd7925", "resultText": "6 ♠"},
        {"color1":"#3baedd", "type": "string", "value": "1", "color2":"#2368b0", "resultText": "1 ♥"},
        {"color1":"#FF0000", "type": "image", "value": "assets/images/crezyMatka/RED-BLACK.png", "color2":"#48121d", "resultText": "RED BLACK"},
        {"color1":"#d3bd3b", "type": "string", "value": "7", "color2":"#8ba525", "resultText": "7 ♦"},
        {"color1":"#6e4d76", "type": "string", "value": "9", "color2":"#533a58", "resultText": "9 ♣"},
        {"color1":"#eeb83b", "type": "string", "value": "5", "color2":"#dd7925", "resultText": "5 ♠"},
        {"color1":"#3baedd", "type": "string", "value": "8", "color2":"#2368b0", "resultText": "8 ♥"},
        {"color1":"#d3bd3b", "type": "string", "value": "4", "color2":"#8ba525", "resultText": "4 ♦"},
        {"color1":"#6e4d76", "type": "string", "value": "2", "color2":"#533a58", "resultText": "2 ♣"},
        {"color1":"#eeb83b", "type": "string", "value": "6", "color2":"#dd7925", "resultText": "6 ♠"},
        {"color1":"#3baedd", "type": "string", "value": "7", "color2":"#2368b0", "resultText": "7 ♥"},
        {"color1":"#d3bd3b", "type": "string", "value": "8", "color2":"#8ba525", "resultText": "8 ♦"},
        {"color1":"#6e4d76", "type": "string", "value": "2", "color2":"#6e4d76", "resultText": "2 ♣"},
        {"color1":"#da217e", "type": "image", "value": "assets/images/crezyMatka/CRAZY-WHEEL.png", "color2":"#90144e", "resultText": "CRAZY WHEEL"},
        {"color1":"#eeb83b", "type": "string", "value": "0", "color2":"#dd7925", "resultText": "0 ♠"},
        {"color1":"#3baedd", "type": "string", "value": "3", "color2":"#2368b0", "resultText": "3 ♥"},
        {"color1":"#d3bd3b", "type": "string", "value": "9", "color2":"#8ba525", "resultText": "9 ♦"},
        {"color1":"#6e4d76", "type": "string", "value": "1", "color2":"#533a58", "resultText": "1 ♣"},
        {"color1":"#eeb83b", "type": "string", "value": "0", "color2":"#dd7925", "resultText": "0 ♠"},
        {"color1":"#3baedd", "type": "string", "value": "5", "color2":"#2368b0", "resultText": "5 ♥"},
        {"color1":"#d3bd3b", "type": "string", "value": "4", "color2":"#8ba525", "resultText": "4 ♦"},
        {"color1":"#6e4d76", "type": "string", "value": "3", "color2":"#533a58", "resultText": "3 ♣"},
        {"color1":"#eeb83b", "type": "string", "value": "6", "color2":"#dd7925", "resultText": "6 ♠"},
        {"color1":"#3baedd", "type": "string", "value": "1", "color2":"#2368b0", "resultText": "1 ♥"},
        {"color1":"#FF0000", "type": "image", "value": "assets/images/crezyMatka/RED-BLACK.png", "color2":"#48121d", "resultText": "RED BLACK"},
        {"color1":"#d3bd3b", "type": "string", "value": "7", "color2":"#8ba525", "resultText": "7 ♦"},
        {"color1":"#6e4d76", "type": "string", "value": "9", "color2":"#533a58", "resultText": "9 ♣"},
        {"color1":"#eeb83b", "type": "string", "value": "5", "color2":"#dd7925", "resultText": "5 ♠"},
        {"color1":"#3baedd", "type": "string", "value": "8", "color2":"#2368b0", "resultText": "8 ♥"},
        {"color1":"#d3bd3b", "type": "string", "value": "4", "color2":"#8ba525", "resultText": "4 ♦"},
        {"color1":"#6e4d76", "type": "string", "value": "2", "color2":"#533a58", "resultText": "2 ♣"},
        {"color1":"#eeb83b", "type": "string", "value": "6", "color2":"#dd7925", "resultText": "6 ♠"},
        {"color1":"#3baedd", "type": "string", "value": "7", "color2":"#2368b0", "resultText": "7 ♥"},
        {"color1":"#d3bd3b", "type": "string", "value": "8", "color2":"#8ba525", "resultText": "8 ♦"},
        {"color1":"#6e4d76", "type": "string", "value": "2", "color2":"#533a58", "resultText": "2 ♣"},
        {"color1":"#da217e", "type": "image", "value": "assets/images/crezyMatka/CRAZY-WHEEL.png", "color2":"#90144e", "resultText": "CRAZY WHEEL"}
    ]; // Your array remains unchanged

    let angle = 0;
    let spinning = false;
    let animationFrame;
    const centerImage = new Image();
    centerImage.src = "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/POINTER3.svg";

    const outerRing = new Image();
    outerRing.src = "https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Wheel-Ring-Light-1.webp";
    let outerRingLoaded = false;

    const numSectors = arr.length;
    const sectorAngle = (2 * Math.PI) / numSectors;
    const center = { x: 0, y: 0 };

    function resizeCanvas() {
        const size = (Math.min(window.innerWidth, window.innerHeight) * 1.5);
        canvas.width = size;
        canvas.height = size;
        center.x = size / 2;
        center.y = size / 2;
        drawWheel();
    }

    function drawWheel() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        for (let i = 0; i < numSectors; i++) {
            const start = angle + i * sectorAngle;
            const end = start + sectorAngle;
            ctx.beginPath();
            ctx.moveTo(center.x, center.y);
            ctx.arc(center.x, center.y, canvas.width / 2.05, start, end);
            let gradient = ctx.createRadialGradient(center.x, center.y, 0, center.x, center.y, canvas.width / 2.05);
            gradient.addColorStop(0, arr[i].color1);
            gradient.addColorStop(1, arr[i].color2);
            ctx.fillStyle = gradient;
            ctx.fill();
            ctx.lineWidth = 2;
            ctx.strokeStyle = "#F3B00F";
            ctx.stroke();
            ctx.save();
            ctx.translate(center.x, center.y);
            ctx.rotate(start + sectorAngle / 2);
            ctx.fillStyle = "#fff";
            const textSize = arr[i].type === 'image' ? 35 : 30;
            ctx.font = `bold ${Math.floor(canvas.width / textSize)}px Arial`;
            const offset = arr[i].type === 'image' ? canvas.width / 4.6 : canvas.width / 2.8;
            // ctx.font = `bold ${Math.floor(canvas.width / arr[i].type === 'image' ? 12 : 20)}px Arial`;
            // const offset = arr[i].type === 'image' ? canvas.width / 7 : canvas.width / 2.8;
            // ctx.fillText(arr[i].resultText, offset, 5);
            ctx.fillText(arr[i].resultText, offset, 5);
            ctx.restore();
        }

        if (centerImage.complete) {
            const imgSize = canvas.width * 0.25;
            ctx.drawImage(centerImage, center.x - imgSize / 2, center.y - imgSize / 1.5, imgSize, imgSize * 1.25);
        }else{
            const imgSize = canvas.width * 0.25;
            ctx.drawImage(centerImage, center.x - imgSize / 2, center.y - imgSize / 1.5, imgSize, imgSize * 1.25);
        }

        // if (outerRingLoaded) {
        //     const ringSize = canvas.width;
        //     // ctx.drawImage(outerRing, (center.x - 25) - ringSize / 2, (center.y - 25) - ringSize / 2, (ringSize+50), (ringSize+50));
        //     ctx.drawImage(outerRing, (center.x - 20) - ringSize / 2, (center.y - 22) - ringSize / 2, (ringSize+40), (ringSize+40));
        // }
    }

    function startSpin(winningIndex) {
        let duration = 10000;
        let startTime = null;
        let initialAngle = angle;
        const sectorOffset = (winningIndex + 0.5) * sectorAngle;
        const targetAngle = (3 * Math.PI / 2) - sectorOffset;
        const normalizedTarget = (targetAngle + 2 * Math.PI) % (2 * Math.PI);
        const fullSpins = 6 * 2 * Math.PI;
        const finalAngle = normalizedTarget + fullSpins;

        function animateSpin(timestamp) {
            if (!startTime) startTime = timestamp;
            const elapsed = timestamp - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easedProgress = 1 - Math.pow(1 - progress, 3);
            angle = initialAngle + (finalAngle - initialAngle) * easedProgress;
            drawWheel();
            if (progress < 1) {
                requestAnimationFrame(animateSpin);
            } else {
                spinning = false;
                angle = angle % (2 * Math.PI);
                // console.log("Stopped on:", arr[winningIndex].resultText);
            }
        }

        requestAnimationFrame(animateSpin);
    }

    $('#startWheel').click(function () {
        // console.log(resultSector)
        // const randomIndex = Math.floor(Math.random() * arr.length);
        startSpin(resultSector);
    });

    $(window).on('resize', resizeCanvas);

    outerRing.onload = () => {
        outerRingLoaded = true;
        resizeCanvas();
    };
});
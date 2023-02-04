<?php
function sendMessage($number, $message)
{
    $url = config('jbr.WHATSAPP_URL') . 'messages/chat';
    $body = $message;
    $token = config('jbr.WHATSAPP_TOKEN');

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => "token=$token&to=$number&body=$body&priority=10&referenceId=",
        CURLOPT_HTTPHEADER => ['content-type: application/x-www-form-urlencoded'],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return false;
    } else {
        return true;
    }
}

function checkNumber($number)
{
    $url = config('jbr.WHATSAPP_URL') . 'messages/chat';
    $token = config('jbr.WHATSAPP_TOKEN');
    $params = [
        'token' => $token,
        'chatId' => $number,
        'nocache' => '',
    ];
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.ultramsg.com/instance24533/contacts/check?' . http_build_query($params),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => ['content-type: application/x-www-form-urlencoded'],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return '{"status":"invalid","chatId":""}';
    } else {
        return $response;
    }
}

?>

<?php
function sendText($senderid, $text)
{
    $sendData = [
        'recipient' => [
            'id' => $senderid
        ],
        'message' => [
            'text' => $text
        ]
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v12.0/me/messages?access_token=EAAPRJVmQLYkBAC7ZAVHC3eIltle31zzxR5lQPm6sseTgLgeS3OGLXePzZBCi9xBuSQQmXnhPY06xhZBpz0ZBxsZAem1Jr24UIXdcwGBAFLwmdgLJ4Oy8MEVOZA0RoaXN96IuBVQwkjTRpRlgihgmvUcawsZA41exgiUm5NYpeTYMaRWXNQ1ZCLb7bPCX11jKlcgZD');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($sendData));

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
}
function templatesend($senderid)
{
    $sendData = [
        'recipient' => [
            'id' => $senderid
        ],
        'message' => [
            'attachment' => [
                'type' => 'template',
                'payload' => [
                    'template_type' => 'generic',
                    'elements' => [
                        [
                            'title' => 'danmachi',
                            'image_url' => 'https://cdn.myanimelist.net/images/characters/15/282309.jpg',
                            'subtitle' => 'bell cranel',
                            'default_action' => [
                                'type' => 'web_url',
                                'url' => 'https://myanimelist.net/character/96643/Bell_Cranel',
                                'webview_height_ratio' => 'tall'
                            ],
                            'buttons' => [
                                [
                                    'type' => 'web_url',
                                    'url' => 'https://ceritamadya.blogspot.com/2020/06/siapa-kekasih-bell-cranel-di-danmachi.html',
                                    'title' => 'vikings ni gank '
                                ],
                                [
                                    'type' => 'postback',
                                    'title' => 'senyum',
                                    'payload' => 'bell cranel '
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v12.0/me/messages?access_token=EAAPRJVmQLYkBAC7ZAVHC3eIltle31zzxR5lQPm6sseTgLgeS3OGLXePzZBCi9xBuSQQmXnhPY06xhZBpz0ZBxsZAem1Jr24UIXdcwGBAFLwmdgLJ4Oy8MEVOZA0RoaXN96IuBVQwkjTRpRlgihgmvUcawsZA41exgiUm5NYpeTYMaRWXNQ1ZCLb7bPCX11jKlcgZD');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($sendData));

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
}


$mode = $_GET['hub_mode'];
$challange = $_GET['hub_challenge'];
$token_verify = $_GET['hub_verify_token'];
if ($token_verify === 'messengerbot123') {
    # code...
    echo $challange;
}
$data = file_get_contents("php://input");
file_put_contents('test.json', $data);
// memanggil sender dan time
$data = json_decode((file_get_contents('test.json')));
$message = $data->entry{
    0}->messaging{
    0};
$senderid = $message->sender->id;
$messageText = $message->message->text;
// echo $messageText;
if (isset($message->message)) {
    $messageText = $message->message->text;


    switch ($messageText) {
        case 'halo':
            $text = 'halo juga apa ada perlu bantuan ?';
            sendText($senderid, $text);
            break;
        case 'selamat pagi':
            $text = 'selamat pagi :)';
            sendText($senderid, $text);
            break;
        case 'bell':
            templatesend($senderid);
        default:
            # code...
            break;
    }
} elseif (isset($message->postback)) {
    # code...
    $postback =  $message->postback;
    switch ($postback->title) {
        case 'senyum':
            $text = 'selamat pagi :)';
            sendText($senderid, $postback->payload . $text);
            break;

        default:
            # code...
            break;
    }
}

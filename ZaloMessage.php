<?php
require 'vendor/autoload.php';
use Zalo\Zalo;
$config = array(
    'app_id' => '3816051317758095128',
    'app_secret' => 'bFYUVk633ikRPQuwiQG3',
    'callback_url' => 'https://www.callback.com'
);
$zalo = new Zalo($config);
$accessToken = "83dFRPlzpW8WFCvldVl71IuynssSuC1U8qkfC9xup5ncVOGqYC62CL9__YMUp_T78KUtKTg5j683HkH9nz6UV3X6tXF2sTOCCHgWDyE2nmGa4OSpnwwE47Wat3YudzGeSHwKFCs3woCb0OiRxRJu1GO-k2p--DbREqk4OuBBXMvnTS55YD6bPZ9arrFzqwTZ5ctpMCpNk704JEr2okcxR0TQnddO-RrN16wyMhgfz5HIBOzbd8VnPqGugLEili55RW33MhAPiNDd7jKQgOgA4sX0ZWgktkynLMMB7-Zo_oXNYl8nMfxbpGy";
$msgBuilder = new MessageBuilder('template');
$msgBuilder->withPhoneNumber('0974236296');
$msgBuilder->withTemplate('87efbc018044691a3055', []);
$msgInvite = $msgBuilder->build();
// send request
$response = $zalo->post(ZaloEndPoint::API_OA_SEND_MESSAGE, $accessToken, $msgInvite);
$result = $response->getDecodedBody();
?>
<?php
##----------------------OnyxTM---------------------#
define("TOKEN","XXX:XXX");
function onyx($method, $datas=[]){
    $url = "https://api.telegram.org/bot".TOKEN."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}

##----------------------OnyxTM---------------------#
function sendMessage($chat_id,$text,$btn){
    onyx("sendMessage",[
        'chat_id'=>$chat_id,
        'text'=>$text,
        'parse_mode'=>"HTML",
        'reply_markup'=>$btn
    ]);
}

##----------------------OnyxTM---------------------#
function sendAction($chat_id,$action){
    onyx("sendChatAction",[
        'chat_id'=>$chat_id,
        'action'=>$action,
    ]);
}

##----------------------OnyxTM---------------------#
function sendMail($to,$subject,$txt){
    $headers = "From: countbot@phpbots.tk" . "\r\n" .
        "CC: countbot@phpbots.tk";
    mail($to,$subject,$txt,$headers);
}

##----------------------OnyxTM---------------------#
$update = json_decode(file_get_contents("php://input"));
$chat_id = $update->message->chat->id;
$text = $update->message->text;
$reply = $update->message->reply_to_message;
$data = $update->callback_query->data;
$id = $update->callback_query->message->chat->id;

##----------------------OnyxTM---------------------#
$btn = json_encode([
    'inline_keyboard'=>[
        [['text'=>'قوانین 🔴','callback_data'=>'gavanin']]
    ]
]);

##----------------------OnyxTM---------------------#
if($text == "/start"){
    sendAction($chat_id,'typing');
    sendMessage($chat_id,"سلام دوست من🤡
اول ایمیل شخصی رو که میخوا براش پیام بفرستی رو برای من ارسال کن🤳
بعد با ریپلای ایمیل پیامت رو بفرست😘
",$btn);
}elseif($text == "/about"){
    sendAction($chat_id,'typing');
    sendMessage($chat_id,"گروه برنامه نویسی ONYX 🤡

اعضای تیم‌:
@mench 🤡
@shitilestan 🤡
کانال های ما :
@ch_jockdoni 🤡
@phpbots 🤡",$btn);
}elseif($data == "gavanin"){
    sendAction($id,'typing');
    sendMessage($id,"قوانین 🔰:
هر گونه پیام گمراه کننده و دادن وعده دروغ یا پیامی مبنا بر برنده شدن و... 🤠

        ✅-  درصورت مشاهده هرگونه تخلف اعم از ارسال ایمیل های سیاسی، غیر اخلاقی، فریبنده، هر گونه ایجاد رعب، ایجاد مزاحمت برای اشخاص و ...، تمامی مشخصات و سوابق استفاده کاربر بدون اطلاع قبلی دراختیار پلیس فتا و نیز مراجع قضایی ذیصلاح قرارخواهد گرفت.

✅-  کاربر می پذیرد هيچگونه استفاده خلاف قوانين و مقررات جاري جمهوري اسلامي ايران انجام ندهد.

✅-  ایمیل بات هیچگونه مسئولیتی در قبال ایمیل های ارسالی نمی پذیرد.


👨🏻‍🏫با تشکر مدیریت onyx

دوستان برتر :
🥇جوکدونی
🥈اپکس
🥉بینام",$btn);
}else {
    sendAction($id, 'typing');

    $to = $reply->text;
    $headers = "From: emailbot@phpbots.tk" . "\r\n" .
        "CC: emailbot@phpbots.tk";

    if(mail($to,"New Mail",$text,$headers)){
        sendMessage($id, "ایمیل ارسال شد.
        دریافت کننده : $to
        متن ایمیل :
        $text", $btn);
    }else{
        $a = array('خطای ۱۰۱','خطای ۲۰۲','خطای ۴۰۴');
        sendMessage($id, $a[rand(0,2)], $btn);
    }
}

##----------------------OnyxTM---------------------#

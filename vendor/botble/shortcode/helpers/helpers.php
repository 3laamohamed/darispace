<?php

use Botble\Shortcode\Shortcode;
use Illuminate\Support\HtmlString;

if (! function_exists('shortcode')) {
    function shortcode(): Shortcode
    {
        return app('shortcode');
    }
}

if (! function_exists('add_shortcode')) {
    function add_shortcode(string $key, ?string $name, ?string $description = null, string|null|callable|array $callback = null, ?string $previewImage = ''): Shortcode
    {
        return shortcode()->register($key, $name, $description, $callback, $previewImage);
    }
}

if (! function_exists('do_shortcode')) {
    function do_shortcode(string $content): HtmlString
    {
        return shortcode()->compile($content, true);
    }
}

if (! function_exists('generate_shortcode')) {
    function generate_shortcode(string $name, array $attributes = []): string
    {
        return shortcode()->generateShortcode($name, $attributes);
    }
}

if (! function_exists('sendMessage')) {
    function sendMessage(string $recipient,$booking)
    {
        try {

            // $message='testMessage';
            $message = "تم ارسال طلب حجز جديد يمكنك عرض تفاصيل الطلب او تحميله من هذا الرابط : ".asset('/admin/module/report/booking/email_preview/'.$booking->id);
            $sid    = getenv("TWILIO_AUTH_SID");
            $token  = getenv("TWILIO_AUTH_TOKEN");
            $wa_from= getenv("TWILIO_WHATSAPP_FROM");

            $client = new Client($sid, $token);
        return $client->messages->create($recipient, [
                'from' => $wa_from,
                'body' => $message
            ]);

            // dd('SMS Sent Successfully.');

        } catch (Exception $e) {
            dd("Error: ". $e->getMessage());
        }

        // $sid    = getenv("TWILIO_AUTH_SID");
        // $token  = getenv("TWILIO_AUTH_TOKEN");
        // $wa_from= getenv("TWILIO_WHATSAPP_FROM");
        // $twilio = new Client($sid, $token);

        // // dd($wa_from/);
        // $body = "تم ارسال طلب حجز جديد يمكنك عرض تفاصيل الطلب او تحميله من هذا الرابط : ".asset('/admin/module/report/booking/email_preview/'.$booking->id);

        // return $twilio->messages->create("whatsapp:$recipient",["from" => "whatsapp:$wa_from", "body" => $body]);
    }
}


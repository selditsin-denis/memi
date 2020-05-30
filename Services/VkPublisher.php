<?php


namespace Services;


class VkPublisher
{
    private const TOKEN = "5aea87f29ac4b4dec7e30d87bbef361b16b61d9c2f7e4b5c066032a60b1f42313966893df605d83bc4199";
    private const GROUP_ID = 195702735;

    private function __construct()
    {
    }

    public static function publish(string $imgPath): array
    {
        $response = self::uploadImage($imgPath);
        $server = $response[0];
        $photo = $response[1];
        $hash = $response[2];

        $url_save = "https://api.vk.com/method/photos.saveWallPhoto?group_id=".self::GROUP_ID."&server=".$server."&photo=".$photo."&hash=".$hash."&access_token=".self::TOKEN."&v=5.106";
        $response = file_get_contents($url_save);
        $response_json = json_decode($response, true);

        $owner_id = $response_json['response'][0]['owner_id'];
        $media_id = $response_json['response'][0]['id'];
        $attachments = "photo".$owner_id."_".$media_id;

        $url_post = "https://api.vk.com/method/wall.post?owner_id=-".self::GROUP_ID."&attachments=".$attachments."&access_token=".self::TOKEN."&v=5.106";
        $response = file_get_contents($url_post);
        $response_json = json_decode($response, true);

        return $response_json;
    }

    private static function uploadImage(string $imgPath): array
    {
        $url = "https://api.vk.com/method/photos.getWallUploadServer?group_id=".self::GROUP_ID."&access_token=".self::TOKEN."&v=5.106";
        $response = file_get_contents($url);
        $response_json = json_decode($response, true);
        $upload_url = $response_json['response']['upload_url'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $upload_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'photo' => curl_file_create($imgPath , mime_content_type($imgPath), basename($imgPath))
            ]
        );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = json_decode(curl_exec($ch),true);
        curl_close($ch);
        $server = $result['server'];
        $photo = $result['photo'];
        $hash = $result['hash'];
        return [$server, $photo, $hash];
    }
}
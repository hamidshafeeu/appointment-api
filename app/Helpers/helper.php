<?php

use Google\Cloud\PubSub\PubSubClient;
use STS\JWT\JWTFacade;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

function token($meta = []) {
    session()->put($meta['identifier'], $meta);
    
    return JWTFacade::get($meta['identifier'], $meta, 3600);
}

function shortLink($link)
{
    $response = Http::get('https://cutt.ly/api/api.php', [ 
        'key' => '6d8bd6e030460134cf47d356174d7533d71c1',
        'short' => $link,
        // 'userDomain' => true,
    ]);
    if( $response->successful() ) {
        return Arr::get($response->json(), 'url.shortLink');
    }

    throw new Exception("Could not shorten your link");
}

function publish($data)
{
    $pubSub = new PubSubClient([
        "projectId" => config('services.pubsub.project'),
        'keyFilePath' =>  config('services.pubsub.auth')

    ]);
    $topic = $pubSub->topic('samples');
    $topic->publish([
        'data' => json_encode($data),
    ]);
}
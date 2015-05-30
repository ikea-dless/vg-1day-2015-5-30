<?php

use Symfony\Component\HttpFoundation\Request;

$app = new My1DayServer\Application();
$app['debug'] = true;

$app->get('/messages', function () use ($app) {
    $messages = $app->getAllMessages();

    return $app->json($messages);
});

$app->get('/messages/{id}', function ($id) use ($app) {
    $message = $app->getMessage($id);

    return $app->json($message);
});

$app->post('/messages', function (Request $request) use ($app) {
    $data = $app->validateRequestAsJson($request);

    $username = isset($data['username']) ? $data['username'] : '';
	$body = isset($data['body']) ? $data['body'] : '';

    $pokemons = [];

    $dir = opendir(__DIR__. '/resource/' .$body. '/');
    while($file_name = readdir($dir)){
        $pokemons[] += $file_name;
    }
    $num = rand() % count($pokemons);

    $path = realpath(__DIR__. '/resource/' . $body . '/'. $pokemons[$num]);

    /*
	$hitokage = realpath(__DIR__.'/resource/'.$pokemon[0].'.jpg');
	$hushigidane = realpath(__DIR__.'/resource/'.$pokemon[1].'.jpg');
	$zenigame = realpath(__DIR__.'/resource/'.$pokemon[2].'.jpg');
    */

    $createdMessage = $app->createMessage($username, substr($pokemons[$num], 0, -4), base64_encode(file_get_contents($path)));

    // $createdMessage = $app->createMessage($username, $body, base64_encode(file_get_contents($app['icon_image_path'])));


    return $app->json($createdMessage);
});

return $app;

 function zeikomi($nedan) {
     $nedan = $nedan * 1.05;
	 return $nedan;
 }

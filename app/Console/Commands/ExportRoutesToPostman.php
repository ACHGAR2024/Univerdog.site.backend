<?php

/////////////////////////////////////////////////////////////////////////////////////////////
/////                                                                                   /////
///// 1-    Dans le Terminal   		 php artisan make:command ExportRoutesToPostman     /////
///// 2-    Modifier            	 app\Console\Commands\ExportRoutesToPostman.php     /////
///// 3-    Dans le Terminal    	 php artisan export:postman-routes                  /////
///// 4-    Récuperer à la racine 	 postman_collection.json                            /////
///// 5-    Importer dans Postman                                                       /////
/////                                                                                   /////
/////////////////////////////////////////////////////////////////////////////////////////////
////                                                                                    /////
//// 1-    In the Terminal   		 php artisan make:command ExportRoutesToPostman     /////
//// 2-    Modify            		 app\Console\Commands\ExportRoutesToPostman.php     /////
//// 3-    In the Terminal    	     php artisan export:postman-routes                  /////
//// 4-    Retrieve at the root 	 postman_collection.json                            /////
//// 5-    Import in Postman                                                            /////
////                                                                                    /////
/////////////////////////////////////////////////////////////////////////////////////////////



namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class ExportRoutesToPostman extends Command
{
    protected $signature = 'export:postman-routes';
    protected $description = 'Export API routes to a Postman collection JSON file';

    public function handle()
    {
        $routes = Route::getRoutes();
        $postmanRoutes = [];

        foreach ($routes as $route) {
            $uri = $route->uri();
            if (strpos($uri, 'api/') === 0) {  // Only include routes starting with 'api/'
                $routeName = $route->getName();
                if (!$routeName) {
                    $action = $route->getActionName();
                    $actionParts = explode('@', $action);
                    if (count($actionParts) == 2) {
                        $controller = class_basename($actionParts[0]);
                        $method = $actionParts[1];
                        $routeName = strtolower($controller . '.' . $method);
                    } else {
                        $routeName = $uri;
                    }
                }

                $postmanRoutes[] = [
                    'method' => $route->methods()[0],
                    'name' => $routeName,
                    'uri' => $uri,
                    'action' => $route->getActionName(),
                ];
            }
        }

        // Organize routes into collections (folders)
        $collections = [];
        foreach ($postmanRoutes as $route) {
            $parts = explode('/', $route['uri']);
            $collectionName = isset($parts[1]) ? ucfirst($parts[1]) : 'General';

            if (!isset($collections[$collectionName])) {
                $collections[$collectionName] = [
                    'name' => $collectionName,
                    'item' => [],
                ];
            }

            $collections[$collectionName]['item'][] = [
                'name' => $collectionName . '-' .$route['method'],// Use the route name as the item name //
                'request' => [
                    'method' => $route['method'],
                    'header' => [],
                    'body' => [
                        'mode' => 'raw',
                        'raw' => '',
                    ],
                    'url' => [
                        'raw' => 'http://127.0.0.1:8000/' . $route['uri'],
                        'host' => ['http://127.0.0.1:8000'],
                        'path' => explode('/', $route['uri']),
                    ],
                ],
            ];
        }

        $postmanCollection = [
            'info' => [
                'name' => config('app.name') . ' API',
                'description' => 'Postman collection for ' . config('app.name') . ' API',
                'schema' => 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json',
            ],
            'item' => array_values($collections),
        ];

        file_put_contents('postman_collection.json', json_encode($postmanCollection, JSON_PRETTY_PRINT));
        $this->info('Routes have been exported to postman_collection.json');
    }
}
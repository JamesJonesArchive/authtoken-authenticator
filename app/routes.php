<?php
/**
 *
 * Configure URL routes
 * see: http://www.slimframework.com/docs/objects/router.html
 *
 */

// Application Home Page
$app->get('/', 'AuthTransfer\AuthToken\Action\HomeAction:dispatch')
    ->setName('homepage');

// Display a named template view
$app->get('/views/{name}', 'AuthTransfer\AuthToken\Action\HomeAction:getView')
    ->setName('getView');

// Display images from a webservice.  The album id piece of URL is optional.
$app->get('/example[/{album_id}]', 'AuthTransfer\AuthToken\Action\ExampleAction:dispatch')
    ->setName('displayPlaceholderImages');

// If you need to use POST or PUT you can config the route like this.
//$app->post('/example', 'AuthTransfer\AuthToken\Action\ExampleAction:runThisMethod')
//    ->setName('examplePOST');

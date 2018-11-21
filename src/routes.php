<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("index '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/getrest', function ($request, $response, $args) {
    
   die('jjj');

    return $this->renderer->render($response, 'get_all.phtml', $args);
});

$app->group('/api', function () use ($app) {
 
    // Version group
    $app->group('/v1', function () use ($app) {
		$app->get('/mahasiswas', 'getMahasiswas');
		$app->get('/mahasiswa/{id}', 'getMahasiswa');
		$app->post('/create', 'addMahasiswa');
		$app->put('/update/{id}', 'updateMahasiswa');
		$app->delete('/delete/{id}', 'deleteMahasiswa');
	});
});

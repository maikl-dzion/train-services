<?php

require_once  __DIR__ . '/../vendor/autoload.php';

// use App\Logger;
use App\TrainService;
use PHPUnit\Framework\TestCase;


class TrainServiceTest extends TestCase {

    private $service;

    protected function setUp()
    {
        $auth = [
            'login' => 'test',
            'psw' => 'bYKoDO2it',
            'terminal' => 'htk_test',
            'represent_id' => 22400,
        ];

        $this->service = new TrainService($auth);

    }

    protected function tearDown()
    {
        $this->service = NULL;
    }

    public function testTrainList()
    {
        $result = $this->service->getTrainList();
        $this->assertEquals(3, $result);
    }

}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Master;
use Exception;

class MasterTest extends TestCase
{
    use RefreshDatabase;

    public function testInsertGood()
    {
        $master = new Master();
        $id = $master->insertGood('Items');
        $this->assertIsInt($id);
    }

    public function testRetrieval()
    {
        $master = new Master();
        $master->insertGood('Items');

        $master = new Master();
        $id = $master->fetchIdByName('Items');
        $this->assertIsInt($id);
    }

    public function testFailedRetrieval()
    {
        $this->expectException(Exception::class);
        (new Master)->fetchIdByName('Items');
    }

    public function testInsertionFailure()
    {
        $master = new Master();
        $master->insertGood('Items');

        $master = new Master();
        $this->expectException(Exception::class);
        $master->insertGood('Items');
    }

    public function testDeleteByName()
    {
        $master = new Master();
        $id  = $master->insertGood('Items');

        $master = new Master();
        $deletedId = $master->deleteByName('Items');
        $this->assertEquals($id, $deletedId);
    }

    public function testDeletionFailure()
    {
        $master = new Master();
        $this->expectException(Exception::class);
        $master->deleteByName('Items');
    }

    public function testUpdationByName()
    {
        $master = new Master();
        $id  = $master->insertGood('Items');

        $master = new Master();
        $updatedId = $master->updateGoodByName('Items', 'Products');
        $this->assertEquals($id, $updatedId);

        $master = new Master();
        $retrievalId = $master->fetchIdByName('Products');
        $this->assertEquals($id, $retrievalId);
    }
}

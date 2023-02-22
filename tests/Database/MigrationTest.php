<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Database;

use Doctrine\DBAL\Connection;

use PHPUnit\Framework\TestCase;

/**
 * This test case is for making sure the migration schema is the same once it has been fully ported to doctrine.
 * Once this file has been merged into main, it can be removed.
 *
 * @covers
 * @group database
 */
class MigrationTest extends TestCase
{
    // list of all files in \App\Migrations
    protected $migrations = [];

    /**
     * @dataProvider getMigrations
     */
    public function testMigrationSchema()
    {
        $conn = new Connection;
        dd();
        $this->assertTrue(true);
    }

    public function getMigrations()
    {
        $this->migrations = scandir(\dirname(__FILE__) . '/../../migrations', SCANDIR_SORT_NONE);

    }
}

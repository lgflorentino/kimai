<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use PHPUnit\Framework\TestCase;

/**
 * @covers
 * @group database
 */
class ConnectionTest extends TestCase
{
    /**
     * an externally provided connection to test
     */
    protected $connection;

    /**
     * @dataProvider getPlatforms
     */
    public function testGetConnection()
    {
        $this->assertTrue(true);
    }

    public function getPlatforms()
    {
        return [
            [new MySqlPlatform()],
            [new PostgreSqlPlatform()]
        ];
    }
}

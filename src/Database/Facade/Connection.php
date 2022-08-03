<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Database\Facade;

use Doctrine\DBAL\DriverManager;

class Connection
{
    /**
     * Return the Database connection that is registered in the Kimai kernel
     * @return string
     *
     */

    function getComponent()
    {
        return 'db';
    }

}

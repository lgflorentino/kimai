<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Widget\Type;

use App\Widget\WidgetInterface;

final class AmountMonth extends AbstractAmountPeriod
{
    public function getOptions(array $options = []): array
    {
        return array_merge(['color' => WidgetInterface::COLOR_MONTH], parent::getOptions($options));
    }

    public function getId(): string
    {
        return 'amountMonth';
    }

    public function getData(array $options = [])
    {
        return $this->getRevenue('first day of this month 00:00:00', 'last day of this month 23:59:59', $options);
    }

    public function getPermissions(): array
    {
        return ['view_all_data'];
    }
}
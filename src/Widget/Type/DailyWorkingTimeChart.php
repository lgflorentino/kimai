<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Widget\Type;

use App\Entity\Activity;
use App\Entity\Project;
use App\Timesheet\DateTimeFactory;
use App\Widget\DataProvider\DailyWorkingTimeChartProvider;
use App\Widget\WidgetInterface;
use DateTime;

/**
 * This is rendered inside the PaginatedWorkingTimeChart.
 */
final class DailyWorkingTimeChart extends AbstractWidget
{
    public function __construct(private DailyWorkingTimeChartProvider $dailyWorkingTimeChartProvider)
    {
    }

    public function getWidth(): int
    {
        return WidgetInterface::WIDTH_FULL;
    }

    public function getHeight(): int
    {
        return WidgetInterface::HEIGHT_LARGE;
    }

    public function getPermissions(): array
    {
        return ['view_own_timesheet'];
    }

    public function isInternal(): bool
    {
        return true;
    }

    /**
     * @param array<string, string|bool|int|null> $options
     * @return array<string, string|bool|int|null>
     */
    public function getOptions(array $options = []): array
    {
        return array_merge([
            'begin' => null,
            'end' => null,
            'color' => '',
            'type' => 'bar',
            'id' => uniqid('DailyWorkingTimeChart_'),
        ], parent::getOptions($options));
    }

    /**
     * @param array<string, string|bool|int|null> $options
     */
    public function getData(array $options = []): mixed
    {
        $user = $this->getUser();
        $dateTimeFactory = DateTimeFactory::createByUser($user);

        $begin = $options['begin'];
        if (!($begin instanceof \DateTimeInterface)) {
            if (\is_string($begin)) {
                $begin = new DateTime($begin, new \DateTimeZone($user->getTimezone()));
            } else {
                $begin = $dateTimeFactory->getStartOfWeek();
            }
        }

        $end = $options['end'];
        if (!($end instanceof \DateTimeInterface)) {
            if (\is_string($end)) {
                $end = new DateTime($end, new \DateTimeZone($user->getTimezone()));
            } else {
                $end = $dateTimeFactory->getEndOfWeek($begin);
            }
        }

        $activities = [];
        $statistics = $this->dailyWorkingTimeChartProvider->getData($user, $begin, $end);

        foreach ($statistics as $day) {
            foreach ($day->getDetails() as $entry) {
                /** @var Activity $activity */
                $activity = $entry['activity'];
                /** @var Project $project */
                $project = $entry['project'];

                $id = $project->getId() . '_' . $activity->getId();

                $activities[$id] = [
                    'activity' => $activity,
                    'project' => $project,
                ];
            }
        }

        return [
            'activities' => $activities,
            'data' => $statistics,
        ];
    }

    public function getTitle(): string
    {
        return 'stats.yourWorkingHours';
    }

    public function getId(): string
    {
        return 'DailyWorkingTimeChart';
    }

    public function getTemplateName(): string
    {
        return 'widget/widget-dailyworkingtimechart.html.twig';
    }
}

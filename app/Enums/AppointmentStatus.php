<?php

namespace App\Enums;

enum AppointmentStatus: string
{
     case QUEUED = 'queued';
     case IN_PROGRESS = 'in_progress';
     case COMPLETED = 'completed';
     case CANCELED = 'canceled';
     case NO_SHOW = 'no_show';

     public function label(): string
     {
          return match ($this) {
               self::QUEUED => 'In Queue',
               self::IN_PROGRESS => 'In Progress',
               self::COMPLETED => 'Completed',
               self::CANCELED => 'Canceled',
               self::NO_SHOW => 'No Show',
          };
     }

     public function badgeClass(): string
     {
          return match ($this) {
               self::QUEUED => 'bg-amber-50 text-amber-700',
               self::IN_PROGRESS => 'bg-blue-50 text-blue-700',
               self::COMPLETED => 'bg-emerald-50 text-emerald-700',
               self::CANCELED => 'bg-red-50 text-red-700',
               self::NO_SHOW => 'bg-gray-100 text-gray-600',
          };
     }

     public function canStart(): bool
     {
          return $this === self::QUEUED;
     }
     public function canComplete(): bool
     {
          return $this === self::IN_PROGRESS;
     }
     public function canCancel(): bool
     {
          return in_array($this, [self::QUEUED, self::IN_PROGRESS], true);
     }
}

<?php declare(strict_types=1);

namespace Flunt;

use Flunt\Interfaces\INotifiable;

abstract class Notifiable implements INotifiable
{
    private array $notify = [];

    public function addNotification(string $property, string $message): void
    {
        $this->notify[$property][] = $message;
    }

    public function addNotifications(Contract $contract): void
    {
        if (!$contract->notifications) {
            return;
        }

        $property = array_key_first($contract->notifications);
        foreach ($contract->notifications[$property] as $notification) {
            $this->addNotification($property, $notification);
        }
    }

    public function isValid(): bool
    {
        return count($this->notify) === 0;
    }

    public function filterByMessage(string $message): array
    {
        if ($this->isValid()) {
            return [];
        }

        return array_filter(
            $this->notify[array_key_first($this->notify)],
            fn ($filter) => $filter == $message
        );
    }

    public function getMessages(): array
    {
        return $this->notify;
    }
}

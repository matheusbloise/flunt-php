<?php declare(strict_types=1);

namespace Flunt\Interfaces;

use Flunt\Contract;

interface INotifiable
{
    public function addNotification(string $property, string $message): void;

    public function addNotifications(Contract $contract): void;

    public function isValid(): bool;

    public function getMessages(): array;

    public function filterByMessage(string $message): array;
}
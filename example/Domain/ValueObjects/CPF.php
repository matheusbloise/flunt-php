<?php declare(strict_types=1);

namespace Example\Domain\ValueObjects;

use Flunt\Notifiable;
use Example\Domain\Contracts\CPFContract;

final class CPF extends Notifiable
{
    private const PROPERTY = 'CPF';

    private readonly string $document;

    public function __construct(string $document)
    {
        $this->setDocument($document);
        $this->notifyProperties();
    }

    private function notifyProperties(): void
    {
        $this->addNotifications(
            (new CPFContract)
                ->hasMinLen($this->document, self::PROPERTY, 'Invalid length')
                ->validFormat($this->document, self::PROPERTY, 'Invalid format')
                ->validDocument($this->document, self::PROPERTY, 'Invalid document')
        );
    }

    public function setDocument(string $cpf): void
    {
        $this->document = preg_replace( '/\D/i', '', $cpf);
    }

    public function __toString()
    {
        return $this->document;
    }
}

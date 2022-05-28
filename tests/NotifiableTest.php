<?php declare(strict_types=1);

namespace Test;

use Example\Domain\ValueObjects\CPF;
use PHPUnit\Framework\TestCase;

class NotifiableTest extends TestCase
{
    public function testNotification(): void
    {
        $cpf = new CPF("01234567890");
        $cpf->addNotification("CPF", "document is not valid");
        $this->assertArrayHasKey("CPF", $cpf->getMessages());
        $this->assertCount(1, $cpf->getMessages());
    }

    public function testIsValid(): void
    {
        $cpf = new CPF('012.345.678-90');
        $this->assertTrue($cpf->isValid());
    }

    /**
     * @dataProvider providerDocumentContract
     *
     * @param array{message: string, document: string, expected: bool} $data
     */
    public function testFilterMessageWithoutError(array $data): void
    {
        $cpf = new CPF('012.345.678-90');
        $this->assertSame([], $cpf->filterByMessage($data['message']));
    }

    /**
     * @dataProvider providerDocumentContract
     *
     * @param array{message: string, document: string, expected: bool} $data
     */
    public function testIsNotValid(array $data): void
    {
        $cpf = new CPF($data['document']);
        $this->assertEquals($data['expected'], $cpf->isValid());
    }

    /**
     * @dataProvider providerDocumentContract
     *
     * @param array{message: string, document: string, expected: bool} $data
     */
    public function testGetMessages(array $data): void
    {
        $cpf = new CPF($data['document']);
        $this->assertEquals($data['message'], ...$cpf->getMessages()['CPF']);
    }

    /**
     * @dataProvider providerDocumentContract
     *
     * @param array{message: string, document: string, expected: bool} $data
     */
    public function testFilterByMessage(array $data): void
    {
        $cpf = new CPF($data['document']);
        $this->assertSame($data['message'], ...$cpf->filterByMessage($data['message']));
    }

    /**
     * @dataProvider providerDocumentContract
     *
     * @return array<string, array<int, array<string, string|bool>>>
     * @phpstan-ignore-next-line
     */
    private function providerDocumentContract(): array
    {
        return [
            'Invalid length' => [
                ['message' => 'Invalid length', 'document' => '012.345.678-', 'expected' => false]
            ],
            'Invalid format' => [
                ['message' => 'Invalid format', 'document' => '111.111.111.11', 'expected' => false],
            ],
            'Invalid document' => [
                ['message' => 'Invalid document', 'document' => '012.345.678-99', 'expected' => false],
            ],
        ];
    }
}

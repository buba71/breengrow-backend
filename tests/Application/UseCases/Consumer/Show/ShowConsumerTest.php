<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Consumer\Show;

use App\Application\UseCases\Consumer\Show\ShowConsumer;
use App\Application\UseCases\Consumer\Show\ShowConsumerPresenter;
use App\Application\UseCases\Consumer\Show\ShowConsumerResponse;
use App\Domain\Model\Consumer\Consumer;
use App\Tests\Mock\Domain\InMemoryConsumerRepository;
use PHPUnit\Framework\TestCase;

final class ShowConsumerTest extends TestCase
{
    private InMemoryConsumerRepository $repository;

    private ShowConsumer $showConsumer;

    private \PHPUnit\Framework\MockObject\MockObject $presenter;

    private ShowConsumerResponse $response;

    protected function setUp(): void
    {
        $this->repository = new InMemoryConsumerRepository();
        $this->showConsumer = new ShowConsumer($this->repository);
        $this->presenter = $this->getMockBuilder(ShowConsumerPresenter::class)
                                ->setMethods(['present'])
                                ->getMock();
        $this->response = new ShowConsumerResponse();

        // First add Consumer to InMemory for test.
        $this->repository->addConsumer(static::createConsumer());
    }

    public function testIfReturnConsumer(): void
    {
        // Given request
        $request = ShowConsumerRequestBuilder::default()->build();

        // Then Response Should Be.
        $this->response->setConsumer(static::createConsumer());
        $this->response->setStatus(200);

        $this->presenter->expects($this->once())
            ->method('present')
            ->with($this->response);

        $this->showConsumer->execute($request, $this->presenter);
    }

    public static function createConsumer(): Consumer
    {
        return new Consumer(
            '12345',
            'John',
            'Doe',
            'test@test.fr',
            'azeaze',
            'salt',
            ['ROLE_CONSUMER']
        );
    }
}

<?php

declare(strict_types=1);

namespace SoftwareArchetypes\Availability\SimpleAvailability\Application;

use DateInterval;
use DateTimeImmutable;
use SoftwareArchetypes\Availability\SimpleAvailability\Common\Clock;
use SoftwareArchetypes\Availability\SimpleAvailability\Common\Result;
use SoftwareArchetypes\Availability\SimpleAvailability\Domain\AssetAvailability;
use SoftwareArchetypes\Availability\SimpleAvailability\Domain\AssetAvailabilityRepository;
use SoftwareArchetypes\Availability\SimpleAvailability\Domain\AssetId;
use SoftwareArchetypes\Availability\SimpleAvailability\Domain\OwnerId;
use SoftwareArchetypes\Availability\SimpleAvailability\Events\AssetRegistered;
use SoftwareArchetypes\Availability\SimpleAvailability\Events\AssetRegistrationRejected;
use SoftwareArchetypes\Availability\SimpleAvailability\Events\DomainEventsPublisher;

class AvailabilityService
{
    public function __construct(
        private readonly AssetAvailabilityRepository $repository,
        private readonly DomainEventsPublisher $eventsPublisher,
        private readonly Clock $clock
    ) {
    }

    /**
     * @return Result<AssetRegistrationRejected, AssetRegistered>
     */
    public function registerAssetWith(AssetId $assetId): Result
    {
        if ($this->repository->existsById($assetId)) {
            $event = AssetRegistrationRejected::from($assetId, 'ASSET_ALREADY_EXISTS');
            $this->eventsPublisher->publish($event);
            return Result::failure($event);
        }

        $assetAvailability = AssetAvailability::of($assetId, $this->clock);
        $this->repository->save($assetAvailability);

        $event = AssetRegistered::from($assetId);
        $this->eventsPublisher->publish($event);

        return Result::success($event);
    }

    public function activate(AssetId $assetId): Result
    {
        $assetAvailability = $this->repository->findById($assetId);
        if ($assetAvailability === null) {
            return Result::failure('Asset not found');
        }

        $result = $assetAvailability->activate();
        $this->handle($assetAvailability, $result);

        return $result;
    }

    public function withdraw(AssetId $assetId): Result
    {
        $assetAvailability = $this->repository->findById($assetId);
        if ($assetAvailability === null) {
            return Result::failure('Asset not found');
        }

        $result = $assetAvailability->withdraw();
        $this->handle($assetAvailability, $result);

        return $result;
    }

    public function lock(AssetId $assetId, OwnerId $ownerId, DateInterval $duration): Result
    {
        $assetAvailability = $this->repository->findById($assetId);
        if ($assetAvailability === null) {
            return Result::failure('Asset not found');
        }

        $result = $assetAvailability->lockFor($ownerId, $duration);
        $this->handle($assetAvailability, $result);

        return $result;
    }

    public function lockIndefinitely(AssetId $assetId, OwnerId $ownerId): Result
    {
        $assetAvailability = $this->repository->findById($assetId);
        if ($assetAvailability === null) {
            return Result::failure('Asset not found');
        }

        $result = $assetAvailability->lockIndefinitelyFor($ownerId);
        $this->handle($assetAvailability, $result);

        return $result;
    }

    public function unlock(AssetId $assetId, OwnerId $ownerId, DateTimeImmutable $at): Result
    {
        $assetAvailability = $this->repository->findById($assetId);
        if ($assetAvailability === null) {
            return Result::failure('Asset not found');
        }

        $result = $assetAvailability->unlockFor($ownerId, $at);
        $this->handle($assetAvailability, $result);

        return $result;
    }

    public function unlockIfOverdue(AssetId $assetId): void
    {
        $assetAvailability = $this->repository->findById($assetId);
        if ($assetAvailability === null) {
            return;
        }

        $event = $assetAvailability->unlockIfOverdue();
        if ($event !== null) {
            $this->repository->save($assetAvailability);
            $this->eventsPublisher->publish($event);
        }
    }

    private function handle(AssetAvailability $assetAvailability, Result $result): void
    {
        $this->repository->save($assetAvailability);
        $result->peekBoth(
            fn($event) => $this->eventsPublisher->publish($event),
            fn($event) => $this->eventsPublisher->publish($event)
        );
    }
}

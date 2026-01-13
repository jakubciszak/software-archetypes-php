<?php

declare(strict_types=1);

namespace SoftwareArchetypes\Availability\SimpleAvailability\Tests\Support;

use SoftwareArchetypes\Availability\SimpleAvailability\Domain\AssetAvailability;
use SoftwareArchetypes\Availability\SimpleAvailability\Domain\AssetAvailabilityRepository;
use SoftwareArchetypes\Availability\SimpleAvailability\Domain\AssetId;
use SoftwareArchetypes\Availability\SimpleAvailability\Domain\OwnerId;
use SoftwareArchetypes\Availability\SimpleAvailability\Domain\OwnerLock;
use SoftwareArchetypes\Availability\SimpleAvailability\Domain\WithdrawalLock;
use SoftwareArchetypes\Availability\SimpleAvailability\Tests\Fixtures\AssetAvailabilityFixture;

trait AssetAvailabilityStoreSupport
{
    abstract protected function getRepository(): AssetAvailabilityRepository;

    protected function existingAsset(): AssetAvailability
    {
        $asset = AssetAvailabilityFixture::someNewAsset();
        $this->getRepository()->save($asset);
        return $asset;
    }

    protected function activatedAsset(): AssetAvailability
    {
        $asset = AssetAvailabilityFixture::create()
            ->thatIsActive()
            ->get();
        $this->getRepository()->save($asset);
        return $asset;
    }

    protected function assetLockedBy(OwnerId $ownerId): AssetAvailability
    {
        $asset = AssetAvailabilityFixture::create()
            ->thatIsActive()
            ->thatWasLockedByOwnerWith($ownerId)
            ->forSomeValidDuration()
            ->get();
        $this->getRepository()->save($asset);
        return $asset;
    }

    protected function lockedAsset(): AssetAvailability
    {
        $asset = AssetAvailabilityFixture::create()
            ->thatIsActive()
            ->thatWasLockedBySomeOwner()
            ->forSomeValidDuration()
            ->get();
        $this->getRepository()->save($asset);
        return $asset;
    }

    protected function thereIsAWithdrawnAssetWith(AssetId $id): bool
    {
        $asset = $this->getRepository()->findById($id);
        if ($asset === null) {
            return false;
        }

        $lock = $asset->currentLock();
        return $lock instanceof WithdrawalLock;
    }

    protected function thereIsALockedAssetWith(AssetId $assetId, OwnerId $ownerId): bool
    {
        $asset = $this->getRepository()->findById($assetId);
        if ($asset === null) {
            return false;
        }

        $lock = $asset->currentLock();
        return $lock instanceof OwnerLock && $lock->ownerId()->equals($ownerId);
    }

    protected function assetIsRegisteredWith(AssetId $assetId): bool
    {
        return $this->getRepository()->findById($assetId) !== null;
    }

    protected function thereIsAnUnlockedAssetWith(AssetId $assetId): bool
    {
        $asset = $this->getRepository()->findById($assetId);
        if ($asset === null) {
            return false;
        }

        return $asset->currentLock() === null;
    }
}

<?php

declare(strict_types=1);

namespace SoftwareArchetypes\Availability\SimpleAvailability\Common;

use Closure;

/**
 * @template F
 * @template S
 */
final readonly class Result
{
    /**
     * @param S|null $success
     * @param F|null $failure
     */
    private function __construct(
        private mixed $success,
        private mixed $failure,
        private bool $isSuccess
    ) {
    }

    /**
     * @template T
     * @param T $value
     * @return self<never, T>
     */
    public static function success(mixed $value): self
    {
        return new self($value, null, true);
    }

    /**
     * @template T
     * @param T $value
     * @return self<T, never>
     */
    public static function failure(mixed $value): self
    {
        return new self(null, $value, false);
    }

    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    public function isFailure(): bool
    {
        return !$this->isSuccess;
    }

    /**
     * @return S
     */
    public function getSuccess(): mixed
    {
        if (!$this->isSuccess) {
            throw new \LogicException('Cannot get success value from a failure result');
        }
        return $this->success;
    }

    /**
     * @return F
     */
    public function getFailure(): mixed
    {
        if ($this->isSuccess) {
            throw new \LogicException('Cannot get failure value from a success result');
        }
        return $this->failure;
    }

    /**
     * @template T
     * @param Closure(S): T $mapper
     * @return self<F, T>
     */
    public function map(Closure $mapper): self
    {
        if ($this->isSuccess) {
            return self::success($mapper($this->success));
        }
        return self::failure($this->failure);
    }

    /**
     * @template T
     * @param Closure(F): T $mapper
     * @return self<T, S>
     */
    public function mapFailure(Closure $mapper): self
    {
        if ($this->isFailure()) {
            return self::failure($mapper($this->failure));
        }
        return self::success($this->success);
    }

    /**
     * @template SF
     * @template SS
     * @param Closure(S): self<SF, SS> $mapper
     * @return self<F|SF, SS>
     */
    public function flatMap(Closure $mapper): self
    {
        if ($this->isSuccess) {
            return $mapper($this->success);
        }
        return self::failure($this->failure);
    }

    /**
     * @template T
     * @param Closure(S): T $successMapper
     * @param Closure(F): T $failureMapper
     * @return T
     */
    public function fold(Closure $successMapper, Closure $failureMapper): mixed
    {
        return $this->isSuccess
            ? $successMapper($this->success)
            : $failureMapper($this->failure);
    }

    /**
     * @param Closure(S): void $action
     * @return self<F, S>
     */
    public function peek(Closure $action): self
    {
        if ($this->isSuccess) {
            $action($this->success);
        }
        return $this;
    }

    /**
     * @param Closure(S): void $action
     * @return self<F, S>
     */
    public function peekSuccess(Closure $action): self
    {
        return $this->peek($action);
    }

    /**
     * @param Closure(F): void $action
     * @return self<F, S>
     */
    public function peekFailure(Closure $action): self
    {
        if ($this->isFailure()) {
            $action($this->failure);
        }
        return $this;
    }

    /**
     * @param Closure(S): void $successAction
     * @param Closure(F): void $failureAction
     * @return self<F, S>
     */
    public function peekBoth(Closure $successAction, Closure $failureAction): self
    {
        if ($this->isSuccess) {
            $successAction($this->success);
        } else {
            $failureAction($this->failure);
        }
        return $this;
    }

    /**
     * @template T
     * @param Closure(S): T $successMapper
     * @param Closure(F): self<F, T> $failureMapper
     * @return self<F, T>
     */
    public function ifSuccessOrElse(Closure $successMapper, Closure $failureMapper): self
    {
        if ($this->isSuccess) {
            return self::success($successMapper($this->success));
        }
        return $failureMapper($this->failure);
    }

    /**
     * @template FS
     * @template FF
     * @param Closure(S): FS $successMapper
     * @param Closure(F): FF $failureMapper
     * @return self<FF, FS>
     */
    public function biMap(Closure $successMapper, Closure $failureMapper): self
    {
        return $this->isSuccess
            ? self::success($successMapper($this->success))
            : self::failure($failureMapper($this->failure));
    }
}

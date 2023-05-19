<?php

final class ConstructionStageStatus
{
    public const NEW = 'NEW';
    public const PLANNED = 'PLANNED';
    public const DELETED = 'DELETED';

    private function __construct()
    {
        // The constructor is private to prevent instantiation of this class.
    }

    /**
     * Checks if a given value is a valid ConstructionStageStatus.
     *
     * @param string $value The value to check.
     * @return bool True if the value is a valid ConstructionStageStatus, false otherwise.
     */
    public static function isValid(string $value): bool
    {
        return in_array($value, self::toArray());
    }

    /**
     * Returns an array with all valid ConstructionStageStatus values.
     *
     * @return array The valid ConstructionStageStatus values.
     */
    public static function toArray(): array
    {
        return [
            self::NEW,
            self::PLANNED,
            self::DELETED,
        ];
    }
}


?>
<?php

    /**
 * Class ValidationService
 *
 * Middleware class for validating data.
 */
class ValidationService {
    /**
     * Validates the construction data.
     *
     * @param mixed $data The data to validate.
     *
     * @return bool|string True if the data is valid, or an error message if validation fails.
     */
    public function validatePostData($data) {
        
        if (!$this->isValidName($data->name)) {
            return 'Name exceeds maximum length of 255 characters.';
        }
        if (!$this->isValidISO8601DateTime($data->startDate)) {
            return 'Invalid start date format. It should be in ISO8601 format (e.g., 2022-12-31T14:59:00Z).';
        }
        if (!$this->isValidISO8601DateTime($data->endDate) && $data->endDate !== null) {
            return 'Invalid end_date format. It should be null or in ISO8601 format.';
        }
        if (!$this->isValidEndDate($data->startDate, $data->endDate)) {
            return 'End date cannot be sooner than start date.';
        }
        if (!$this->isValidDurationUnit($data->durationUnit)) {
            return 'Invalid durationUnit. It should be one of HOURS, DAYS, WEEKS, or skipped.';
        }
        if (!$this->isValidColor($data->color)) {
            return 'Invalid color format. It should be null or a valid HEX color (e.g., #FF0000).';
        }
        if (!$this->isValidExternalId($data->externalId)) {
            return 'externalId exceeds maximum length of 255 characters.';
        }
        if (!$this->isValidStatus($data->status)) {
            return 'Invalid status. It should be one of NEW, PLANNED, or DELETED.';
        }

        $duration = $this->calculateDuration($data->startDate, $data->endDate, $data->durationUnit);
        $data->duration = $duration;

        return true; // Data is valid
    }

    /**
     * Checks if the name is valid.
     *
     * @param string $name The name to validate.
     *
     * @return bool True if the name is valid, false otherwise.
     */
    private function isValidName($name) {
        return strlen($name) <= 255;
    }

    /**
     * Checks if the datetime is in valid ISO8601 format.
     *
     * @param string $datetime The datetime to validate.
     *
     * @return bool True if the datetime is valid, false otherwise.
     */
    private function isValidISO8601DateTime($datetime) {
        return DateTime::createFromFormat('Y-m-d\TH:i:s\Z', $datetime) !== false;
    }

    /**
     * Checks if the end date is valid based on the start date.
     *
     * @param string      $startDate The start date.
     * @param string|null $endDate   The end date, or null.
     *
     * @return bool True if the end date is valid, false otherwise.
     */
    private function isValidEndDate($startDate, $endDate) {
        if ($endDate === null) {
            return true; // No need for further validation if end_date is null
        }

        $startDateObj = new DateTime($startDate);
        $endDateObj = new DateTime($endDate);

        return $endDateObj >= $startDateObj;
    }

       /**
     * Checks if the duration unit is valid.
     *
     * @param string $durationUnit The duration unit to validate.
     *
     * @return bool True if the duration unit is valid, false otherwise.
     */
    private function isValidDurationUnit($durationUnit) {
        return in_array($durationUnit, ['HOURS', 'DAYS', 'WEEKS', '']);
    }

    /**
     * Checks if the color is valid.
     *
     * @param string|null $color The color to validate.
     *
     * @return bool True if the color is valid, false otherwise.
     */
    private function isValidColor($color) {
        return $color === null || preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color);
    }

    /**
     * Checks if the external ID is valid.
     *
     * @param string|null $externalId The external ID to validate.
     *
     * @return bool True if the external ID is valid, false otherwise.
     */
    private function isValidExternalId($externalId) {
        return $externalId === null || strlen($externalId) <= 255;
    }

    /**
     * Checks if the status is valid.
     *
     * @param string $status The status to validate.
     *
     * @return bool True if the status is valid, false otherwise.
     */
    private function isValidStatus($status) {
        return in_array($status, ['NEW', 'PLANNED', 'DELETED']);
    }

    /**
     * Calculates the duration based on the start date, end date, and duration unit.
     *
     * @param string      $startDate    The start date.
     * @param string|null $endDate      The end date, or null.
     * @param string      $durationUnit The duration unit.
     *
     * @return float|null The calculated duration or null if invalid.
     */
    private function calculateDuration($startDate, $endDate, $durationUnit) {
        if (!$this->isValidISO8601DateTime($startDate)) {
            return null;
        }
        if (!$this->isValidISO8601DateTime($endDate) && $endDate !== null) {
            return null;
        }
        if (!$this->isValidEndDate($startDate, $endDate)) {
            return null;
        }
        if (!$this->isValidDurationUnit($durationUnit)) {
            return null;
        }

        $startDateTime = DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s\Z', $startDate);
        $endDateTime = DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s\Z', $endDate);

        if ($endDateTime === false) {
            return null;
        }

        $durationInSeconds = $endDateTime->getTimestamp() - $startDateTime->getTimestamp();

        switch ($durationUnit) {
            case 'HOURS':
                $duration = $durationInSeconds / 3600;
                break;
            case 'WEEKS':
                $duration = $durationInSeconds / (3600 * 24 * 7);
                break;
            case 'DAYS':
            default:
                $duration = $durationInSeconds / (3600 * 24);
                break;
        }

        return $duration;
    }
}

?>
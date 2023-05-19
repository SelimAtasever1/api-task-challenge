<?php 

/**
 * Class ConstructionStage
 *
 * Represents a construction stage.
 */
class ConstructionStage
{
    /**
     * @var int The ID of the construction stage.
     */
    private int $id;

    /**
     * @var string|null The name of the construction stage.
     */
    private ?string $name;

    /**
     * @var DateTime|null The start date of the construction stage.
     */
    private ?DateTime $startDate;

    /**
     * @var DateTime|null The end date of the construction stage.
     */
    private ?DateTime $endDate;

    /**
     * @var int|null The duration of the construction stage.
     */
    private ?int $duration;

    /**
     * @var string|null The unit of duration for the construction stage.
     */
    private ?string $durationUnit;

    /**
     * @var string|null The color associated with the construction stage.
     */
    private ?string $color;

    /**
     * @var string|null The external ID of the construction stage.
     */
    private ?string $externalId;

    /**
     * @var string|null The status of the construction stage.
     */
    private ?string $status;

    /**
     * ConstructionStage constructor.
     *
     * @param int          $id           The ID of the construction stage.
     * @param string|null  $name         The name of the construction stage.
     * @param DateTime|null $startDate    The start date of the construction stage.
     * @param DateTime|null $endDate      The end date of the construction stage.
     * @param int|null     $duration     The duration of the construction stage.
     * @param string|null  $durationUnit The unit of duration for the construction stage.
     * @param string|null  $color        The color associated with the construction stage.
     * @param string|null  $externalId   The external ID of the construction stage.
     * @param string|null  $status       The status of the construction stage.
     */
    public function __construct(
        int $id,
        ?string $name,
        ?DateTime $startDate,
        ?DateTime $endDate,
        ?int $duration = null,
        ?string $durationUnit,
        ?string $color,
        ?string $externalId,
        ?string $status
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->duration = $duration;
        $this->durationUnit = $durationUnit;
        $this->color = $color;
        $this->externalId = $externalId;
        $this->status = $status;
    }

    /**
     * Get the ID of the construction stage.
     *
     * @return int The ID of the construction stage.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the name of the construction stage.
     *
     * @return string The name of the construction stage.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the start date of the construction stage.
     *
     * @return DateTime The start date of the construction stage.
     */
    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

        /**
     * Get the end date of the construction stage.
     *
     * @return DateTime The end date of the construction stage.
     */
    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    /**
     * Get the duration of the construction stage.
     *
     * @return int The duration of the construction stage.
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * Get the duration unit of the construction stage.
     *
     * @return string The duration unit of the construction stage.
     */
    public function getDurationUnit(): string
    {
        return $this->durationUnit;
    }

    /**
     * Get the color associated with the construction stage.
     *
     * @return string The color associated with the construction stage.
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * Get the external ID of the construction stage.
     *
     * @return string The external ID of the construction stage.
     */
    public function getExternalId(): string
    {
        return $this->externalId;
    }

    /**
     * Get the status of the construction stage.
     *
     * @return string The status of the construction stage.
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}

?>
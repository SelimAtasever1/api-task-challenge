<?php

require_once 'C:/xampp/htdocs/api-tasks/classes/models/ConstructionStage.php';
require_once 'C:/xampp/htdocs/api-tasks/classes/utils/ConstructionStageStatus.php';

/**
 * Class ConstructionStageRepository
 *
 * This class handles the database operations related to construction stages.
 */
class ConstructionStageRepository
{
    private PDO $db;
    private $constructionStage;

    /**
     * ConstructionStageRepository constructor.
     *
     * @param PDO $db The database connection.
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Creates a new construction stage.
     *
     * @param array $constructionStageData The construction stage data.
     * @return array The inserted construction stage data.
     */
    public function createNewConstructionStage(array $constructionStageData): array
    {
        $query = "
            INSERT INTO construction_stages
                (name, start_date, end_date, duration, durationUnit, color, externalId, status)
                VALUES (:name, :start_date, :end_date, :duration, :durationUnit, :color, :externalId, :status)
        ";

        $statement = $this->db->prepare($query);
        $statement->execute($constructionStageData);

        $insertedId = $this->db->lastInsertId();
        return $this->getSingleConstructionStage($insertedId);
    }

    /**
     * Updates the status of a construction stage by ID.
     *
     * @param int $id The ID of the construction stage.
     * @param string $status The new status value.
     * @return bool Returns true if the update is successful, false otherwise.
     * @throws InvalidArgumentException If the status value is invalid.
     */
    public function updateConstructionStageStatusById(int $id, string $status): bool
    {
        if ($status && !ConstructionStageStatus::isValid($status)) {
            throw new InvalidArgumentException('Invalid status value!');
        }

        $query = "
            UPDATE construction_stages
            SET status = :status
            WHERE ID = :id
        ";

        $statement = $this->db->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':status', $status, PDO::PARAM_STR);

        return $statement->execute();
    }

    /**
     * Deletes a construction stage status by ID.
     *
     * @param int $id The ID of the construction stage.
     * @return bool Returns true if the deletion is successful.
     * @throws Exception If the construction stage with the given ID is not found, or if the deletion fails.
     */
    public function deleteConstructionStageStatusById($id): bool
    {
        $query = "
            UPDATE construction_stages
            SET status = 'DELETED'
            WHERE ID = :id
        ";

        $statement = $this->db->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        if ($statement->execute()) {
            if ($statement->rowCount() === 0) {
                throw new Exception("Construction stage with ID $id not found.");
            }
            return true;
        } else {
            throw new Exception("Failed to delete construction stage with ID $id.");
        }
    }

    /**
     * Retrieves a single construction stage by ID.
     *
     * @param int $id The ID of the construction stage.
     * @return array|null The retrieved construction stage data if found,
     * @throws Exception If there is an error executing the query.
     */

     public function getSingleConstructionStage(int $id): ?array
     {
         $query = "
             SELECT
                 ID as id,
                 name, 
                 strftime('%Y-%m-%dT%H:%M:%SZ', start_date) as startDate,
                 strftime('%Y-%m-%dT%H:%M:%SZ', end_date) as endDate,
                 duration,
                 durationUnit,
                 color,
                 externalId,
                 status
             FROM construction_stages
             WHERE ID = :id
         ";
 
         $statement = $this->db->prepare($query);
         $statement->bindParam(':id', $id, PDO::PARAM_INT);
         $statement->execute();
 
         $result = $statement->fetch(PDO::FETCH_ASSOC);
 
         return $result ? $result : null;
     }
 
     /**
      * Retrieves all construction stages.
      *
      * @return array An array of construction stage data.
      * @throws Exception If there is an error executing the query.
      */
     public function getAllConstructionStages(): array
     {
         $stmt = $this->db->prepare("
             SELECT
                 ID as id,
                 name, 
                 strftime('%Y-%m-%dT%H:%M:%SZ', start_date) as startDate,
                 strftime('%Y-%m-%dT%H:%M:%SZ', end_date) as endDate,
                 duration,
                 durationUnit,
                 color,
                 externalId,
                 status
             FROM construction_stages"
         );
         
         $stmt->execute();
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }
}

?>
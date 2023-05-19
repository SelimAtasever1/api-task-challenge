<?php

require_once 'classes/services/ConstructionStageRepository.php';
require_once 'classes/services/ValidationService.php';

/**
 * Class ConstructionStages
 * Handles CRUD operations for construction stages.
 */
class ConstructionStages
{
    private ConstructionStageRepository $constructionStageRepo;
    private ValidationService $validationService;
    private $db;

    /**
     * ConstructionStages constructor.
     */
    public function __construct()
    {
        $this->db = Api::getDb();
        $this->constructionStageRepo = new ConstructionStageRepository($this->db);
        $this->validationService = new ValidationService();
    }

    /**
     * Sets construction status to DELETED.
     *
     * @param int $id The ID of the construction stage to delete.
     *
     * @return string|null The success message if deletion was successful, null otherwise.
     */
    public function deleteSingle($id)
    {
        try {
            $result = $this->constructionStageRepo->deleteConstructionStageStatusById($id);

            if ($result == true) {
                return "Patching construction with id: $id status changed to deleted!";
            }
        } catch (Exception $e) {
            header("Content-Type: application/json");
            http_response_code(400);
            return $e->getMessage();
        }
    }

    /**
     * Updates the status of a construction stage with the given ID.
     *
     * @param int $id The ID of the construction stage to update.
     *
     * @return string|null The success message if the update was successful, null otherwise.
     */
    public function updateWithId($id)
    {
        try {
            $requestBody = json_decode(file_get_contents('php://input'));
            $status = $requestBody->status;

            $result = $this->constructionStageRepo->updateConstructionStageStatusById($id, $status);

            if ($result == true) {
                return "Patching construction with id: $id status changed to $status!";
            }
        } catch (Exception $e) {
            header("Content-Type: application/json");
            http_response_code(400);
            return $e->getMessage();
        }
    }

    /**
     * Retrieves all construction stages.
     *
     * @return array The array of construction stages.
     */
    public function getAll()
    {
        $result = $this->constructionStageRepo->getAllConstructionStages();
        return $result;
    }

    /**
     * Retrieves a single construction stage by ID.
     *
     * @param int $id The ID of the construction stage to retrieve.
     *
     * @return array|null The construction stage data if found, null otherwise.
     */
    public function getSingle($id)
    {
        $result = $this->constructionStageRepo->getSingleConstructionStage($id);
        return $result;
    }


	/**
	 * Creates a new construction stage.
	 *
	 * @param ConstructionStagesCreate $data The construction stage data.
	 *
	 * @return array|string The inserted construction stage data if successful, or a string indicating validation failure.
	 */
	public function post(ConstructionStagesCreate $data): array|string
	{
		$validationResult = $this->validationService->validatePostData($data);
		if ($validationResult !== true) {
			// Validation failed
			http_response_code(400);
			return $validationResult;
		}

		$constructionStageData = [
			'name' => $data->name,
			'start_date' => $data->startDate,
			'end_date' => $data->endDate,
			'duration' => $data->duration,
			'durationUnit' => $data->durationUnit,
			'color' => $data->color,
			'externalId' => $data->externalId,
			'status' => $data->status,
		];

		$insertedConstructionStage = $this->constructionStageRepo->createNewConstructionStage($constructionStageData);

		return $insertedConstructionStage;
	}   
}

?>
 <?php
include_once __DIR__ . '/../config.php';
include_once __DIR__ . '/../System/Database.php';

class Model
{
    protected $db;
    protected $table;
    protected $primaryId = 'id';
    private array $errors = [];

    public function find($id) {}

    public function save(array $data) {}

    public function hasErrors(): bool
    {
        return $this->errors ? true : false;
    }

    /**
     * @return bool|null
     */
    public function getLastError()
    {
        return end($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}

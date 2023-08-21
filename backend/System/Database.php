 <?php
class Database
{
    private $connection;

    public function __construct() {
        try {
            $this->connection = new PDO(sprintf('%s:',DB_TYPE))
        }
    }
    public function query(string $query) {}
    public function getResultsArray(): array {}
}

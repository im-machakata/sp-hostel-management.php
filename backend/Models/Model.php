 <?php
    include_once __DIR__ . '/../config.php';
    include_once __DIR__ . '/../System/Database.php';

    class Model
    {
        protected $db;
        protected $table;
        protected $primaryId = 'id';
        protected array $errors = [];

        public function __construct()
        {
            $this->db = new Database();
            if (!$this->db->isConnected()) {
                $this->errors[] = $this->db->getErrors()[0];
            }
        }

        public function find($id)
        {
            $this->db->prepare(
                sprintf('Select * FROM %s WHERE %s = ":id"', $this->table, $this->primaryId),
                ['id' => $id]
            );
            $this->db->exec();
            return $this;
        }
        public function getResults()
        {
            return $this->db->getRows();
        }

        public function save(array $data)
        {
        }
        public function findWhere($conditions = [])
        {
            $itemIndex = 0;
            $preparedConditions = [];
            foreach ($conditions as $key => $value) {
                if ($itemIndex == 0) {
                    $preparedConditions[]  = sprintf(' WHERE `%s`=\'%s\'', $key, $value);
                } else {
                    $preparedConditions[] = sprintf(' AND `%s`=\'%s\'', $key, $value);
                }
                $itemIndex++;
            }
            $this->db->prepare(
                sprintf('Select * FROM %s', $this->table, implode('', $preparedConditions))
            );
            $this->db->exec();
            return $this;
        }

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

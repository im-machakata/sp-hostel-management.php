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
                sprintf('Select * FROM %s WHERE %s = ":id" LIMIT 0,1', $this->table, $this->primaryId),
                ['id' => $id]
            );
            $this->db->exec();
            return $this;
        }
        public function getRow()
        {
            return $this->db->getRow();
        }
        public function getResults()
        {
            return $this->db->getRows();
        }

        public function save(array $data)
        {
            $keys_index = 0;
            $cols = $vals = [];
            foreach ($data as $col => $value) {
                $keys_index++;
                if ($col == $this->primaryId) continue;
                $last_col = $keys_index == count($data);
                $cols[] = sprintf("`%s%s`", $col, $last_col ? '' : ', ');
                $vals[] = sprintf(":%s%s", $value, $last_col ? '' : ', ');
            }

            // we are updatin the table
            if (array_key_exists($this->primaryId, $data)) {
                $this->db->prepare(sprintf('UPDATE %s SET %s WHERE %s = :id', $this->table, implode('', $cols), $this->primaryId), $vals);
            } else {
                $this->db->prepare(sprintf('INSERT INTO %s (%s) VALUES(%s)', $this->table, implode('', $cols), $this->primaryId), $vals);
            }
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
            $this->db->prepare(sprintf('SELECT * FROM %s %s', $this->table, implode('', $preparedConditions)));
            $this->db->exec();
            return $this;
        }

        public function hasErrors(): bool
        {
            return $this->errors ? true : false;
        }

        public function getFirstError()
        {
            return $this->errors[0];
        }
        /**
         * @return string|null
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

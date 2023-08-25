 <?php
    include_once __DIR__ . '/../config.php';
    include_once __DIR__ . '/../System/Database.php';

    class Model
    {
        protected $db;
        protected $table;
        protected $columns = [];
        protected $primaryId = 'id';
        protected array $errors = [];
        public $pagination = 1;

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
                sprintf("SELECT * FROM %s WHERE %s = :id LIMIT 0,1", $this->table, $this->primaryId),
                ['id' => $id]
            );
            $this->db->exec();
            return $this;
        }
        public function findAll()
        {
            $this->db->query(
                sprintf('SELECT * FROM %s LIMIT 0,10 ', $this->table, $this->pagination * 10)
            );
            return $this->getResults();
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
            $data_copy = $data;
            if (isset($data[$this->primaryId])) :
                unset($data_copy[$this->primaryId]);
            endif;
            $last_col = array_key_last($data_copy);

            foreach ($data as $col => $value) {
                $keys_index++;
                if ($col == $this->primaryId || !$value) continue;
                if (!array_key_exists($this->primaryId, $data)) :
                    $cols[] = sprintf("`%s`%s", $col, $last_col == $col ? '' : ', ');
                    $vals[] = sprintf(":%s%s", $col, $last_col == $col ? '' : ', ');
                    continue;
                endif;

                if ($this->columns && !in_array($col, $this->columns)) continue;
                $cols[] = " $col = :$col" . ($last_col == $col ? '' : ', ');
            }

            // hash password if necessary
            if (isset($data['password']) && $data['password']) $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            // check if we are updating the table
            if (array_key_exists($this->primaryId, $data)) {
                $this->db->prepare(sprintf('UPDATE %s SET %s WHERE %s = :id', $this->table, implode('', $cols), $this->primaryId), $data);
            } else {
                $this->db->prepare(sprintf('INSERT INTO %s (%s) VALUES(%s)', $this->table, implode('', $cols), implode('', $vals)), $data);
            }
            return $this->db->exec();
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

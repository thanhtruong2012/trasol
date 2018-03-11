<?php

ini_set('memory_limit', '6144M');
ini_set('max_execution_time', 60000);

class Database_Mysql_Driver {

    /**
     * Database configuration
     */
    protected $db_config;

    public function __construct($config) {
        $this->db_config = $config;
    }

    /**
     * Determines if the string has an arithmetic operator in it.
     *
     * @param   string   string to check
     * @return  boolean
     */
    public function has_operator($str) {
        return (bool) preg_match('/[<>!=]|\sIS(?:\s+NOT\s+)?\b|BETWEEN/i', trim($str));
    }

    /**
     * Builds a WHERE portion of a query.
     *
     * @param   mixed    key
     * @param   string   value
     * @param   string   type
     * @param   int      number of where clauses
     * @param   boolean  escape the value
     * @return  string
     */
    public function where($key, $value, $type, $num_wheres, $quote) {
        $prefix = ($num_wheres == 0) ? '' : $type;

        if ($quote === -1) {
            $value = '';
        } else {
            if ($value === NULL) {
                if (!$this->has_operator($key)) {
                    $key .= ' IS';
                }

                $value = ' NULL';
            } elseif (is_bool($value)) {
                if (!$this->has_operator($key)) {
                    $key .= ' =';
                }

                $value = ($value == TRUE) ? ' 1' : ' 0';
            } else {
                if (!$this->has_operator($key) AND ! empty($key)) {
                    $key = ((strpos($key, '.') !== FALSE) ? $this->escape_column($key) : $key) . ' =';
                } else {
                    preg_match('/^(.+?)([<>!=]+|\bIS(?:\s+NULL))\s*$/i', $key, $matches);
                    if (isset($matches[1]) AND isset($matches[2])) {
                        $key = $this->escape_column(trim($matches[1])) . ' ' . trim($matches[2]);
                    }
                }
                $value = ' ' . (($quote == TRUE) ? $this->escape($value) : $value);
            }
        }

        return $prefix . $key . $value;
    }

    public function compile_select($database) {

        $sql = ($database['distinct'] == TRUE) ? 'SELECT DISTINCT ' : 'SELECT ';
        $sql .= (count($database['select']) > 0) ? implode(', ', $database['select']) : '*';

        if (count($database['from']) > 0) {
            // Escape the tables
            $froms = array();
            foreach ($database['from'] as $from) {
                $froms[] = $this->escape_column($from);
            }
            $sql .= "\nFROM (";
            $sql .= implode(', ', $froms) . ")";
        }

        if (count($database['join']) > 0) {
            foreach ($database['join'] AS $join) {
                $sql .= "\n" . $join['type'] . 'JOIN ' . implode(', ', $join['tables']) . ' ON ' . $join['conditions'];
            }
        }

        if (count($database['where']) > 0) {
            $sql .= "\nWHERE ";
        }

        $sql .= implode("\n", $database['where']);

        if (count($database['groupby']) > 0) {
            $sql .= "\nGROUP BY ";
            $sql .= implode(', ', $database['groupby']);
        }

        if (count($database['having']) > 0) {
            $sql .= "\nHAVING ";
            $sql .= implode("\n", $database['having']);
        }

        if (count($database['orderby']) > 0) {
            $sql .= "\nORDER BY ";
            $sql .= implode(', ', $database['orderby']);
        }

        if (is_numeric($database['limit'])) {
            $sql .= "\n";
            $sql .= $this->limit($database['limit'], $database['offset']);
        }

        return $sql;
    }
    
    
    /**
     * Builds an INSERT query.
     *
     * @param   string  table name
     * @param   array   keys
     * @param   array   values
     * @return  string
     */
    public function insert($table, $keys, $values) {
        // Escape the column names
        foreach ($keys as $key => $value) {
            $keys[$key] = $this->escape_column($value);
        }
        return 'INSERT INTO ' . $this->escape_table($table) . ' (' . implode(', ', $keys) . ') VALUES (' . implode(', ', $values) . ')';
    }

    /**
     * Escapes any input value.
     *
     * @param   mixed   value to escape
     * @return  string
     */
    public function escape($value) {
        if (!$this->db_config['escape'])
            return $value;

        switch (gettype($value)) {
            case 'string':
                $value = '\'' . $this->escape_str($value) . '\'';
                break;
            case 'boolean':
                $value = (int) $value;
                break;
            case 'double':
                // Convert to non-locale aware float to prevent possible commas
                $value = sprintf('%F', $value);
                break;
            default:
                $value = ($value === NULL) ? 'NULL' : $value;
                break;
        }

        return (string) $value;
    }

    public function escape_table($table) {
        if (!$this->db_config['escape'])
            return $table;

        if (stripos($table, ' AS ') !== FALSE) {
            // Force 'AS' to uppercase
            $table = str_ireplace(' AS ', ' AS ', $table);

            // Runs escape_table on both sides of an AS statement
            $table = array_map(array($this, __FUNCTION__), explode(' AS ', $table));

            // Re-create the AS statement
            return implode(' AS ', $table);
        }
        return '`' . str_replace('.', '`.`', $table) . '`';
    }

    public function escape_column($column) {
        if (!$this->db_config['escape'])
            return $column;

        if ($column == '*')
            return $column;

        // This matches any functions we support to SELECT.
        if (preg_match('/(avg|count|sum|max|min)\(\s*(.*)\s*\)(\s*as\s*(.+)?)?/i', $column, $matches)) {
            if (count($matches) == 3) {
                return $matches[1] . '(' . $this->escape_column($matches[2]) . ')';
            } else if (count($matches) == 5) {
                return $matches[1] . '(' . $this->escape_column($matches[2]) . ') AS ' . $this->escape_column($matches[2]);
            }
        }

        // This matches any modifiers we support to SELECT.
        if (!preg_match('/\b(?:rand|all|distinct(?:row)?|high_priority|sql_(?:small_result|b(?:ig_result|uffer_result)|no_cache|ca(?:che|lc_found_rows)))\s/i', $column)) {
            if (stripos($column, ' AS ') !== FALSE) {
                // Force 'AS' to uppercase
                $column = str_ireplace(' AS ', ' AS ', $column);

                // Runs escape_column on both sides of an AS statement
                $column = array_map(array($this, __FUNCTION__), explode(' AS ', $column));

                // Re-create the AS statement
                return implode(' AS ', $column);
            }

            return preg_replace('/[^.*]+/', '`$0`', $column);
        }

        $parts = explode(' ', $column);
        $column = '';

        for ($i = 0, $c = count($parts); $i < $c; $i++) {
            // The column is always last
            if ($i == ($c - 1)) {
                $column .= preg_replace('/[^.*]+/', '`$0`', $parts[$i]);
            } else { // otherwise, it's a modifier
                $column .= $parts[$i] . ' ';
            }
        }
        return $column;
    }

    public function escape_str($str) {
        //if (!$this->db_config['escape'])
            return $str;
        //return mysql_real_escape_string($str);
        //is_resource($this->link) or $this->connect();
        //return mysql_real_escape_string($str, $this->link);
    }

    public function limit($limit, $offset = 0) {
        return 'LIMIT ' . $offset . ', ' . $limit;
    }

}

?>
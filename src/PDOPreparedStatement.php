<?php

/*
 * The MIT License
 *
 * Copyright 2015 Samy Naamani <samy@namani.net>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace SNDatabase\PDO;
use SNDatabase\PreparedStatement;
use SNDatabase\DB;

/**
 * Description of PDOPreparedStatement
 *
 * @author Samy Naamani <samy@namani.net>
 */
class PDOPreparedStatement extends PreparedStatement {
    /**
     *
     * @var \PDOStatement
     */
    private $stmt;
    public function __construct(PDOConnection $cnx, \PDOStatement $stmt) {
        parent::__construct($cnx);
        $this->stmt = $stmt;
    }
    protected function doBind() {
        foreach($this->getParameters() as $tag => $param) {
            $value = $this->connection->quote($param['param'], $param['type']);
            $type = ($param['type'] == DB::PARAM_AUTO) ? $this->connection->quotedType($param['param']) : $param['type'];
            switch($type) {
                case DB::PARAM_BOOL:
                    $type = \PDO::PARAM_BOOL;
                    break;
                case DB::PARAM_INT:
                    $type = \PDO::PARAM_INT;
                    break;
                case DB::PARAM_NULL:
                    $type = \PDO::PARAM_NULL;
                    break;
                default:
                    $type = \PDO::PARAM_STR;
                    $value = preg_replace("#^'(.*)'\$#s", '$1', $value);
            }
            $this->stmt->bindValue($tag, $value, $type);
        }
    }

    protected function doExecute() {
        return $this->stmt->execute();
    }

    protected function getAffectedRows() {
        return $this->stmt->rowCount();
    }

    public function getResultset() {
        return new PDOResult($this->connection, $this->stmt);
    }

}

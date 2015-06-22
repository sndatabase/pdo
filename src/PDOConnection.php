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
use SNDatabase\Connection;


/**
 * Description of PDOConnection
 *
 * @author Samy Naamani <samy@namani.net>
 */
abstract class PDOConnection extends Connection {
    /**
     *
     * @var \PDO
     */
    private $pdo;
    public function __construct(\PDO $pdo) {
        parent::__construct();
        $this->pdo = $pdo;
    }
    protected function escapeString($string) {
        return $this->pdo->quote($string);
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    public function prepare($statement) {

    }

    public function query($statement) {
        return new PDOResult($this, $this->pdo->query($statement));
    }
    
    public function exec($statement) {
        return $this->pdo->exec($statement);
    }

    public function startTransaction($name = null) {

    }

}

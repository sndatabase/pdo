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

    public function connect() {
        try {
            $this->pdo = new \PDO($this->getDSN(), parse_url($this->connectionString, PHP_URL_USER), parse_url($this->connectionString, PHP_URL_PASS), array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC));
        }
        catch(\PDOException $ex) {
            throw new \SNDatabase\ConnectionFailedException($ex->errorInfo[2], $ex->getCode(), $ex);
        }
    }

    /**
     * Build PDO DSN string from Connection String.
     * Driver-dependant.
     * @return string Built DSN
     */
    abstract protected function getDSN();
    
    protected function escapeString($string) {
        return $this->pdo->quote($string);
    }

    public function lastInsertId() {
        try {
            return $this->pdo->lastInsertId();
        }
        catch(\PDOException $ex) {
            throw new \SNDatabase\ConnectionFailedException($ex->errorInfo[2], $ex->getCode(), $ex);
        }
    }

    public function prepare($statement) {
        try {
            return new PDOPreparedStatement($this, $this->pdo->prepare($statement));
        }
        catch(\PDOException $ex) {
            throw new \SNDatabase\ConnectionFailedException($ex->errorInfo[2], $ex->getCode(), $ex);
        }
    }

    public function query($statement) {
        try {
            return new PDOResult($this, $this->pdo->query($statement));
        }
        catch(\PDOException $ex) {
            throw new \SNDatabase\ConnectionFailedException($ex->errorInfo[2], $ex->getCode(), $ex);
        }
    }
    
    public function exec($statement) {
        try {
            return $this->pdo->exec($statement);
        }
        catch(\PDOException $ex) {
            throw new \SNDatabase\ConnectionFailedException($ex->errorInfo[2], $ex->getCode(), $ex);
        }
    }
}

<?php
/* ===========================================================================
 * Opis Project
 * http://opis.io
 * ===========================================================================
 * Copyright 2013-2015 Marius Sarca
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================================ */

namespace Opis\Database\ORM;

use Opis\Database\Connection;
use Opis\Database\SQL\Delete;
use Opis\Database\SQL\SelectStatement;

class Select extends SelectStatement
{
    /** @var    bool */
    protected $locked = false;

    /**
     * @return  \Opis\Database\SQL\Compiler
     */
    public function getCompiler()
    {
        return $this->compiler;
    }

    /**
     * @return  bool
     */
    public function isLocked()
    {
        return $this->locked;
    }

    /**
     * @param   string|array    $tables
     *
     * @return  $this
     */
    public function from($tables)
    {
        if (!is_array($tables)) {
            $tables = array($tables);
        }

        $this->tables = $tables;
        return $this;
    }

    /**
     * @return  $this
     */
    public function lock()
    {
        $this->locked = true;
        return $this;
    }

    /**
     * @param   array   $columns    (optional)
     *
     * @return  $this
     */
    public function select($columns = array())
    {
        $this->sql = null;
        return parent::select($columns);
    }

    /**
     * @param   Connection  $connection
     *
     * @return  Delete
     */
    public function toDelete(Connection $connection)
    {
        return new Delete($connection, $this->compiler, $this->tables, $this->joins, $this->whereClause);
    }

    /**
     * @param   Connection  $connection
     *
     * @return  Update
     */
    public function toUpdate(Connection $connection)
    {
        return new Update($connection, $this->compiler, $this->tables, $this->joins, $this->whereClause);
    }
}

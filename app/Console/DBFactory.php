<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;
use PDOException;

class DatabaseCreateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'db:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command creates a new database';

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'db:create';

    /**
     * Execute the console command.
     */
    public function fire()
    {
        $host = config('mysql.connections.host');
        $host = config('mysql.connections.port');
        $database = config('mysql.connections.database');
        $username = config('mysql.connections.username');
        $password = config('mysql.connections.password');
        $charset = config('mysql.connections.charset');
        $collation = config('mysql.connections.collation');

        if (! $database) {
            $this->info('Skipping creation of database as env(DB_DATABASE) is empty');
            return;
        }

        try {
            $pdo = $this->getPDOConnection($host, $port, $username, $password);

            $pdo->exec(sprintf(
                'CREATE DATABASE IF NOT EXISTS %s CHARACTER SET %s COLLATE %s;',
                $database,
                $charset,
                $collation
            ));

            $this->info(sprintf('Successfully created %s database', $database));
        } catch (PDOException $exception) {
            $this->error(sprintf('Failed to create %s database, %s', $database, $exception->getMessage()));
        }
    }

    /**
     * @param  string $host
     * @param  integer $port
     * @param  string $username
     * @param  string $password
     * @return PDO
     */
    private function getPDOConnection($host, $port, $username, $password)
    {
        return new PDO(sprintf('mysql:host=%s;port=%d;', $host, $port), $username, $password);
    }
}
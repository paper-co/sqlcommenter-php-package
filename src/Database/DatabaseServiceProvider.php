<?php
/*
 * Copyright 2022 Google LLC

 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at

 * http:*www.apache.org/licenses/LICENSE-2.0

 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\GoogleSqlCommenterLaravel\Database;

use Illuminate\Support\ServiceProvider;
use PaperCo\Correlation\CorrelationManager;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {

        $correlationManager = $this->app->has(CorrelationManager::class)
            ? $this->app->make(CorrelationManager::class)
            : null;

        Connection::resolverFor('mysql', function ($connection, $database, $prefix, $config) use ($correlationManager) {
            return new MySqlConnection($connection, $database, $prefix, $config, $correlationManager);
        });

        Connection::resolverFor('pgsql', function ($connection, $database, $prefix, $config) use ($correlationManager) {
            return new PostgresConnection($connection, $database, $prefix, $config, $correlationManager);
        });

        Connection::resolverFor('sqlite', function ($connection, $database, $prefix, $config) use ($correlationManager) {
            return new SQLiteConnection($connection, $database, $prefix, $config, $correlationManager);
        });

        Connection::resolverFor('sqlsrv', function ($connection, $database, $prefix, $config) use($correlationManager) {
            return new SqlServerConnection($connection, $database, $prefix, $config, $correlationManager);
        });
    }
}

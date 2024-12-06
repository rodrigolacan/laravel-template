<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class DatabaseConnectionTest extends TestCase
{
    use RefreshDatabase;

    public function  testCanConnectToDatabase()
    {
        Log::info('Iniciando o teste de conexão com o banco de dados.');

        try {
            $result = DB::connection("sqlsrv")->select('SELECT 1 AS test');

            Log::info('Consulta executada com sucesso.');

            $this->assertNotEmpty($result);
        } catch (\Illuminate\Database\QueryException $e) {
            // Captura erros relacionados à consulta
            $this->fail('Erro na consulta ao banco de dados: ' . $e->getMessage());
        } catch (\PDOException $e) {
            // Captura erros de conexão ou falta de driver
            $this->fail('Erro de conexão com o banco de dados: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Captura outros erros inesperados
            $this->fail('Erro inesperado: ' . $e->getMessage());
        }
    }

    public function testCanConnectToPostgres()
    {
        Log::info('Iniciando o teste de conexão com o banco de dados PostgreSQL.');

        try {
            $result = DB::connection("pgsql")->select('SELECT 1 AS test');

            Log::info('Consulta ao PostgreSQL executada com sucesso.');

            $this->assertNotEmpty($result, 'O resultado da consulta ao PostgreSQL está vazio.');
        } catch (\Illuminate\Database\QueryException $e) {
            $this->fail('Erro na consulta ao banco de dados PostgreSQL: ' . $e->getMessage());
        } catch (\PDOException $e) {
            $this->fail('Erro de conexão com o banco de dados PostgreSQL: ' . $e->getMessage());
        } catch (\Exception $e) {
            $this->fail('Erro inesperado no banco de dados PostgreSQL: ' . $e->getMessage());
        }
    }
}

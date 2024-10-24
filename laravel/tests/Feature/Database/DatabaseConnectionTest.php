<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Importação correta do Log
use Tests\TestCase;

class DatabaseConnectionTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test] // Use o atributo Test
    public function it_can_connect_to_the_database()
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
}

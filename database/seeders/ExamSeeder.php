<?php

namespace Database\Seeders;

use App\Enums\ExamStatus;
use App\Models\Exam;
use App\Models\ExamCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $backendId = ExamCategory::where('slug', 'backend')->value('id');

        $exams = [
            [
                'name' => 'PHP Fundamentals',
                'slug' => 'php-fundamentals',
                'description' => 'Teste seus conhecimentos fundamentais em PHP com questões práticas e conceituais.',
                'exam_category_id' => $backendId,
                'status' => ExamStatus::Published,
                'questions' => $this->phpQuestions(),
            ],
            [
                'name' => 'Laravel Fundamentals',
                'slug' => 'laravel-fundamentals',
                'description' => 'Avalie sua compreensão dos conceitos essenciais do ecossistema Laravel.',
                'exam_category_id' => $backendId,
                'status' => ExamStatus::Published,
                'questions' => $this->laravelQuestions(),
            ],
        ];

        foreach ($exams as $exam) {
            Exam::create($exam);
        }
    }

    private function phpQuestions(): array
    {
        return [
            ['id' => 'q1', 'question' => 'Qual a função do operador === em PHP?', 'options' => ['A' => 'Comparação com coerção de tipos', 'B' => 'Comparação estrita', 'C' => 'Atribuição', 'D' => 'Negação'], 'correct_answer' => 'B'],
            ['id' => 'q2', 'question' => 'Como se declara uma constante em PHP?', 'options' => ['A' => 'const MINHA_CONSTANTE = 1;', 'B' => 'define("MINHA_CONSTANTE", 1);', 'C' => 'Ambas as opções estão corretas', 'D' => 'Nenhuma das anteriores'], 'correct_answer' => 'C'],
            ['id' => 'q3', 'question' => 'Qual superglobal é usada para capturar dados enviados via POST?', 'options' => ['A' => '$_GET', 'B' => '$_POST', 'C' => '$_REQUEST', 'D' => '$_SERVER'], 'correct_answer' => 'B'],
            ['id' => 'q4', 'question' => 'O que significa PSR no contexto PHP?', 'options' => ['A' => 'PHP Standard Recommendation', 'B' => 'PHP Server Request', 'C' => 'PHP Syntax Reference', 'D' => 'PHP Secure Resource'], 'correct_answer' => 'A'],
            ['id' => 'q5', 'question' => 'Qual função converte um array para JSON?', 'options' => ['A' => 'json_decode()', 'B' => 'json_encode()', 'C' => 'to_json()', 'D' => 'array_to_json()'], 'correct_answer' => 'B'],
            ['id' => 'q6', 'question' => 'Qual palavra-chave cria um objeto a partir de uma classe?', 'options' => ['A' => 'create', 'B' => 'new', 'C' => 'make', 'D' => 'instance'], 'correct_answer' => 'B'],
            ['id' => 'q7', 'question' => 'Qual o retorno de is_array([1,2,3])?', 'options' => ['A' => '1', 'B' => 'true', 'C' => '0', 'D' => 'false'], 'correct_answer' => 'B'],
            ['id' => 'q8', 'question' => 'Qual função remove espaços em branco do início e fim de uma string?', 'options' => ['A' => 'remove()', 'B' => 'strip()', 'C' => 'trim()', 'D' => 'clean()'], 'correct_answer' => 'C'],
            ['id' => 'q9', 'question' => 'Qual a versão mínima do PHP recomendada para novos projetos atualmente?', 'options' => ['A' => '7.0', 'B' => '7.4', 'C' => '8.1', 'D' => '8.4'], 'correct_answer' => 'C'],
            ['id' => 'q10', 'question' => 'O que o PDO fornece?', 'options' => ['A' => 'Acesso a bancos de dados', 'B' => 'Processamento de imagens', 'C' => 'Envio de e-mail', 'D' => 'Cache em memória'], 'correct_answer' => 'A'],
        ];
    }

    private function laravelQuestions(): array
    {
        return [
            ['id' => 'q1', 'question' => 'Qual comando cria um novo controller no Laravel?', 'options' => ['A' => 'php artisan make:controller', 'B' => 'php artisan create:controller', 'C' => 'php artisan generate:controller', 'D' => 'php artisan new:controller'], 'correct_answer' => 'A'],
            ['id' => 'q2', 'question' => 'O que significa Eloquent?', 'options' => ['A' => 'Template engine', 'B' => 'ORM', 'C' => 'Task runner', 'D' => 'Router'], 'correct_answer' => 'B'],
            ['id' => 'q3', 'question' => 'Qual é o nome padrão do arquivo de rotas web?', 'options' => ['A' => 'routes.php', 'B' => 'web.php', 'C' => 'routing.php', 'D' => 'http.php'], 'correct_answer' => 'B'],
            ['id' => 'q4', 'question' => 'Qual função gera URLs para rotas nomeadas?', 'options' => ['A' => 'url()', 'B' => 'route()', 'C' => 'path()', 'D' => 'link()'], 'correct_answer' => 'B'],
            ['id' => 'q5', 'question' => 'Qual diretório armazena as views?', 'options' => ['A' => 'resources/views', 'B' => 'views/', 'C' => 'app/Views', 'D' => 'public/views'], 'correct_answer' => 'A'],
            ['id' => 'q6', 'question' => 'Qual facade é usada para consultar o banco de forma query builder?', 'options' => ['A' => 'Auth', 'B' => 'DB', 'C' => 'Cache', 'D' => 'Route'], 'correct_answer' => 'B'],
            ['id' => 'q7', 'question' => 'Como se declara uma nova route do tipo GET?', 'options' => ['A' => 'Route::post()', 'B' => 'Route::get()', 'C' => 'Route::view()', 'D' => 'Route::page()'], 'correct_answer' => 'B'],
            ['id' => 'q8', 'question' => 'Qual é a extensão padrão das views Blade?', 'options' => ['A' => '.php', 'B' => '.blade', 'C' => '.blade.php', 'D' => '.html.php'], 'correct_answer' => 'C'],
            ['id' => 'q9', 'question' => 'Qual comando executa as migrations?', 'options' => ['A' => 'php artisan migrate', 'B' => 'php artisan db:migrate', 'C' => 'php artisan migrate:run', 'D' => 'php artisan schema:migrate'], 'correct_answer' => 'A'],
            ['id' => 'q10', 'question' => 'Qual componente é responsável pela autenticação padrão do Laravel?', 'options' => ['A' => 'Fortify', 'B' => 'Breeze', 'C' => 'Jetstream', 'D' => 'Todas podem ser usadas'], 'correct_answer' => 'D'],
        ];
    }
}

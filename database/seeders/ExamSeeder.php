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
        $categoryIds = ExamCategory::pluck('id', 'slug');

        $exams = [
            [
                'name' => 'PHP Fundamentals',
                'slug' => 'php-fundamentals',
                'description' => 'Teste seus conhecimentos fundamentais em PHP com questões práticas e conceituais.',
                'exam_category_id' => $categoryIds['backend'] ?? null,
                'status' => ExamStatus::Published,
                'questions' => $this->phpQuestions(),
            ],
            [
                'name' => 'Laravel Fundamentals',
                'slug' => 'laravel-fundamentals',
                'description' => 'Avalie sua compreensão dos conceitos essenciais do ecossistema Laravel.',
                'exam_category_id' => $categoryIds['backend'] ?? null,
                'status' => ExamStatus::Published,
                'questions' => $this->laravelQuestions(),
            ],
            [
                'name' => 'Node.js Essentials',
                'slug' => 'nodejs-essentials',
                'description' => 'Verifique seu domínio dos conceitos básicos de Node.js, módulos e programação assíncrona.',
                'exam_category_id' => $categoryIds['backend'] ?? null,
                'status' => ExamStatus::Published,
                'questions' => $this->nodeQuestions(),
            ],
            [
                'name' => 'JavaScript Fundamentals',
                'slug' => 'javascript-fundamentals',
                'description' => 'Questões essenciais sobre a linguagem JavaScript para o desenvolvimento web moderno.',
                'exam_category_id' => $categoryIds['frontend'] ?? null,
                'status' => ExamStatus::Published,
                'questions' => $this->javascriptQuestions(),
            ],
            [
                'name' => 'HTML & CSS Essentials',
                'slug' => 'html-css-essentials',
                'description' => 'Fundamentos de marcação semântica, seletores e layout com CSS.',
                'exam_category_id' => $categoryIds['frontend'] ?? null,
                'status' => ExamStatus::Published,
                'questions' => $this->htmlCssQuestions(),
            ],
            [
                'name' => 'SQL Fundamentals',
                'slug' => 'sql-fundamentals',
                'description' => 'Consultas, joins, agregações e os comandos essenciais de bancos de dados relacionais.',
                'exam_category_id' => $categoryIds['banco-de-dados'] ?? null,
                'status' => ExamStatus::Published,
                'questions' => $this->sqlQuestions(),
            ],
            [
                'name' => 'Docker Essentials',
                'slug' => 'docker-essentials',
                'description' => 'Containers, imagens, volumes e os comandos do dia a dia com Docker.',
                'exam_category_id' => $categoryIds['devops'] ?? null,
                'status' => ExamStatus::Published,
                'questions' => $this->dockerQuestions(),
            ],
            [
                'name' => 'Git na Prática',
                'slug' => 'git-na-pratica',
                'description' => 'Comandos essenciais de versionamento: commits, branches, merge e repositórios remotos.',
                'exam_category_id' => $categoryIds['devops'] ?? null,
                'status' => ExamStatus::Published,
                'questions' => $this->gitQuestions(),
            ],
            [
                'name' => 'AWS Cloud Foundations',
                'slug' => 'aws-cloud-foundations',
                'description' => 'Conceitos fundamentais de computação em nuvem e dos principais serviços da AWS.',
                'exam_category_id' => $categoryIds['cloud'] ?? null,
                'status' => ExamStatus::Published,
                'questions' => $this->awsQuestions(),
            ],
            [
                'name' => 'React Native Basics',
                'slug' => 'react-native-basics',
                'description' => 'Componentes, estilos e navegação no desenvolvimento mobile com React Native.',
                'exam_category_id' => $categoryIds['mobile'] ?? null,
                'status' => ExamStatus::Published,
                'questions' => $this->reactNativeQuestions(),
            ],
        ];

        foreach ($exams as $exam) {
            Exam::updateOrCreate(['slug' => $exam['slug']], $exam);
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
            ['id' => 'q5', 'question' => 'Qual diretório armazena as views?', 'options' => ['A' => 'resources/views', 'B' => 'views/', 'C' => 'app/Views/', 'D' => 'public/views'], 'correct_answer' => 'A'],
            ['id' => 'q6', 'question' => 'Qual facade é usada para consultar o banco de forma query builder?', 'options' => ['A' => 'Auth', 'B' => 'DB', 'C' => 'Cache', 'D' => 'Route'], 'correct_answer' => 'B'],
            ['id' => 'q7', 'question' => 'Como se declara uma nova route do tipo GET?', 'options' => ['A' => 'Route::post()', 'B' => 'Route::get()', 'C' => 'Route::view()', 'D' => 'Route::page()'], 'correct_answer' => 'B'],
            ['id' => 'q8', 'question' => 'Qual é a extensão padrão das views Blade?', 'options' => ['A' => '.php', 'B' => '.blade', 'C' => '.blade.php', 'D' => '.html.php'], 'correct_answer' => 'C'],
            ['id' => 'q9', 'question' => 'Qual comando executa as migrations?', 'options' => ['A' => 'php artisan migrate', 'B' => 'php artisan db:migrate', 'C' => 'php artisan migrate:run', 'D' => 'php artisan schema:migrate'], 'correct_answer' => 'A'],
            ['id' => 'q10', 'question' => 'Qual componente é responsável pela autenticação padrão do Laravel?', 'options' => ['A' => 'Fortify', 'B' => 'Breeze', 'C' => 'Jetstream', 'D' => 'Todas podem ser usadas'], 'correct_answer' => 'D'],
        ];
    }

    private function nodeQuestions(): array
    {
        return [
            ['id' => 'q1', 'question' => 'O que é o Node.js?', 'options' => ['A' => 'Um framework frontend', 'B' => 'Um runtime JavaScript baseado no motor V8', 'C' => 'Um banco de dados', 'D' => 'Uma linguagem de programação'], 'correct_answer' => 'B'],
            ['id' => 'q2', 'question' => 'Qual comando instala dependências listadas no package.json?', 'options' => ['A' => 'npm start', 'B' => 'npm run', 'C' => 'npm install', 'D' => 'npm init'], 'correct_answer' => 'C'],
            ['id' => 'q3', 'question' => 'Qual módulo nativo do Node.js é usado para manipular arquivos?', 'options' => ['A' => 'http', 'B' => 'path', 'C' => 'fs', 'D' => 'os'], 'correct_answer' => 'C'],
            ['id' => 'q4', 'question' => 'O que o event loop do Node.js permite?', 'options' => ['A' => 'Execução síncrona bloqueante', 'B' => 'Compilação de código C++', 'C' => 'Gerenciamento de threads', 'D' => 'Operações assíncronas não bloqueantes'], 'correct_answer' => 'D'],
            ['id' => 'q5', 'question' => 'Como se exporta um módulo em CommonJS?', 'options' => ['A' => 'export default', 'B' => 'module.exports', 'C' => 'export.module', 'D' => 'exports.default'], 'correct_answer' => 'B'],
            ['id' => 'q6', 'question' => 'Qual comando inicializa um novo projeto Node.js?', 'options' => ['A' => 'npm init', 'B' => 'node init', 'C' => 'npm start', 'D' => 'node new'], 'correct_answer' => 'A'],
            ['id' => 'q7', 'question' => 'O que é o npm?', 'options' => ['A' => 'Um servidor web', 'B' => 'Um compilador JavaScript', 'C' => 'Um gerenciador de pacotes', 'D' => 'Um framework de testes'], 'correct_answer' => 'C'],
            ['id' => 'q8', 'question' => 'Qual método é usado para ler variáveis de ambiente em Node.js?', 'options' => ['A' => 'process.env', 'B' => 'env.get()', 'C' => 'process.getenv()', 'D' => 'os.environ'], 'correct_answer' => 'A'],
            ['id' => 'q9', 'question' => 'O que a função setTimeout faz?', 'options' => ['A' => 'Executa código imediatamente', 'B' => 'Agenda a execução de código após um intervalo', 'C' => 'Pausa o event loop', 'D' => 'Cria uma nova thread'], 'correct_answer' => 'B'],
            ['id' => 'q10', 'question' => 'Qual módulo nativo cria um servidor HTTP?', 'options' => ['A' => 'server', 'B' => 'net', 'C' => 'web', 'D' => 'http'], 'correct_answer' => 'D'],
        ];
    }

    private function javascriptQuestions(): array
    {
        return [
            ['id' => 'q1', 'question' => 'Qual palavra-chave declara uma variável com escopo de bloco que pode ser reatribuída?', 'options' => ['A' => 'var', 'B' => 'let', 'C' => 'const', 'D' => 'global'], 'correct_answer' => 'B'],
            ['id' => 'q2', 'question' => 'O que Array.prototype.map() retorna?', 'options' => ['A' => 'O array original modificado', 'B' => 'Um novo array com os elementos transformados', 'C' => 'O primeiro elemento do array', 'D' => 'Um objeto'], 'correct_answer' => 'B'],
            ['id' => 'q3', 'question' => 'Qual método converte uma string JSON em objeto JavaScript?', 'options' => ['A' => 'JSON.stringify()', 'B' => 'JSON.toObject()', 'C' => 'JSON.parse()', 'D' => 'JSON.decode()'], 'correct_answer' => 'C'],
            ['id' => 'q4', 'question' => 'Qual o resultado de typeof null?', 'options' => ['A' => '"null"', 'B' => '"undefined"', 'C' => '"number"', 'D' => '"object"'], 'correct_answer' => 'D'],
            ['id' => 'q5', 'question' => 'O que é um closure?', 'options' => ['A' => 'Uma função que lembra do escopo onde foi criada', 'B' => 'Um loop infinito', 'C' => 'Um tipo de variável global', 'D' => 'Um erro de sintaxe'], 'correct_answer' => 'A'],
            ['id' => 'q6', 'question' => 'Qual método adiciona um elemento ao final de um array?', 'options' => ['A' => 'shift()', 'B' => 'unshift()', 'C' => 'push()', 'D' => 'pop()'], 'correct_answer' => 'C'],
            ['id' => 'q7', 'question' => 'Qual a diferença entre == e ===?', 'options' => ['A' => 'Não há diferença', 'B' => '=== compara valor e tipo, == faz coerção de tipos', 'C' => '== é mais estrito que ===', 'D' => '=== só funciona com números'], 'correct_answer' => 'B'],
            ['id' => 'q8', 'question' => 'O que acontece ao reatribuir uma variável declarada com const?', 'options' => ['A' => 'A reatribuição é ignorada silenciosamente', 'B' => 'Um TypeError é lançado', 'C' => 'A variável vira undefined', 'D' => 'Ela é convertida em var'], 'correct_answer' => 'B'],
            ['id' => 'q9', 'question' => 'Qual método remove o último elemento de um array?', 'options' => ['A' => 'pop()', 'B' => 'push()', 'C' => 'shift()', 'D' => 'slice()'], 'correct_answer' => 'A'],
            ['id' => 'q10', 'question' => 'Template literals em JavaScript usam qual caractere?', 'options' => ['A' => 'Aspas simples', 'B' => 'Aspas duplas', 'C' => 'Crase (backtick)', 'D' => 'Parênteses'], 'correct_answer' => 'C'],
        ];
    }

    private function htmlCssQuestions(): array
    {
        return [
            ['id' => 'q1', 'question' => 'Qual tag HTML semântica representa o conteúdo principal da página?', 'options' => ['A' => '<body>', 'B' => '<main>', 'C' => '<section>', 'D' => '<content>'], 'correct_answer' => 'B'],
            ['id' => 'q2', 'question' => 'Qual propriedade CSS altera a cor do texto?', 'options' => ['A' => 'text-color', 'B' => 'font-color', 'C' => 'color', 'D' => 'text-style'], 'correct_answer' => 'C'],
            ['id' => 'q3', 'question' => 'Para que serve display: flex?', 'options' => ['A' => 'Criar layouts flexíveis em uma dimensão', 'B' => 'Ocultar elementos', 'C' => 'Aplicar animações', 'D' => 'Fixar elementos na tela'], 'correct_answer' => 'A'],
            ['id' => 'q4', 'question' => 'Qual tag cria um hyperlink?', 'options' => ['A' => '<link>', 'B' => '<href>', 'C' => '<url>', 'D' => '<a>'], 'correct_answer' => 'D'],
            ['id' => 'q5', 'question' => 'Qual unidade CSS é relativa ao tamanho da fonte do elemento raiz?', 'options' => ['A' => 'em', 'B' => 'rem', 'C' => 'px', 'D' => 'vh'], 'correct_answer' => 'B'],
            ['id' => 'q6', 'question' => 'Qual seletor CSS tem maior especificidade?', 'options' => ['A' => 'Classe (.item)', 'B' => 'Elemento (div)', 'C' => 'ID (#item)', 'D' => 'Pseudo-classe (:hover)'], 'correct_answer' => 'C'],
            ['id' => 'q7', 'question' => 'Para que serve o atributo alt em uma tag <img>?', 'options' => ['A' => 'Definir o tamanho da imagem', 'B' => 'Texto alternativo para acessibilidade', 'C' => 'Legenda exibida abaixo da imagem', 'D' => 'Link da imagem'], 'correct_answer' => 'B'],
            ['id' => 'q8', 'question' => 'Um elemento com position: absolute é posicionado em relação a quê?', 'options' => ['A' => 'Sempre à janela do navegador', 'B' => 'Ao elemento pai imediato', 'C' => 'Ao ancestral posicionado mais próximo', 'D' => 'Ao centro da página'], 'correct_answer' => 'C'],
            ['id' => 'q9', 'question' => 'Qual pseudo-classe aplica estilos quando o mouse está sobre o elemento?', 'options' => ['A' => ':active', 'B' => ':focus', 'C' => ':visited', 'D' => ':hover'], 'correct_answer' => 'D'],
            ['id' => 'q10', 'question' => 'Qual tag cria uma lista não ordenada?', 'options' => ['A' => '<ol>', 'B' => '<ul>', 'C' => '<li>', 'D' => '<list>'], 'correct_answer' => 'B'],
        ];
    }

    private function sqlQuestions(): array
    {
        return [
            ['id' => 'q1', 'question' => 'Qual comando SQL é usado para consultar dados?', 'options' => ['A' => 'SELECT', 'B' => 'GET', 'C' => 'FETCH', 'D' => 'QUERY'], 'correct_answer' => 'A'],
            ['id' => 'q2', 'question' => 'Qual cláusula filtra linhas em uma consulta?', 'options' => ['A' => 'FILTER', 'B' => 'HAVING', 'C' => 'WHERE', 'D' => 'LIMIT'], 'correct_answer' => 'C'],
            ['id' => 'q3', 'question' => 'Qual JOIN retorna apenas as linhas com correspondência nas duas tabelas?', 'options' => ['A' => 'LEFT JOIN', 'B' => 'INNER JOIN', 'C' => 'FULL JOIN', 'D' => 'CROSS JOIN'], 'correct_answer' => 'B'],
            ['id' => 'q4', 'question' => 'Qual função retorna o número de linhas de um resultado?', 'options' => ['A' => 'SUM()', 'B' => 'TOTAL()', 'C' => 'ROWS()', 'D' => 'COUNT()'], 'correct_answer' => 'D'],
            ['id' => 'q5', 'question' => 'Qual cláusula agrupa linhas para funções de agregação?', 'options' => ['A' => 'GROUP BY', 'B' => 'ORDER BY', 'C' => 'CLUSTER BY', 'D' => 'AGGREGATE BY'], 'correct_answer' => 'A'],
            ['id' => 'q6', 'question' => 'Qual comando insere novos registros em uma tabela?', 'options' => ['A' => 'ADD', 'B' => 'INSERT', 'C' => 'CREATE', 'D' => 'APPEND'], 'correct_answer' => 'B'],
            ['id' => 'q7', 'question' => 'Qual cláusula filtra grupos após a agregação?', 'options' => ['A' => 'WHERE', 'B' => 'FILTER', 'C' => 'HAVING', 'D' => 'GROUP WHERE'], 'correct_answer' => 'C'],
            ['id' => 'q8', 'question' => 'O que é uma PRIMARY KEY?', 'options' => ['A' => 'Uma coluna que aceita valores duplicados', 'B' => 'Um índice secundário', 'C' => 'Uma senha da tabela', 'D' => 'Um identificador único de cada linha'], 'correct_answer' => 'D'],
            ['id' => 'q9', 'question' => 'Qual comando remove uma tabela inteira do banco?', 'options' => ['A' => 'DELETE TABLE', 'B' => 'DROP TABLE', 'C' => 'REMOVE TABLE', 'D' => 'TRUNCATE ROWS'], 'correct_answer' => 'B'],
            ['id' => 'q10', 'question' => 'Qual cláusula ordena o resultado de uma consulta?', 'options' => ['A' => 'SORT BY', 'B' => 'GROUP BY', 'C' => 'ORDER BY', 'D' => 'ARRANGE BY'], 'correct_answer' => 'C'],
        ];
    }

    private function dockerQuestions(): array
    {
        return [
            ['id' => 'q1', 'question' => 'Qual arquivo define como uma imagem Docker é construída?', 'options' => ['A' => 'docker-compose.yml', 'B' => 'Dockerfile', 'C' => 'image.yml', 'D' => 'container.json'], 'correct_answer' => 'B'],
            ['id' => 'q2', 'question' => 'Qual comando constrói uma imagem a partir de um Dockerfile?', 'options' => ['A' => 'docker create', 'B' => 'docker make', 'C' => 'docker build', 'D' => 'docker image new'], 'correct_answer' => 'C'],
            ['id' => 'q3', 'question' => 'Qual comando lista os containers em execução?', 'options' => ['A' => 'docker ps', 'B' => 'docker list', 'C' => 'docker containers', 'D' => 'docker status'], 'correct_answer' => 'A'],
            ['id' => 'q4', 'question' => 'Qual a diferença entre imagem e container?', 'options' => ['A' => 'São sinônimos', 'B' => 'Imagem é o template; container é a instância em execução', 'C' => 'Container é o template; imagem é a instância', 'D' => 'Imagem só existe no Docker Hub'], 'correct_answer' => 'B'],
            ['id' => 'q5', 'question' => 'Qual comando cria e inicia um container?', 'options' => ['A' => 'docker start', 'B' => 'docker create', 'C' => 'docker up', 'D' => 'docker run'], 'correct_answer' => 'D'],
            ['id' => 'q6', 'question' => 'Para que serve o docker-compose.yml?', 'options' => ['A' => 'Definir e orquestrar múltiplos containers', 'B' => 'Compilar código fonte', 'C' => 'Fazer backup de imagens', 'D' => 'Monitorar logs'], 'correct_answer' => 'A'],
            ['id' => 'q7', 'question' => 'Qual flag do docker run mapeia portas entre host e container?', 'options' => ['A' => '-v', 'B' => '-p', 'C' => '-e', 'D' => '-m'], 'correct_answer' => 'B'],
            ['id' => 'q8', 'question' => 'Qual comando exibe os logs de um container?', 'options' => ['A' => 'docker show', 'B' => 'docker tail', 'C' => 'docker logs', 'D' => 'docker output'], 'correct_answer' => 'C'],
            ['id' => 'q9', 'question' => 'Onde ficam hospedadas as imagens públicas do Docker?', 'options' => ['A' => 'Docker Hub', 'B' => 'GitHub Packages', 'C' => 'npm Registry', 'D' => 'Docker Store'], 'correct_answer' => 'A'],
            ['id' => 'q10', 'question' => 'Para que serve um volume no Docker?', 'options' => ['A' => 'Aumentar a memória do container', 'B' => 'Persistir dados fora do ciclo de vida do container', 'C' => 'Compartilhar portas de rede', 'D' => 'Compactar imagens'], 'correct_answer' => 'B'],
        ];
    }

    private function gitQuestions(): array
    {
        return [
            ['id' => 'q1', 'question' => 'Qual comando cria um novo repositório Git local?', 'options' => ['A' => 'git new', 'B' => 'git create', 'C' => 'git init', 'D' => 'git start'], 'correct_answer' => 'C'],
            ['id' => 'q2', 'question' => 'Qual comando adiciona arquivos à área de staging?', 'options' => ['A' => 'git add', 'B' => 'git stage', 'C' => 'git commit', 'D' => 'git push'], 'correct_answer' => 'A'],
            ['id' => 'q3', 'question' => 'Qual comando exibe o histórico de commits?', 'options' => ['A' => 'git history', 'B' => 'git log', 'C' => 'git show', 'D' => 'git commits'], 'correct_answer' => 'B'],
            ['id' => 'q4', 'question' => 'Qual comando cria uma nova branch?', 'options' => ['A' => 'git branch <nome>', 'B' => 'git new-branch <nome>', 'C' => 'git create <nome>', 'D' => 'git checkout <nome>'], 'correct_answer' => 'A'],
            ['id' => 'q5', 'question' => 'Qual comando envia commits locais para o repositório remoto?', 'options' => ['A' => 'git upload', 'B' => 'git send', 'C' => 'git sync', 'D' => 'git push'], 'correct_answer' => 'D'],
            ['id' => 'q6', 'question' => 'Qual comando baixa e integra mudanças do remoto na branch atual?', 'options' => ['A' => 'git fetch-all', 'B' => 'git pull', 'C' => 'git download', 'D' => 'git merge-remote'], 'correct_answer' => 'B'],
            ['id' => 'q7', 'question' => 'Qual comando mostra o estado atual dos arquivos (modificados, staged etc.)?', 'options' => ['A' => 'git state', 'B' => 'git diff', 'C' => 'git status', 'D' => 'git info'], 'correct_answer' => 'C'],
            ['id' => 'q8', 'question' => 'O que o comando git merge faz?', 'options' => ['A' => 'Apaga uma branch', 'B' => 'Combina o histórico de duas branches', 'C' => 'Compacta o repositório', 'D' => 'Envia alterações ao remoto'], 'correct_answer' => 'B'],
            ['id' => 'q9', 'question' => 'Para que serve o arquivo .gitignore?', 'options' => ['A' => 'Listar arquivos que o Git deve ignorar', 'B' => 'Configurar credenciais', 'C' => 'Definir branches protegidas', 'D' => 'Armazenar aliases de comandos'], 'correct_answer' => 'A'],
            ['id' => 'q10', 'question' => 'Qual comando cria uma cópia local de um repositório remoto?', 'options' => ['A' => 'git copy', 'B' => 'git download', 'C' => 'git fork', 'D' => 'git clone'], 'correct_answer' => 'D'],
        ];
    }

    private function awsQuestions(): array
    {
        return [
            ['id' => 'q1', 'question' => 'Qual serviço da AWS fornece servidores virtuais sob demanda?', 'options' => ['A' => 'S3', 'B' => 'EC2', 'C' => 'RDS', 'D' => 'Lambda'], 'correct_answer' => 'B'],
            ['id' => 'q2', 'question' => 'Qual serviço da AWS é usado para armazenamento de objetos?', 'options' => ['A' => 'EBS', 'B' => 'EFS', 'C' => 'S3', 'D' => 'Glacier DB'], 'correct_answer' => 'C'],
            ['id' => 'q3', 'question' => 'Qual serviço oferece bancos de dados relacionais gerenciados?', 'options' => ['A' => 'DynamoDB', 'B' => 'ElastiCache', 'C' => 'Redshift', 'D' => 'RDS'], 'correct_answer' => 'D'],
            ['id' => 'q4', 'question' => 'Qual serviço executa código sem provisionar servidores (serverless)?', 'options' => ['A' => 'Lambda', 'B' => 'EC2', 'C' => 'ECS', 'D' => 'Beanstalk'], 'correct_answer' => 'A'],
            ['id' => 'q5', 'question' => 'Qual é a CDN (rede de distribuição de conteúdo) da AWS?', 'options' => ['A' => 'Route 53', 'B' => 'CloudFront', 'C' => 'API Gateway', 'D' => 'Direct Connect'], 'correct_answer' => 'B'],
            ['id' => 'q6', 'question' => 'O que é o modelo de responsabilidade compartilhada da AWS?', 'options' => ['A' => 'A AWS é responsável por tudo', 'B' => 'O cliente é responsável por tudo', 'C' => 'A AWS cuida da infraestrutura; o cliente, dos dados e configurações', 'D' => 'Responsabilidade dividida entre clientes'], 'correct_answer' => 'C'],
            ['id' => 'q7', 'question' => 'O que é uma região (Region) na AWS?', 'options' => ['A' => 'Um único data center', 'B' => 'Um provedor de internet', 'C' => 'Uma zona de cache', 'D' => 'Uma área geográfica com múltiplas zonas de disponibilidade'], 'correct_answer' => 'D'],
            ['id' => 'q8', 'question' => 'Para que serve o IAM?', 'options' => ['A' => 'Gerenciar identidades, usuários e permissões', 'B' => 'Monitorar custos', 'C' => 'Criar máquinas virtuais', 'D' => 'Hospedar sites estáticos'], 'correct_answer' => 'A'],
            ['id' => 'q9', 'question' => 'Qual serviço da AWS fornece DNS?', 'options' => ['A' => 'CloudFront', 'B' => 'VPC', 'C' => 'Route 53', 'D' => 'SNS'], 'correct_answer' => 'C'],
            ['id' => 'q10', 'question' => 'Como funciona o modelo de cobrança padrão da AWS?', 'options' => ['A' => 'Licença anual fixa', 'B' => 'Pagamento conforme o uso (pay-as-you-go)', 'C' => 'Assinatura mensal obrigatória', 'D' => 'Cobrança por usuário ativo'], 'correct_answer' => 'B'],
        ];
    }

    private function reactNativeQuestions(): array
    {
        return [
            ['id' => 'q1', 'question' => 'Qual componente exibe texto em React Native?', 'options' => ['A' => '<p>', 'B' => '<Text>', 'C' => '<Label>', 'D' => '<span>'], 'correct_answer' => 'B'],
            ['id' => 'q2', 'question' => 'Qual componente funciona como container de layout, similar a uma <div>?', 'options' => ['A' => '<Container>', 'B' => '<Div>', 'C' => '<View>', 'D' => '<Box>'], 'correct_answer' => 'C'],
            ['id' => 'q3', 'question' => 'Como são definidos estilos em React Native?', 'options' => ['A' => 'Arquivos CSS externos', 'B' => 'Objetos JavaScript (ex.: StyleSheet)', 'C' => 'Atributos style em HTML', 'D' => 'Arquivos XML'], 'correct_answer' => 'B'],
            ['id' => 'q4', 'question' => 'Qual hook gerencia estado local em um componente funcional?', 'options' => ['A' => 'useEffect', 'B' => 'useContext', 'C' => 'useReducer', 'D' => 'useState'], 'correct_answer' => 'D'],
            ['id' => 'q5', 'question' => 'Qual componente renderiza listas grandes com performance otimizada?', 'options' => ['A' => 'FlatList', 'B' => 'ScrollView', 'C' => 'ListView', 'D' => 'ForEach'], 'correct_answer' => 'A'],
            ['id' => 'q6', 'question' => 'Qual biblioteca é a mais usada para navegação em React Native?', 'options' => ['A' => 'React Router DOM', 'B' => 'React Navigation', 'C' => 'Next Router', 'D' => 'Navigator.js'], 'correct_answer' => 'B'],
            ['id' => 'q7', 'question' => 'Quais plataformas o React Native tem como alvo principal?', 'options' => ['A' => 'Apenas iOS', 'B' => 'Apenas Android', 'C' => 'iOS e Android', 'D' => 'Somente web'], 'correct_answer' => 'C'],
            ['id' => 'q8', 'question' => 'Qual componente captura entrada de texto do usuário?', 'options' => ['A' => '<Input>', 'B' => '<TextField>', 'C' => '<TextInput>', 'D' => '<EditText>'], 'correct_answer' => 'C'],
            ['id' => 'q9', 'question' => 'O que é o Fast Refresh no React Native?', 'options' => ['A' => 'Reinício completo do app', 'B' => 'Atualização quase instantânea da UI ao salvar alterações', 'C' => 'Limpeza de cache', 'D' => 'Recarregamento do dispositivo'], 'correct_answer' => 'B'],
            ['id' => 'q10', 'question' => 'Qual é o valor padrão de flexDirection no React Native?', 'options' => ['A' => 'row', 'B' => 'row-reverse', 'C' => 'column-reverse', 'D' => 'column'], 'correct_answer' => 'D'],
        ];
    }
}

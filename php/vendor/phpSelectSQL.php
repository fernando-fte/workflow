<?php

/*
*
* @access protect
* @copyright FERNANDO-FTE © 2014
* @author Fernando Truculo Evangelista
* @version 1.0
*
*/

# oculta erros do display
// ini_set("display_errors", 0);
// {"._.list":["table","where","return","regra"],"table":{"._.//":"Dados para tabela a ser selecionada","._.required":true,"._.type":["string"]},"where":{"._.//":"Campos vs valores dos campos da tabela","._.required":true,"._.type":["array"]},"return":{"._.//":"Campos a ser retornado, caso todos use um asterisco \"*\"","._.required":true,"._.type":["string","array"]},"regra":{"._.//":"Conjunto de regras para solicitação do sql","._.required":false,"._.type":["array"],"._.list":["order","limit"],"order":{"._.//":"Ordena as respostas recebidas a partir de array(\"to\", \"by\")","._.required":false,"._.type":["array"],"._.list":["to","by"],"to":{"._.//":"Define o campo a ser ordenado","._.required":false,"._.type":["string"]},"by":{"._.//":"Define a ordem ASC (crescente) ou DESC (decrecente)","._.required":false,"._.type":["string"]}},"limit":{"._.//":"Por default o limite é \"1\", para exibir todos defina como \"0\" ou o numero de respostas que deseja","._.required":false,"._.type":["integer"]}}}

# # # # # # # # # # #
# Função: solicita ao MySQL os valores conforme os parametros
function query($post, $print){

    # # # #
    # Inclui as informações de conexão do valor
    include '.account.php';
    # Inclui as informações de conexão do valor
    # # # #

    # # # # #
    # validação para configurações de conexão externas

    # caso exista connect em @post
    if (array_key_exists('connect', $post)) {

        # valida se existe @post>connect>host
        if (array_key_exists('host', $post['connect'])) {

            # valida se @post>connect>host não é vazio
            if ($post['connect']['host'] != '') {

                # define em @connect>host o valor vindo de @post>connect>host 
                $connect['host'] = $post['connect']['host'];


                # adiciona em @return>warning>[@~length]>type o um relato do que houve
                $return['warning'][$return['warning']['length']]['type'] = 'O parametro de conexão de banco de dados, para "host" foi definido manualmente';

                # adiciona +1 em $return>error>length
                $return['warning']['length']++;
            }

            # valida se @post>connect>host é vazio
            if ($post['connect']['host'] != '') {

                # define em @connect>host o valor default como "localhost"
                $connect['host'] = 'localhost';


                # adiciona em @return>warning>[@~length]>type o um relato do que houve
                $return['warning'][$return['warning']['length']]['type'] = 'Foi definido manualmente o parametro de conexão de banco de dados, para "host", porem nada foi encontrado, assim foi definido um valor "default"';

                # adiciona +1 em $return>error>length
                $return['warning']['length']++;
            }

            # adiciona warning para a conexão host como validada por @post
        }

        # valida se existe @post>connect>user
        if (array_key_exists('user', $post['connect'])) {

            # valida se @post>connect>user não é vazio
            if ($post['connect']['user'] != '') {

                # define em @connect>user o valor vindo de @post>connect>user 
                $connect['user'] = $post['connect']['user'];


                # adiciona em @return>warning>[@~length]>type o um relato do que houve
                $return['warning'][$return['warning']['length']]['type'] = 'O parametro de conexão de banco de dados, para "user" foi definido manualmente';

                # adiciona +1 em $return>error>length
                $return['warning']['length']++;
            }

            # valida se @post>connect>user é vazio
            if ($post['connect']['user'] != '') {

                # define em @connect>user o valor default como "localuser"
                $connect['user'] = 'root';


                # adiciona em @return>warning>[@~length]>type o um relato do que houve
                $return['warning'][$return['warning']['length']]['type'] = 'Foi definido manualmente o parametro de conexão de banco de dados, para "user", porem nada foi encontrado, assim foi definido um valor "default"';

                # adiciona +1 em $return>error>length
                $return['warning']['length']++;
            }

            # adiciona warning para a conexão user como validada por @post
        }

        # valida se existe @post>connect>pasword
        if (array_key_exists('pasword', $post['connect'])) {

            # define em @connect>pasword o valor vindo de @post>connect>pasword 
            $connect['pasword'] = $post['connect']['pasword'];


            # adiciona em @return>warning>[@~length]>type o um relato do que houve
            $return['warning'][$return['warning']['length']]['type'] = 'O parametro de conexão de banco de dados, para "password" foi definido manualmente';

            # adiciona +1 em $return>error>length
            $return['warning']['length']++;
        }

        # valida se existe @post>connect>database
        if (array_key_exists('database', $post['connect'])) {

            # valida se @post>connect>database não é vazio
            if ($post['connect']['database'] != '') {

                # define em @connect>database o valor vindo de @post>connect>database 
                $connect['database'] = $post['connect']['database'];


                # adiciona em @return>warning>[@~length]>type o um relato do que houve
                $return['warning'][$return['warning']['length']]['type'] = 'O parametro de conexão de banco de dados, para "databased" foi definido manualmente';

                # adiciona +1 em $return>error>length
                $return['warning']['length']++;
            }

            # valida se @post>connect>database é vazio
            if ($post['connect']['database'] = '') {

                # adiciona em @return>error>[@~length]>type o um relato do que houve
                $return['error'][$return['error']['length']]['type'] = 'Não foi definido nem um banco de dados na solicitação manual';

                # adiciona +1 em $return>error>length
                $return['error']['length']++;
            }
        }
    }

    # validação para configurações de conexão externas
    # # # # #


    # # # # #
    # # configura os valores de retorno

    # adiciona em @return>success com true, para iniciar as validações
    $return['success'] = true;

    # adiciona em @return>error>length o valor 0
    $return['error']['length'] = 0;

    # adiciona em @return>warning>length o valor 0
    $return['warning']['length'] = 0;

    # adiciona em @return>backup os valores de @post
    $return['backup'] = $post;

    # define @return>process

    # # configura os valores de retorno
    # # # # #


    # # # # #
    # # inicia capturação dos dados no banco
    
    # valida se não existe type em @post, identificando qual o tipo de solicitação
    if (!array_key_exists('type', $post)) {

        # adiciona em @return>error>[@~length]>type o um relato do que houve
        $return['error'][$return['error']['length']]['type'] = 'Não existe o type declarado, dessa forma não sera possivel preparar os valores para seleção do banco';

        # adiciona +1 em $return>error>length
        $return['error']['length']++;
    }

    # valida se existe type em @post, identificando qual o tipo de solicitação
    if (array_key_exists('type', $post)) {

        # caso @post>type seja do tipo "query", inicia as seleções
        if ($post['type'] == 'query') {

            # adiciona em @temp>connect>mysql os dados de conexão do servidor MySQL
            $temp['connect']['mysql'] = mysql_connect($connect['host'], $connect['user'], $connect['pasword']);

            # valida se @temp>connect>msyql não estabeleceu conexão
            if (mysql_error() != false) {

                # adiciona em @return>error>[@~length]>type o um relato do que houve
                $return['error'][$return['error']['length']]['type'] = 'Não foi possivel connectar ao MySQL, verifique os dados de conexão';

                # adiciona +1 em $return>error>length
                $return['error']['length']++;
            }

            # valida se @temp>connect>msyql estabeleceu conexão
            if (mysql_error() == false) {

                # adiciona em @temp>connect>banco a conxão com o banco
                $temp['connect']['banco'] = mysql_select_db($connect['database'], $temp['connect']['mysql']);

                # valida se @temp>connect>banco não foi conectado ou encontrado
                if (mysql_error() != false) {

                    # adiciona em @return>error>[@~length]>type o um relato do que houve
                    $return['error'][$return['error']['length']]['type'] = 'Não foi possivel conectar-se ao banco, verifique os dados de conexão';

                    # adiciona +1 em $return>error>length
                    $return['error']['length']++;
                }

                # valida se @temp>connect>banco foi conectado ou encontrado
                if (mysql_error() == false) {

                    # adiciona em query os valores para a função mysql_query()
                    mysql_query("SET NAMES 'utf8'");
                    mysql_query('SET character_set_connection=utf8');
                    mysql_query('SET character_set_client=utf8');
                    mysql_query('SET character_set_results=utf8');

                    # adiciona em @temp>connect>result o resultado da insersão dos paramestros no banco
                    $temp['connect']['result'] = mysql_query($post['sql']);
                    // $temp['connect']['result'] = mysql_query("SELECT `sku`, `values` FROM `tabela` WHERE `segmento` LIKE 'page' ORDER BY `index` ASC LIMIT 2");
                    // $temp['connect']['result'] = mysql_query("INSERT INTO `tabela` (`segmento`, `index`, `grupo`, `type`, `values`, `sku`) VALUES ('teste', '1', NULL, NULL, 't', '58f2f5cf4a')");
                    // $temp['connect']['result'] = mysql_query("DELETE FROM `tabela` WHERE `sku` LIKE '58f2f5cf4a'");
                    // $temp['connect']['result'] = mysql_query("UPDATE `tabela` SET `grupo` = 'b', `type` = 'b' WHERE `sku` = '58f2f5cf4a' LIMIT 1");


                    # valida se @temp>connect>result não conseguiu ser executado
                    if (mysql_error() != false) {

                        # adiciona em @return>error>[@~length]>type o um relato do que houve
                        $return['error'][$return['error']['length']]['type'] = 'Algo de inesperado aconteceu, verifique as informações em erro->log';

                        # adiciona em @return>error>[@~length]>log o erro da função mysql_error()
                        $return['error'][$return['error']['length']]['log'] = mysql_error();

                        # adiciona +1 em $return>error>length
                        $return['error']['length']++;
                    }

                    # valida se @temp>connect>result conseguiu ser executado
                    if (mysql_error() == false) {
                        # adiciona em @retrun>result o resultado de @temp>connect>result
                        $return['result'] = $temp['connect']['result'];

                        # verifica se existe algum valor retornado para insert
                        if (mysql_insert_id()) {

                            # define @reurn>result com o id da inserção em auto increment
                            $return['result'] = mysql_insert_id();
                        }
                    }
                }

                # adiciona em @temp>connect>close o fechamento da conexão com MySQL
                $temp['connect']['close'] = mysql_close($temp['connect']['mysql']);
            }
        }

        # caso @post>type não seja do tipo "query", reeencaminha as validações conforme os atributos corretos
        if (!$post['type'] == 'query') {

            # encaminhas valores conforme as funções de chamada
            switch ($post['type']) {

                # caso @post>type seja "select"
                case 'select':

                    # adiciona em @return os valores de resposta vindos da função select()
                    $return = select($post, false);
                    break;

                # caso @post>type seja "insert"
                case 'insert':

                    # adiciona em @return os valores de resposta vindos da função insert()
                    $return = insert($post, false);
                    break;

                # caso @post>type seja "update"
                case 'update':

                    # adiciona em @return os valores de resposta vindos da função update()
                    $return = update($post, false);
                    break;
                
                default:

                    # adiciona em @return>error>[@~length]>type o um relato do que houve
                    $return['error'][$return['error']['length']]['type'] = 'O valor declarado em type não coincide com nem uma ação definida, podendo ser ("query", "insert", "update", "select")';

                    # adiciona +1 em $return>error>length
                    $return['error']['length']++;
                    break;
            }
        }
    }

    # # inicia capturação dos dados no banco
    # # # # #


    # # # # #
    # # Finializa validação

    # valida se @return>error>length é maior que 0
    if ($return['error']['length'] > 0) {

        # adiciona em @return>success com bolean:false
        $return['success'] = false;
    }
    # # Finializa validação
    # # # # #


    # # # # # # # # #
    # # Finaliza exibindo o resultado
    # caso @print seja verdadeiro, exibe return
    if($print == true){

        # imprime na tela os valores de #return
        print_r($return);
    }

    # caso @print seja falso apenas retorna o valor
    if($print == false){

        # retorna o valor de @return
        return $return;
    }
    # # Finaliza exibindo o resultado
    # # # # # # # # #
}
# Função: solicita ao MySQL os valores conforme os parametros
# # # # # # # # # # #

# # # # # # # # # # #
# Função: trata os valores para a função select ao banco mysql
function select($post, $print){

    # # # # #
    # # configura os valores de retorno

    # adiciona em @return>success com true, para iniciar as validações
    $return['success'] = true;

    # adiciona em @return>error>length o valor 0
    $return['error']['length'] = 0;

    # adiciona em @return>warning>length o valor 0
    $return['warning']['length'] = 0;

    # adiciona em @return>backup os valores de @post
    $return['backup'] = $post;

    # # configura os valores de retorno
    # # # # #


    # # # # #
    # # valida os valores recebidos em @post

    # declara @post>type como select
    $post['type'] = 'select';

    # adiciona em @temp>valida o valor recebido da função trata_query
    $temp['valida'] = trata_query($post, false);

    # verifica se houve algum problema no tratamento, com @temp>valida>successs sendo falso
    if ($temp['valida']['success'] == false) {

        # adiciona em @return>success com false, para abortar as validações
        $return['success'] = false;

        # adiciona em @return>error>[@~length]>type o um relato do que houve
        $return['error'][$return['error']['length']]['type'] = 'Houve algum erro na manipulação dos conteudos no momento da validação, consulte a lista de erros de "trata_query"';

        # adiciona +1 em $return>error>length
        $return['error']['length']++;

        # adiciona em @return>error>trata_query os valores de valida.
        $return['process']['trata_query']['error'] = $temp['valida'];
    }

    # verifica se o tratamento foi um successo, com @temp>valida>success sendo falso
    if ($temp['valida']['success'] == true) {

        # define @post com os valores recebidos em @temp>valida>result
        $post = $temp['valida']['result'];


        # adiciona em @return>error>trata_query>success com verdadeiro.
        $return['process']['trata_query']['success'] = true;

        # verifica se existe algum alerta e adicioina a estrutura de @~trata_query
        if ($temp['valida']['warning']['length'] > 0) {

            # adiciona em @return>error>[@~length]>type o um relato do que houve
            $return['warning'][$return['error']['length']]['type'] = 'Algo não saiu como esperado e houve alguns alertas no processo "trata_query"';

            # adiciona +1 em $return>error>length
            $return['warning']['length']++;

            # adiciona os valores de @temp>valida>warning em @return>warning>trata_query
            $return['process']['trata_query']['warning'] = $temp['valida']['warning'];
        }
    }

    # apaga @temp>valida
    unset($temp['valida']);

    # # valida os valores recebidos em @post
    # # # # #


    # # # # #
    # # inicia tratamento dos valores recebidos

    # caso @return>success seja valido inicia a aplicação
    if ($return['success'] == true) {

        # # # # #
        # # configura os valores de retorno

        # # #
        # define valores em @return>process>montagem para montagem

        # define @return>process>montagem>success com false, a espera de montagem
        $return['process']['montagem']['success'] = false;

        # define @return>process>montagem>error como NULL para sem erros
        $return['process']['montagem']['error'] = null;


        # define @return>process>montagem>warning como NULL para sem alertas
        $return['process']['montagem']['warning'] = null;
        # # #

        # #
        # define valores em @return>process>montagem para montagem

        # define @return>process>montagem>success com false, a espera de montagem
        $return['process']['sql']['success'] = false;

        # define @return>process>montagem>error como NULL para sem erros
        $return['process']['sql']['error'] = null;


        # define @return>process>montagem>warning como NULL para sem alertas
        $return['process']['sql']['warning'] = null;
        # # #

        # # configura os valores de retorno
        # # # # #


        # # # # #
        # Inicia montagem dos valores para "SELECT"

        # valida @return>process>montagem>success é "false", inicia montagem de select
        if ($return['process']['montagem']['success'] == false) {


            # declara em @temp>montagem>sql o inicio dos parametros de syntax de seleção tipo "SELEC" para o MySQL
            $temp['montagem']['sql'] = 'SELECT ';


            # # # #
            # # tratamento para "SELECT"

            # valida se existe apenas um resultado em @post>return, adicionando apenas o valor entre aspas
            if ($post['return']['length'] == 1) {

                # valida se o retorno quando 1 for igual a "*", para selecionar todo o banco
                if ($post['return']['0'] == '*') {

                    # adiciona em @temp>montagem>sql o valor de @post>return na posição atual, sem virgula com espaço ao final
                    $temp['montagem']['sql'] .= $post['return']['0'].' ';
                }

                # valida se o retorno quando 1 for igual a "*", para selecionar todo o banco
                if ($post['return']['0'] != '*') {

                    # adiciona em @temp>montagem>sql o valor de @post>return na posição atual, sem virgula com espaço ao final
                    $temp['montagem']['sql'] .= '`'.$post['return']['0'].'` ';
                }
            }

            # valida se existe mais de um resultado em @post>return, adicionando os valores sequenciados por virgula
            if ($post['return']['length'] > 1) {

                # adiciona @temp>montagem>select>count com valor 0
                $temp['montagem']['select']['count'] = 0;

                # inicia loop para selecionar cada valor em @post>return
                while ($temp['montagem']['select']['count'] < $post['return']['length']) {

                    # verifica se @temp>montagem>select>count esta na primeira posição em 0
                    if (($temp['montagem']['select']['count']) == 0) {

                        # adiciona em @temp>montagem>sql o valor de @post>return na posição atual, sem virgula sem espaço ao final
                        $temp['montagem']['sql'] .= '`'. $post['return'][$temp['montagem']['select']['count']].'`';
                    }

                    # verifica se @temp>montagem>select>count passou da primeira posição em 0
                    if ($temp['montagem']['select']['count'] > 0) {

                        # adiciona em @temp>montagem>sql o valor de @post>return na posição atual, com virgula e espaço ao final
                        $temp['montagem']['sql'] .= ', `'. $post['return'][$temp['montagem']['select']['count']].'` ';
                    }

                    # adiciona +1 no contador de @temp>montagem>select>count
                    $temp['montagem']['select']['count']++;
                }

                # apaga @temp>montagem>select
                unset($temp['montagem']['select']);
            }

            # # tratamento para "SELECT"
            # # # #


            # # # #
            # # tratamento para "TABLE"

            # adiciona em @temp>montagem>sql o o parametro para tabela
            $temp['montagem']['sql'] .= 'FROM `'.$post['table'].'` ';

            # # tratamento para "TABLE"
            # # # #


            # # # #
            # # tratamento para "WHERE"

            # adiciona @temp>montagem>select>count com valor 0
            $temp['montagem']['where']['count'] = 0;

            # desmonta os valores de @post>where para @temp>montagem>where key e val
            foreach ($post['where'] as $temp['montagem']['where']['key'] => $temp['montagem']['where']['val']) {

                # verifica se @temp>montagem>select>count esta na primeira sequencia de chave
                if ($temp['montagem']['where']['count'] == 0) {

                    # adiciona em @temp>montagem>sql a abertura da solicitação do tipo WHERE
                    $temp['montagem']['sql'] .= 'WHERE ';
                }

                # verifica se @temp>montagem>select>count passou da primeira sequencia de chave
                if ($temp['montagem']['where']['count'] > 0) {

                    # adiciona em @temp>montagem>sql a abertura da solicitação do tipo AND
                    $temp['montagem']['sql'] .= 'AND ';
                }

                # adiciona em @temp>montagem>sql o valor de @post>where para coluna de "SELECT WHERE"
                $temp['montagem']['sql'] .= '`'. $temp['montagem']['where']['key'].'`';

                # valida se o @post>regra>relative é verdadero pra valor relativo
                if ($post['regra']['relative'] == true) {

                    # adiciona em @temp>montagem>sql o valor de @post>where para coluna de "SELECT LIKE", para valores relativos
                    $temp['montagem']['sql'] .= ' LIKE \'%'.$temp['montagem']['where']['val'].'%\' ';
                }

                # valida se o @post>regra>relative é falso pra valor relativo, e verdadeiro para especifico
                if ($post['regra']['relative'] == false) {

                    # adiciona em @temp>montagem>sql o valor de @post>where para coluna de "SELECT LIKE", para valores especificos
                    $temp['montagem']['sql'] .= ' LIKE \''.$temp['montagem']['where']['val'].'\' ';
                }

                # adiciona +1 no contador de @temp>montagem>select>count
                $temp['montagem']['where']['count']++;
            }

            # apaga @temp>montagem>where
            unset($temp['montagem']['where']);

            # # tratamento para "WHERE"
            # # # #


            # # # #
            # # tratamento para "ORDER"

            # valida se @post>regra>order não é falso
            if ($post['regra']['order'] != false) {

                # adiciona em @temp>montagem>regra>count o valor da contagem de @post>regra>order em length
                $temp['montagem']['regra']['count'] = 0;

                while ($temp['montagem']['regra']['count'] < $post['regra']['order']['length']) {

                    # Inicia montagem quando for em zero
                    if ($temp['montagem']['regra']['count'] == 0 ) {

                        # adiciona em @temp>montagem>sql o o parametro para "ORDER BY" quanto a coluna
                        $temp['montagem']['sql'] .= 'ORDER BY `'.$post['regra']['order'][$temp['montagem']['regra']['count']]['to'].'` ';

                        # adiciona em @temp>montagem>sql o o parametro para "ORDER BY" quanto a ordem
                        $temp['montagem']['sql'] .= $post['regra']['order'][$temp['montagem']['regra']['count']]['by'].' ';
                    }

                    # continua montagem quando form maior que zero
                    if ($temp['montagem']['regra']['count'] > 0 ) {

                        # adiciona em @temp>montagem>sql o o parametro para "ORDER BY" quanto a coluna
                        $temp['montagem']['sql'] .= ', `'.$post['regra']['order'][$temp['montagem']['regra']['count']]['to'].'` ';

                        # adiciona em @temp>montagem>sql o o parametro para "ORDER BY" quanto a ordem
                        $temp['montagem']['sql'] .= $post['regra']['order'][$temp['montagem']['regra']['count']]['by'].' ';
                    }

                    # adiciona +1 no contador de @temp>montagem>regra>count
                    $temp['montagem']['regra']['count']++;
                }

                # apaga @temp>montagem>regra
                unset($temp['montagem']['regra']);
            }

            # # tratamento para "ORDER"
            # # # #


            # # # #
            # # tratamento para "LIMITE"

            # valida se existe limite em @post>regra>limit
            if ($post['regra']['limit'] != false) {

                # adiciona em @temp>montagem>sql o o parametro para "LIMIT" em @post>regra>limit
                $temp['montagem']['sql'] .= 'LIMIT '.$post['regra']['limit'];
            }

            # # tratamento para "LIMITE"
            # # # #


            # # # #
            # # finaliza tratamentos

            # define @return>process>montagem>success como "true", para concluido
            $return['process']['montagem']['success'] = true;

            # adiciona em @return>process>montagem>result o valor de @temp>montagem>sql
            $return['process']['montagem']['result'] = $temp['montagem']['sql'];

            # apaga @temp>montagem
            unset($temp['montagem']);

            # # finaliza tratamentos
            # # # #
        }

        # # Inicia montagem dos valores para select
        # # # # #


        # # # # #
        # # Inicia montagem dos valores para select

        # valida @return>process>montagem>success é "true" para o tratamento dos parametros "SELECT"
        if ($return['process']['montagem']['success'] == true) {

            # adiciona em @temp>select>sql o valor do resultado em @return>montagem>result
            $temp['select']['sql'] = $return['process']['montagem']['result'];

            # adiciona a propriedade "query" em @temp>select>type
            $temp['select']['type'] = 'query';

            # adiciona em @temp>select>result as respostas do servidor e define impressão como falsa
            $temp['select']['result'] = query($temp['select'], false);


            # verifica se houve algum problema no tratamento, com @temp>select>successs sendo falso
            if ($temp['select']['result']['success'] == false) {

                # adiciona em @return>success com false, para abortar as validações
                $return['success'] = false;

                # adiciona em @return>error>[@~length]>type o um relato do que houve
                $return['error'][$return['error']['length']]['type'] = 'Houve algum erro na solicitação dos conteudos ao banco de dados, consulte a lista de erros do processo "sql"';

                # adiciona +1 em $return>error>length
                $return['error']['length']++;

                # adiciona em @return>sql os valores de valida.
                $return['process']['sql']['error'] = $temp['select']['result'];
            }

            # verifica se o tratamento foi um successo, com @temp>select>success sendo falso
            if ($temp['select']['result']['success'] == true) {

                # adiciona em @return>sql>success com verdadeiro.
                $return['process']['sql']['success'] = true;

                # verifica se existe algum alerta e adicioina a estrutura de @~sql
                if ($temp['select']['result']['warning']['length'] > 0) {

                    # adiciona em @return>error>[@~length]>type o um relato do que houve
                    $return['warning'][$return['error']['length']]['type'] = 'Algo não saiu como esperado e houve alguns alertas no processo "select"';

                    # adiciona +1 em $return>error>length
                    $return['warning']['length']++;

                    # adiciona os valores de @temp>select>warning em @return>warning>sql
                    $return['process']['sql']['warning'] = $temp['select']['result']['warning'];
                }

                # adiciona em @return>result>length a contagem de campos selecionados na função mysql_num_rows()
                $return['result']['length'] = mysql_num_rows($temp['select']['result']['result']);

                # valida se @return>result>length é igual zero, para nem um valor retornado
                if ($return['result']['length'] == 0) {

                    # adiciona em @return>result>length a contagem de campos selecionados na função mysql_num_rows()
                    $return['result']['length'] = 0;

                    # adiciona em @return>result>0 o valor de retorno da primeira entrada com a função mysql_fetch_assoc()
                    $return['result']['0'] = null;


                    # adiciona em @return>error>[@~length]>type o um relato do que houve
                    $return['warning'][$return['error']['length']]['type'] = 'Não foi encontrado nem um resultado com os parametros passados';

                    # adiciona +1 em $return>error>length
                    $return['warning']['length']++;
                }

                # valida se @return>result>length é igual a 1 ou maior que zero, para mais valores retornados
                if ($return['result']['length'] == 1) {

                    # adiciona em @return>result>0 o valor de retorno da primeira entrada com a função mysql_fetch_assoc()
                    $return['result']['0'] = mysql_fetch_assoc($temp['select']['result']['result']);

                    # adiciona em @return>result>labels os campos retornados em @return>result>0
                    $return['result']['labels'] = array_keys($return['result']['0']);

                    # adiciona em @return>result>labels>length a contagem dos valores de chaves para @return>result>labels
                    $return['result']['labels']['length'] = count($return['result']['labels']);
                }

                # valida se @return>result>length é maior que 1, para mais valores retornados
                if ($return['result']['length'] > 1) {

                    # adiciona em @temp>select>count o valor de 1 para o contador
                    $temp['select']['count'] = 1;

                    # inicia loop para selecionar cada valor em @temp>select>return>return
                    while ($temp['select']['content'] = mysql_fetch_array($temp['select']['result']['result'])) {

                        # adiciona em @retrurn>result>@~count para selcionar cada valor capturado no loop
                        $return['result'][($temp['select']['count'] - 1)] = $temp['select']['content'];

                        # adiciona +1 em @temp>select>count
                        $temp['select']['count']++;
                    }

                    # adiciona em @return>result>labels os campos retornados em @return>result>0
                    $return['result']['labels'] = array_keys($return['result']['0']);

                    # adiciona em @return>result>labels>length a contagem dos valores de chaves para @return>result>labels
                    $return['result']['labels']['length'] = count($return['result']['labels']);
                }
            }
        }

        # # Inicia montagem dos valores para select
        # # # # #
    }

    # # inicia tratamento dos valores recebidos
    # # # # #


    # # # # #
    # # Finializa validação

    # valida se @return>error>length é maior que 0
    if ($return['error']['length'] > 0) {

        # adiciona em @return>success com bolean:false
        $return['success'] = false;
    }
    # # Finializa validação
    # # # # #


    # # # # # # # # #
    # # Finaliza exibindo o resultado
    # caso @print seja verdadeiro, exibe return
    if($print == true){

        # imprime na tela os valores de #return
        print_r($return);
    }

    # caso @print seja falso apenas retorna o valor
    if($print == false){

        # retorna o valor de @return
        return $return;
    }
    # # Finaliza exibindo o resultado
    # # # # # # # # #
}
# Função: trata os valores para a função select ao banco mysql
# # # # # # # # # # #

# # # # # # # # # # #
# Função: trata os valores para a função insert ao banco mysql
function insert($post, $print){

    # # # # #
    # # configura os valores de retorno

    # adiciona em @return>success com true, para iniciar as validações
    $return['success'] = true;

    # adiciona em @return>error>length o valor 0
    $return['error']['length'] = 0;

    # adiciona em @return>warning>length o valor 0
    $return['warning']['length'] = 0;

    # adiciona em @return>backup os valores de @post
    $return['backup'] = $post;

    # define @return>process

    # # configura os valores de retorno
    # # # # #


    # # # # #
    # # valida os valores recebidos em @post

    # declara @post>type como insert
    $post['type'] = 'insert';

    # adiciona em @temp>valida o valor recebido da função trata_query
    $temp['valida'] = trata_query($post, false);

    # verifica se houve algum problema no tratamento, com @temp>valida>successs sendo falso
    if ($temp['valida']['success'] == false) {

        # adiciona em @return>success com false, para abortar as validações
        $return['success'] = false;

        # adiciona em @return>error>[@~length]>type o um relato do que houve
        $return['error'][$return['error']['length']]['type'] = 'Houve algum erro na manipulação dos conteudos no momento da validação, consulte a lista de erros de "trata_query"';

        # adiciona +1 em $return>error>length
        $return['error']['length']++;

        # adiciona em @return>error>trata_query os valores de valida.
        $return['process']['trata_query']['error'] = $temp['valida'];
    }

    # verifica se o tratamento foi um successo, com @temp>valida>success sendo falso
    if ($temp['valida']['success'] == true) {

        # define @post com os valores recebidos em @temp>valida>result
        $post = $temp['valida']['result'];


        # adiciona em @return>error>trata_query>success com verdadeiro.
        $return['process']['trata_query']['success'] = true;

        # verifica se existe algum alerta e adicioina a estrutura de @~trata_query
        if ($temp['valida']['warning']['length'] > 0) {

            # adiciona em @return>error>[@~length]>type o um relato do que houve
            $return['warning'][$return['error']['length']]['type'] = 'Algo não saiu como esperado e houve alguns alertas no processo "trata_query"';

            # adiciona +1 em $return>error>length
            $return['warning']['length']++;

            # adiciona os valores de @temp>valida>warning em @return>warning>trata_query
            $return['process']['trata_query']['warning'] = $temp['valida']['warning'];
        }
    }

    # apaga @temp>valida
    unset($temp['valida']);

    # # valida os valores recebidos em @post
    # # # # #


    # # # # #
    # # inicia tratamento dos valores recebidos

    # caso @return>success seja valido inicia a aplicação
    if ($return['success'] == true) {

        # # # # #
        # # configura os valores de retorno

        # # #
        # define valores em @return>process>montagem para montagem

        # define @return>process>montagem>success com false, a espera de montagem
        $return['process']['montagem']['success'] = false;

        # define @return>process>montagem>error como NULL para sem erros
        $return['process']['montagem']['error'] = null;

        # define @return>process>montagem>warning como NULL para sem alertas
        $return['process']['montagem']['warning'] = null;

        # # #

        # #
        # define valores em @return>process>montagem para montagem

        # define @return>process>montagem>success com false, a espera de montagem
        $return['process']['insert']['success'] = false;

        # define @return>process>montagem>error como NULL para sem erros
        $return['process']['insert']['error'] = null;

        # define @return>process>montagem>warning como NULL para sem alertas
        $return['process']['insert']['warning'] = null;
        # # #

        # # configura os valores de retorno
        # # # # #


        # # # # #
        # Inicia montagem dos valores para "INSERT"

        # valida @return>process>montagem>success é "false", inicia montagem de select
        if ($return['process']['montagem']['success'] == false) {

            # declara em @temp>montagem>sql o inicio dos parametros de syntax de seleção tipo "INSERT" para o MySQL
            $temp['montagem']['sql'] = 'INSERT INTO ';


            # # # #
            # # tratamento para "TABLE"

            # adiciona em @temp>montagem>sql o o parametro para tabela
            $temp['montagem']['sql'] .= '`'.$post['table'].'` ';

            # # tratamento para "TABLE"
            # # # #


            # # # #
            # # tratamento para "FIELDS"

            # valida se existe apenas um campo para insersão, de acordo com as repostas em @post>length
            if ($post['length'] == 1) {

                # adiciona em @temp>montagem>sql o parametro responsavel pelo campo da tabela
                $temp['montagem']['sql'] .= '(`'.$post['field']['0'].'`) ';
            }

            # valida se existe mais de um campo para insersão, de acordo com as repostas em @post>length
            if ($post['length'] > 1) {

                # adiciona em @temp>montagem>sql a abertura do parametro para os campos da tabela
                $temp['montagem']['sql'] .= '(';

                # adiciona @temp>montagem>select>count com valor 0
                $temp['montagem']['field']['count'] = 0;

                # inicia loop para capturar cada valor dos campo
                while ($temp['montagem']['field']['count'] < $post['length']) {

                    # valida se o loop está no inicio
                    if ($temp['montagem']['field']['count'] == 0) {

                        # adiciona em @temp>montagem>sql o fechamento do parametro para os campos da tabela
                        $temp['montagem']['sql'] .= '`'.addslashes($post['field'][$temp['montagem']['field']['count']]).'`';
                    }

                    # valida se o loop não está no inicio
                    if ($temp['montagem']['field']['count'] > 0) {

                        # adiciona em @temp>montagem>sql o fechamento do parametro para os campos da tabela
                        $temp['montagem']['sql'] .= ', `'.addslashes($post['field'][$temp['montagem']['field']['count']]).'`';
                    }

                    # adiciona +1 em $temp>montagem>field>count
                    $temp['montagem']['field']['count']++;
                }

                # adiciona em @temp>montagem>sql o fechamento do parametro para os campos da tabela
                $temp['montagem']['sql'] .= ') ';
            }

            # # tratamento para "FIELDS"
            # # # #


            # # # #
            # # tratamento para "VALUES"

            # declara em @temp>montagem>sql a entrada para os valores
            $temp['montagem']['sql'] .= 'VALUES ';

            # valida se existe apenas um valor para insersão, de acordo com as repostas em @post>length
            if ($post['length'] == 1) {

                # adiciona em @temp>montagem>sql o parametro responsavel pelo campo da tabela
                $temp['montagem']['sql'] .= '(`'.$post['values']['0'].'`) ';
            }

            # valida se existe mais de um valor para insersão, de acordo com as repostas em @post>length
            if ($post['length'] > 1) {

                # adiciona em @temp>montagem>sql a abertura do parametro para os campos da tabela
                $temp['montagem']['sql'] .= '(';

                # adiciona @temp>montagem>select>count com valor 0
                $temp['montagem']['values']['count'] = 0;

                # inicia loop para capturar cada valor dos campo
                while ($temp['montagem']['values']['count'] < $post['length']) {

                    # valida se o loop está no inicio
                    if ($temp['montagem']['values']['count'] == 0) {

                        # adiciona em @temp>montagem>sql o fechamento do parametro para os campos da tabela
                        $temp['montagem']['sql'] .= '\''.addslashes($post['values'][$temp['montagem']['values']['count']]).'\'';
                    }

                    # valida se o loop não está no inicio
                    if ($temp['montagem']['values']['count'] > 0) {

                        # adiciona em @temp>montagem>sql o fechamento do parametro para os campos da tabela
                        $temp['montagem']['sql'] .= ', \''.addslashes($post['values'][$temp['montagem']['values']['count']]).'\'';
                    }

                    # adiciona +1 em $temp>montagem>values>count
                    $temp['montagem']['values']['count']++;
                }

                # adiciona em @temp>montagem>sql o fechamento do parametro para os campos da tabela
                $temp['montagem']['sql'] .= ') ';
            }

            # # tratamento para "VALUES"
            # # # #


            # # # #
            # # finaliza tratamentos

            # define @return>process>montagem>success como "true", para concluido
            $return['process']['montagem']['success'] = true;

            # adiciona em @return>process>montagem>result o valor de @temp>montagem>sql
            $return['process']['montagem']['result'] = $temp['montagem']['sql'];

            # apaga @temp>montagem
            unset($temp['montagem']);

            # # finaliza tratamentos
            # # # #
        }

        # Inicia montagem dos valores para "INSERT"
        # # # # #


        # # # # #
        # # Inicia envio para o MySQL os valores para insert

        # valida @return>process>montagem>success é "true" para o tratamento dos parametros "SELECT"
        if ($return['process']['montagem']['success'] == true) {

            # adiciona em @temp>select>sql o valor do resultado em @return>montagem>result
            $temp['select']['sql'] = $return['process']['montagem']['result'];

            # adiciona a propriedade "query" em @temp>select>type
            $temp['select']['type'] = 'query';

            # adiciona em @temp>select>result as respostas do servidor e define impressão como falsa
            $temp['select']['result'] = query($temp['select'], false);


            # verifica se houve algum problema no tratamento, com @temp>select>successs sendo falso
            if ($temp['select']['result']['success'] == false) {

                # adiciona em @return>success com false, para abortar as validações
                $return['success'] = false;

                # adiciona em @return>error>[@~length]>type o um relato do que houve
                $return['error'][$return['error']['length']]['type'] = 'Houve algum erro na solicitação dos conteudos ao banco de dados, consulte a lista de erros do processo "sql"';

                # adiciona +1 em $return>error>length
                $return['error']['length']++;

                # adiciona em @return>sql>error os valores de valida.
                $return['process']['sql']['error'] = $temp['select']['result'];
            }

            # verifica se o tratamento foi um successo, com @temp>select>success sendo falso
            if ($temp['select']['result']['success'] == true) {

                # adiciona em @return>process>sql>success com verdadeiro.
                $return['process']['sql']['success'] = true;

                # adiciona em @return>result o valor da inserção
                $return['result'] = $temp['select']['result']['result'];

                # verifica se existe algum alerta e adicioina a estrutura de @~sql
                if ($temp['select']['result']['warning']['length'] > 0) {

                    # adiciona em @return>error>[@~length]>type o um relato do que houve
                    $return['warning'][$return['error']['length']]['type'] = 'Algo não saiu como esperado e houve alguns alertas no processo "select"';

                    # adiciona +1 em $return>error>length
                    $return['warning']['length']++;

                    # adiciona os valores de @temp>select>warning em @return>warning>sql
                    $return['process']['sql']['warning'] = $temp['select']['result']['warning'];
                }
            }
        }

        # # Inicia envio para o MySQL os valores para insert
        # # # # #

    }

    # # inicia tratamento dos valores recebidos
    # # # # #


    # # # # #
    # # Finializa validação

    # valida se @return>error>length é maior que 0
    if ($return['error']['length'] > 0) {

        # adiciona em @return>success com bolean:false
        $return['success'] = false;
    }
    # # Finializa validação
    # # # # #


    # # # # # # # # #
    # # Finaliza exibindo o resultado
    # caso @print seja verdadeiro, exibe return
    if($print == true){

        # imprime na tela os valores de #return
        print_r($return);
    }

    # caso @print seja falso apenas retorna o valor
    if($print == false){

        # retorna o valor de @return
        return $return;
    }
    # # Finaliza exibindo o resultado
    # # # # # # # # #
}
# Função: trata os valores para a função insert ao banco mysql
# # # # # # # # # # #

# # # # # # # # # # #
# Função: trata os valores para a função update ao banco mysql
function update($post, $print){

    # # # # #
    # # configura os valores de retorno

    # adiciona em @return>success com true, para iniciar as validações
    $return['success'] = true;

    # adiciona em @return>error>length o valor 0
    $return['error']['length'] = 0;

    # adiciona em @return>warning>length o valor 0
    $return['warning']['length'] = 0;

    # adiciona em @return>backup os valores de @post
    $return['backup'] = $post;

    # define @return>process

    # # configura os valores de retorno
    # # # # #


    # # # # #
    # # valida os valores recebidos em @post

    # declara @post>type como insert
    $post['type'] = 'update';

    # adiciona em @temp>valida o valor recebido da função trata_query
    $temp['valida'] = trata_query($post, false);

    # verifica se houve algum problema no tratamento, com @temp>valida>successs sendo falso
    if ($temp['valida']['success'] == false) {

        # adiciona em @return>success com false, para abortar as validações
        $return['success'] = false;

        # adiciona em @return>error>[@~length]>type o um relato do que houve
        $return['error'][$return['error']['length']]['type'] = 'Houve algum erro na manipulação dos conteudos no momento da validação, consulte a lista de erros de "trata_query"';

        # adiciona +1 em $return>error>length
        $return['error']['length']++;

        # adiciona em @return>error>trata_query os valores de valida.
        $return['process']['trata_query']['error'] = $temp['valida'];
    }

    # verifica se o tratamento foi um successo, com @temp>valida>success sendo falso
    if ($temp['valida']['success'] == true) {

        # define @post com os valores recebidos em @temp>valida>result
        $post = $temp['valida']['result'];


        # adiciona em @return>error>trata_query>success com verdadeiro.
        $return['process']['trata_query']['success'] = true;

        # verifica se existe algum alerta e adicioina a estrutura de @~trata_query
        if ($temp['valida']['warning']['length'] > 0) {

            # adiciona em @return>error>[@~length]>type o um relato do que houve
            $return['warning'][$return['error']['length']]['type'] = 'Algo não saiu como esperado e houve alguns alertas no processo "trata_query"';

            # adiciona +1 em $return>error>length
            $return['warning']['length']++;

            # adiciona os valores de @temp>valida>warning em @return>warning>trata_query
            $return['process']['trata_query']['warning'] = $temp['valida']['warning'];
        }
    }

    # apaga @temp>valida
    unset($temp['valida']);

    # # valida os valores recebidos em @post
    # # # # #


    # # # # #
    # # inicia tratamento dos valores recebidos

    # caso @return>success seja valido inicia a aplicação
    if ($return['success'] == true) {

        # # # # #
        # # configura os valores de retorno

        # # #
        # define valores em @return>process>montagem para montagem

        # define @return>process>montagem>success com false, a espera de montagem
        $return['process']['montagem']['success'] = false;

        # define @return>process>montagem>error como NULL para sem erros
        $return['process']['montagem']['error'] = null;

        # define @return>process>montagem>warning como NULL para sem alertas
        $return['process']['montagem']['warning'] = null;

        # # #

        # #
        # define valores em @return>process>montagem para montagem

        # define @return>process>montagem>success com false, a espera de montagem
        $return['process']['sql']['success'] = false;

        # define @return>process>montagem>error como NULL para sem erros
        $return['process']['sql']['error'] = null;

        # define @return>process>montagem>warning como NULL para sem alertas
        $return['process']['sql']['warning'] = null;
        # # #

        # # configura os valores de retorno
        # # # # #


        # # # # #
        # Inicia montagem dos valores para "sql"

        # valida @return>process>montagem>success é "false", inicia montagem de select
        if ($return['process']['montagem']['success'] == false) {

            # declara em @temp>montagem>sql o inicio dos parametros de syntax de seleção tipo "UPDATE" para o MySQL
            $temp['montagem']['sql'] = 'UPDATE ';


            # # # #
            # # tratamento para "TABLE"

            # adiciona em @temp>montagem>sql o o parametro para tabela
            $temp['montagem']['sql'] .= '`'.$post['table'].'` ';

            # # tratamento para "TABLE"
            # # # #


            # # # #
            # # tratamento para "SET"

            # adiciona @temp>montagem>select>count com valor 0
            $temp['montagem']['set']['count'] = 0;

            # desmonta os valores de @post>where para @temp>montagem>where key e val
            foreach ($post['values'] as $temp['montagem']['set']['key'] => $temp['montagem']['set']['val']) {

                # verifica se @temp>montagem>select>count esta na primeira sequencia de chave
                if ($temp['montagem']['set']['count'] == 0) {

                    # adiciona em @temp>montagem>sql a abertura da solicitação do tipo set
                    $temp['montagem']['sql'] .= 'SET ';
                }

                # verifica se @temp>montagem>select>count passou da primeira sequencia de chave
                if ($temp['montagem']['set']['count'] > 0) {

                    # adiciona em @temp>montagem>sql a abertura de uma sequencia com (,)
                    $temp['montagem']['sql'] .= ', ';
                }

                # adiciona em @temp>montagem>sql o valor de @post>set para coluna de "UPDATE set"
                $temp['montagem']['sql'] .= '`'. $temp['montagem']['set']['key'].'`';

                # adiciona em @temp>montagem>sql o valor de @post>set para coluna de "SELECT LIKE", para valores relativos
                $temp['montagem']['sql'] .= ' = \''.addslashes($temp['montagem']['set']['val']).'\'';

                # adiciona +1 no contador de @temp>montagem>select>count
                $temp['montagem']['set']['count']++;
            }

            # adiciona um espaço ao final de @temp>montagem>sql, para separar a sessão
            $temp['montagem']['sql'] .= ' ';

            # apaga @temp>montagem>set
            unset($temp['montagem']['set']);

            # # tratamento para "SET"
            # # # #


            # # # #
            # # tratamento para "WHERE"

            # adiciona @temp>montagem>select>count com valor 0
            $temp['montagem']['where']['count'] = 0;

            # desmonta os valores de @post>where para @temp>montagem>where key e val
            foreach ($post['where'] as $temp['montagem']['where']['key'] => $temp['montagem']['where']['val']) {

                # verifica se @temp>montagem>select>count esta na primeira sequencia de chave
                if ($temp['montagem']['where']['count'] == 0) {

                    # adiciona em @temp>montagem>sql a abertura da solicitação do tipo WHERE
                    $temp['montagem']['sql'] .= 'WHERE ';
                }

                # verifica se @temp>montagem>select>count passou da primeira sequencia de chave
                if ($temp['montagem']['where']['count'] > 0) {

                    # adiciona em @temp>montagem>sql a abertura da solicitação do tipo AND
                    $temp['montagem']['sql'] .= 'AND ';
                }

                # adiciona em @temp>montagem>sql o valor de @post>where para coluna de "SELECT WHERE"
                $temp['montagem']['sql'] .= '`'. $temp['montagem']['where']['key'].'`';

                # valida se o @post>regra>relative é verdadero pra valor relativo
                if ($post['regra']['relative'] == true) {

                    # adiciona em @temp>montagem>sql o valor de @post>where para coluna de "SELECT LIKE", para valores relativos
                    $temp['montagem']['sql'] .= ' LIKE \'%'.addslashes($temp['montagem']['where']['val']).'%\' ';
                }

                # valida se o @post>regra>relative é falso pra valor relativo, e verdadeiro para especifico
                if ($post['regra']['relative'] == false) {

                    # adiciona em @temp>montagem>sql o valor de @post>where para coluna de "SELECT LIKE", para valores especificos
                    $temp['montagem']['sql'] .= ' LIKE \''.addslashes($temp['montagem']['where']['val']).'\' ';
                }

                # adiciona +1 no contador de @temp>montagem>select>count
                $temp['montagem']['where']['count']++;
            }

            # apaga @temp>montagem>where
            unset($temp['montagem']['where']);

            # # tratamento para "WHERE"
            # # # #


            # # # #
            # # tratamento para "ORDER"

            # valida se @post>regra>order não é falso
            if ($post['regra']['order'] != false) {

                # adiciona em @temp>montagem>sql o o parametro para "ORDER BY" quanto a coluna
                $temp['montagem']['sql'] .= 'ORDER BY `'.$post['regra']['order']['to'].'` ';

                # adiciona em @temp>montagem>sql o o parametro para "ORDER BY" quanto a ordem
                $temp['montagem']['sql'] .= $post['regra']['order']['by'].' ';
            }

            # # tratamento para "ORDER"
            # # # #


            # # # #
            # # tratamento para "LIMITE"

            # valida se existe limite em @post>regra>limit
            if ($post['regra']['limit'] != false) {

                # adiciona em @temp>montagem>sql o o parametro para "LIMIT" em @post>regra>limit
                $temp['montagem']['sql'] .= 'LIMIT '.$post['regra']['limit'];
            }

            # # tratamento para "LIMITE"
            # # # #


            # # # #
            # # finaliza tratamentos

            # define @return>process>montagem>success como "true", para concluido
            $return['process']['montagem']['success'] = true;

            # adiciona em @return>process>montagem>result o valor de @temp>montagem>sql
            $return['process']['montagem']['result'] = $temp['montagem']['sql'];

            # apaga @temp>montagem
            unset($temp['montagem']);

            # # finaliza tratamentos
            # # # #
        }

        # Inicia montagem dos valores para "sql"
        # # # # #


        # # # # #
        # # Inicia envio para o MySQL os valores para sql

        # valida @return>process>montagem>success é "true" para o tratamento dos parametros "SELECT"
        if ($return['process']['montagem']['success'] == true) {

            # adiciona em @temp>select>sql o valor do resultado em @return>montagem>result
            $temp['select']['sql'] = $return['process']['montagem']['result'];

            # adiciona a propriedade "query" em @temp>select>type
            $temp['select']['type'] = 'query';

            # adiciona em @temp>select>result as respostas do servidor e define impressão como falsa
            $temp['select']['result'] = query($temp['select'], false);


            # verifica se houve algum problema no tratamento, com @temp>select>successs sendo falso
            if ($temp['select']['result']['success'] == false) {

                # adiciona em @return>success com false, para abortar as validações
                $return['success'] = false;

                # adiciona em @return>error>[@~length]>type o um relato do que houve
                $return['error'][$return['error']['length']]['type'] = 'Houve algum erro na solicitação dos conteudos ao banco de dados, consulte a lista de erros do processo "sql"';

                # adiciona +1 em $return>error>length
                $return['error']['length']++;

                # adiciona em @return>sql os valores de valida.
                $return['process']['sql']['error'] = $temp['select']['result'];
            }

            # verifica se o tratamento foi um successo, com @temp>select>success sendo falso
            if ($temp['select']['result']['success'] == true) {

                # adiciona em @return>result o valor de retorno da primeira entrada com a função mysql_fetch_assoc()
                $return['result'] = $temp['select']['result']['result'];

                # adiciona em @return>sql>success com verdadeiro.
                $return['process']['sql']['success'] = true;
            }
        }

        # # Inicia envio para o MySQL os valores para sql
        # # # # #
    }

    # # inicia tratamento dos valores recebidos
    # # # # #


    # # # # #
    # # Finializa validação

    # valida se @return>error>length é maior que 0
    if ($return['error']['length'] > 0) {

        # adiciona em @return>success com bolean:false
        $return['success'] = false;
    }
    # # Finializa validação
    # # # # #


    # # # # # # # # #
    # # Finaliza exibindo o resultado
    # caso @print seja verdadeiro, exibe return
    if($print == true){

        # imprime na tela os valores de #return
        print_r($return);
    }

    # caso @print seja falso apenas retorna o valor
    if($print == false){

        # retorna o valor de @return
        return $return;
    }
    # # Finaliza exibindo o resultado
    # # # # # # # # #
}
# Função: trata os valores para a função update ao banco mysql
# # # # # # # # # # #

# # # # # # # # # # #
# Função: trata os valores para a função delete ao banco mysql
function delete($post, $print){

    # # # # #
    # # configura os valores de retorno

    # adiciona em @return>success com true, para iniciar as validações
    $return['success'] = true;

    # adiciona em @return>error>length o valor 0
    $return['error']['length'] = 0;

    # adiciona em @return>warning>length o valor 0
    $return['warning']['length'] = 0;

    # adiciona em @return>backup os valores de @post
    $return['backup'] = $post;

    # define @return>process

    # # configura os valores de retorno
    # # # # #


    # # # # #
    # # valida os valores recebidos em @post

    # declara @post>type como delete
    $post['type'] = 'delete';

    # adiciona em @temp>valida o valor recebido da função trata_query
    $temp['valida'] = trata_query($post, false);

    # verifica se houve algum problema no tratamento, com @temp>valida>successs sendo falso
    if ($temp['valida']['success'] == false) {

        # adiciona em @return>success com false, para abortar as validações
        $return['success'] = false;

        # adiciona em @return>error>[@~length]>type o um relato do que houve
        $return['error'][$return['error']['length']]['type'] = 'Houve algum erro na manipulação dos conteudos no momento da validação, consulte a lista de erros de "trata_query"';

        # adiciona +1 em $return>error>length
        $return['error']['length']++;

        # adiciona em @return>error>trata_query os valores de valida.
        $return['process']['trata_query']['error'] = $temp['valida'];
    }

    # verifica se o tratamento foi um successo, com @temp>valida>success sendo falso
    if ($temp['valida']['success'] == true) {

        # define @post com os valores recebidos em @temp>valida>result
        $post = $temp['valida']['result'];


        # adiciona em @return>error>trata_query>success com verdadeiro.
        $return['process']['trata_query']['success'] = true;

        # verifica se existe algum alerta e adicioina a estrutura de @~trata_query
        if ($temp['valida']['warning']['length'] > 0) {

            # adiciona em @return>error>[@~length]>type o um relato do que houve
            $return['warning'][$return['error']['length']]['type'] = 'Algo não saiu como esperado e houve alguns alertas no processo "trata_query"';

            # adiciona +1 em $return>error>length
            $return['warning']['length']++;

            # adiciona os valores de @temp>valida>warning em @return>warning>trata_query
            $return['process']['trata_query']['warning'] = $temp['valida']['warning'];
        }
    }

    # apaga @temp>valida
    unset($temp['valida']);

    # # valida os valores recebidos em @post
    # # # # #


    # # # # #
    # # inicia tratamento dos valores recebidos

    # caso @return>success seja valido inicia a aplicação
    if ($return['success'] == true) {

        # # # # #
        # # configura os valores de retorno

        # # #
        # define valores em @return>process>montagem para montagem

        # define @return>process>montagem>success com false, a espera de montagem
        $return['process']['montagem']['success'] = false;

        # define @return>process>montagem>error como NULL para sem erros
        $return['process']['montagem']['error'] = null;

        # define @return>process>montagem>warning como NULL para sem alertas
        $return['process']['montagem']['warning'] = null;

        # # #

        # #
        # define valores em @return>process>montagem para montagem

        # define @return>process>montagem>success com false, a espera de montagem
        $return['process']['sql']['success'] = false;

        # define @return>process>montagem>error como NULL para sem erros
        $return['process']['sql']['error'] = null;

        # define @return>process>montagem>warning como NULL para sem alertas
        $return['process']['sql']['warning'] = null;
        # # #

        # # configura os valores de retorno
        # # # # #


        # # # # #
        # Inicia montagem dos valores para "sql"

        # valida @return>process>montagem>success é "false", inicia montagem de select
        if ($return['process']['montagem']['success'] == false) {

            # declara em @temp>montagem>sql o inicio dos parametros de syntax de seleção tipo "DELETE" para o MySQL
            $temp['montagem']['sql'] = 'DELETE ';


            # # # #
            # # tratamento para "TABLE"

            # adiciona em @temp>montagem>sql o o parametro para tabela
            $temp['montagem']['sql'] .= 'FROM `'.$post['table'].'` ';

            # # tratamento para "TABLE"
            # # # #


            # # # #
            # # tratamento para "WHERE"

            # adiciona @temp>montagem>select>count com valor 0
            $temp['montagem']['where']['count'] = 0;

            # desmonta os valores de @post>where para @temp>montagem>where key e val
            foreach ($post['where'] as $temp['montagem']['where']['key'] => $temp['montagem']['where']['val']) {

                # verifica se @temp>montagem>select>count esta na primeira sequencia de chave
                if ($temp['montagem']['where']['count'] == 0) {

                    # adiciona em @temp>montagem>sql a abertura da solicitação do tipo WHERE
                    $temp['montagem']['sql'] .= 'WHERE ';
                }

                # verifica se @temp>montagem>select>count passou da primeira sequencia de chave
                if ($temp['montagem']['where']['count'] > 0) {

                    # adiciona em @temp>montagem>sql a abertura da solicitação do tipo AND
                    $temp['montagem']['sql'] .= 'AND ';
                }

                # adiciona em @temp>montagem>sql o valor de @post>where para coluna de "DELETE WHERE"
                $temp['montagem']['sql'] .= '`'. $temp['montagem']['where']['key'].'`';

                # valida se o @post>regra>relative é verdadero pra valor relativo
                if ($post['regra']['relative'] == true) {

                    # adiciona em @temp>montagem>sql o valor de @post>where para coluna de "DELETE LIKE", para valores relativos
                    $temp['montagem']['sql'] .= ' LIKE \'%'.$temp['montagem']['where']['val'].'%\' ';
                }

                # valida se o @post>regra>relative é falso pra valor relativo, e verdadeiro para especifico
                if ($post['regra']['relative'] == false) {

                    # adiciona em @temp>montagem>sql o valor de @post>where para coluna de "DELETE LIKE", para valores especificos
                    $temp['montagem']['sql'] .= ' LIKE \''.$temp['montagem']['where']['val'].'\' ';
                }

                # adiciona +1 no contador de @temp>montagem>select>count
                $temp['montagem']['where']['count']++;
            }

            # apaga @temp>montagem>where
            unset($temp['montagem']['where']);

            # # tratamento para "WHERE"
            # # # #


            # # # #
            # # tratamento para "ORDER"

            # valida se @post>regra>order não é falso
            if ($post['regra']['order'] != false) {

                # adiciona em @temp>montagem>sql o o parametro para "ORDER BY" quanto a coluna
                $temp['montagem']['sql'] .= 'ORDER BY `'.$post['regra']['order']['to'].'` ';

                # adiciona em @temp>montagem>sql o o parametro para "ORDER BY" quanto a ordem
                $temp['montagem']['sql'] .= $post['regra']['order']['by'].' ';
            }

            # # tratamento para "ORDER"
            # # # #


            # # # #
            # # tratamento para "LIMITE"

            # valida se existe limite em @post>regra>limit
            if ($post['regra']['limit'] != false) {

                # adiciona em @temp>montagem>sql o o parametro para "LIMIT" em @post>regra>limit
                $temp['montagem']['sql'] .= 'LIMIT '.$post['regra']['limit'];
            }

            # # tratamento para "LIMITE"
            # # # #


            # # # #
            # # finaliza tratamentos

            # define @return>process>montagem>success como "true", para concluido
            $return['process']['montagem']['success'] = true;

            # adiciona em @return>process>montagem>result o valor de @temp>montagem>sql
            $return['process']['montagem']['result'] = $temp['montagem']['sql'];

            # apaga @temp>montagem
            unset($temp['montagem']);

            # # finaliza tratamentos
            # # # #
        }

        # Inicia montagem dos valores para "sql"
        # # # # #


        # # # # #
        # # Inicia envio para o MySQL os valores para sql

        # valida @return>process>montagem>success é "true" para o tratamento dos parametros "SELECT"
        if ($return['process']['montagem']['success'] == true) {

            # adiciona em @temp>select>sql o valor do resultado em @return>montagem>result
            $temp['select']['sql'] = $return['process']['montagem']['result'];

            # adiciona a propriedade "query" em @temp>select>type
            $temp['select']['type'] = 'query';

            # adiciona em @temp>select>result as respostas do servidor e define impressão como falsa
            $temp['select']['result'] = query($temp['select'], false);


            # verifica se houve algum problema no tratamento, com @temp>select>successs sendo falso
            if ($temp['select']['result']['success'] == false) {

                # adiciona em @return>success com false, para abortar as validações
                $return['success'] = false;

                # adiciona em @return>error>[@~length]>type o um relato do que houve
                $return['error'][$return['error']['length']]['type'] = 'Houve algum erro na solicitação dos conteudos ao banco de dados, consulte a lista de erros do processo "sql"';

                # adiciona +1 em $return>error>length
                $return['error']['length']++;

                # adiciona em @return>sql os valores de valida.
                $return['process']['sql']['error'] = $temp['select']['result'];
            }

            # verifica se o tratamento foi um successo, com @temp>select>success sendo falso
            if ($temp['select']['result']['success'] == true) {

                # adiciona em @return>result o valor de retorno da primeira entrada com a função mysql_fetch_assoc()
                $return['result'] = $temp['select']['result']['result'];

                # adiciona em @return>sql>success com verdadeiro.
                $return['process']['sql']['success'] = true;
            }
        }

        # # Inicia envio para o MySQL os valores para sql
        # # # # #
    }

    # # inicia tratamento dos valores recebidos
    # # # # #


    # # # # #
    # # Finializa validação

    # valida se @return>error>length é maior que 0
    if ($return['error']['length'] > 0) {

        # adiciona em @return>success com bolean:false
        $return['success'] = false;
    }
    # # Finializa validação
    # # # # #


    # # # # # # # # #
    # # Finaliza exibindo o resultado
    # caso @print seja verdadeiro, exibe return
    if($print == true){

        # imprime na tela os valores de #return
        print_r($return);
    }

    # caso @print seja falso apenas retorna o valor
    if($print == false){

        # retorna o valor de @return
        return $return;
    }
    # # Finaliza exibindo o resultado
    # # # # # # # # #
}
# Função: trata os valores para a função delete ao banco mysql
# # # # # # # # # # #

# # # # # # # # # # #
# Função: valida valores arrays e restrurura
function trata_query($post, $print){

    # # # # #
    # # configura os valores de retorno

    # adiciona em @return>success com true, para iniciar as validações
    $return['success'] = true;

    # adiciona em @return>error>length o valor 0
    $return['error']['length'] = 0;

    # adiciona em @return>warning>length o valor 0
    $return['warning']['length'] = 0;

    # adiciona em @return>backup os valores recebidos
    $return['backup'] = $post;

    # # configura os valores de retorno
    # # # # #

    # valida se não existe type em @post, identificando qual o tipo de solicitação
    if (!array_key_exists('type', $post)) {

        # adiciona em @return>error>[@~length]>type o um relato do que houve
        $return['error'][$return['error']['length']]['type'] = 'Não existe o type declarado, dessa forma não sera possivel preparar o conjunto array ou validalos.';

        # adiciona +1 em $return>error>length
        $return['error']['length']++;
    }

    # valida se existe type em @post, identificando qual o tipo de solicitação
    if (array_key_exists('type', $post)) {

        # valida não existe "table" em @post, com o valor da tabela a ser selecionada
        if (!array_key_exists('table', $post)) {

            # adiciona em @return>error>[@~length]>type o um relato do que houve
            $return['error'][$return['error']['length']]['type'] = 'Não existe tabela declarada na solicitação';

            # adiciona +1 em $return>error>length
            $return['error']['length']++;
        }


        # # #
        # caso @post>type seja do tipo "select"
        if ($post['type'] == 'select') {

            # #
            # valida os campos não configuraveis internamente

            # valida se existe em @post a arary where, que deve conter todos os dados
            if (array_key_exists('where', $post)) {
                
                # valida se @post>where não possui elementos arrays
                if (!is_array($post['where'])){

                    # valida se @post>where não possui os valores do tipo false
                    if ($post['where'] != false) {

                        # adiciona em @return>error>[@~length]>type o um relato do que houve
                        $return['error'][$return['error']['length']]['type'] = 'O conteúdo de where esta incompatível, era esperado arrays ou bolean:false';

                        # adiciona +1 em $return>error>length
                        $return['error']['length']++;
                    }

                    # adiciona em @return>warning>[@~length]>type o um relato do que houve
                    $return['warning'][$return['warning']['length']]['type'] = 'Não foi passado nem um parametro array, isso pode acarretar um excesso na memória por exibir todos os resultados';

                    # adiciona +1 em $return>error>length
                    $return['warning']['length']++;
                }
            }

            # valida se não existe em @post a arary where, que deve conter todos os dados
            if (!array_key_exists('where', $post)){

                # adiciona em @return>error>[@~length]>type o um relato do que houve
                $return['error'][$return['error']['length']]['type'] = 'Não existe o grupo where que contem os valores de afunilamento na seleção do banco';

                # adiciona +1 em $return>error>length
                $return['error']['length']++;
            }

            # valida os campos não configuraveis internamente
            # #


            # # 
            # valida os campos que podem ser reconfigurados conforme um padrão

            # valida se não existe "regra" em @post, deve conter as configurações a mais
            if (!array_key_exists('regra', $post)) {

                # define @post>regra>relative como false
                $post['regra']['relative'] = false;

                # define @post>regra>order como false
                $post['regra']['order'] = false;

                # define @post>regra>limine com 1
                $post['regra']['limit'] = "1";


                # adiciona em @return>warning>[@~length]>type o um relato do que houve
                $return['warning'][$return['warning']['length']]['type'] = 'Não foi passado nem um parametro regra, assim sendo definido todos com as configurações padrões ';

                # adiciona +1 em $return>error>length
                $return['warning']['length']++;
            }

            # valida se existe "regra" em @post, deve conter as configurações a mais
            if (array_key_exists('regra', $post)) {

                # valida se não existe "relative" em @post>regra
                if (!array_key_exists('relative', $post['regra'])) {

                    # define @post>regra>relative como false
                    $post['regra']['relative'] = false;


                    # adiciona em @return>warning>[@~length]>type o um relato do que houve
                    $return['warning'][$return['warning']['length']]['type'] = 'Não foi definido a regra para busca relativa ou especifica, assim por padrão ficando estabelecida como especifica';

                    # adiciona +1 em $return>error>length
                    $return['warning']['length']++;
                }

                # valida se não existe "order" em @post>regra, que deve conter as regras de ordenação
                if (!array_key_exists('order', $post['regra'])) {

                    # define @post>regra>order como false
                    $post['regra']['order'] = false;


                    # adiciona em @return>warning>[@~length]>type o um relato do que houve
                    $return['warning'][$return['warning']['length']]['type'] = 'Não foi encontrado o parametro "order", assim defininco com sem ordenação para seleção';

                    # adiciona +1 em $return>error>length
                    $return['warning']['length']++;
                }

                # valida se existe "order" em @post>regra, que deve conter as regras de ordenação
                if (array_key_exists('order', $post['regra'])) {

                    // @post>regra>order -> to && by
                    // @post>regra>order -> to && by

                    # valida se "order" em @post>regra é um array
                    if (is_array($post['regra']['order'])) {

                        if (array_key_exists('0', $post['regra']['order'])) {

                            # inicia lop para capturar todos os valores de @post>regra>order
                            for ($i=0; $i < count($post['regra']['order']); $i++) { 

                                # valida se não existe "to" em @post>regra>order>[@~i], que identifica um campo para setar a ordem ede exibição
                                if (!array_key_exists('to', $post['regra']['order'][$i])) {

                                    # define @post>regra>order como false
                                    $post['regra']['order'] = false;


                                    # adiciona em @return>warning>[@~length]>type o um relato do que houve
                                    $return['warning'][$return['warning']['length']]['type'] = 'Não foi encontrado um dos parametros de seleção de ordem, assim definindo como sem ordenamento para exibição';

                                    # adiciona +1 em $return>error>length
                                    $return['warning']['length']++;
                                }

                                # valida se não existe "by" em @post>regra>order>[@~i], define se a ordem é acendente ou descendente
                                if (!array_key_exists('by', $post['regra']['order'][$i])) {

                                    # define @post>regra>order como false
                                    $post['regra']['order'] = false;


                                    # adiciona em @return>warning>[@~length]>type o um relato do que houve
                                    $return['warning'][$return['warning']['length']]['type'] = 'Não foi encontrado um dos parametros de seleção de ordem, assim definindo como sem ordenamento para seleção';

                                    # adiciona +1 em $return>error>length
                                    $return['warning']['length']++;
                                }
                            }

                            # declara a quantidade de todos os valores de @post>regra>order
                            $post['regra']['order']['length'] = $i;

                            # apaga @i
                            unset($i);
                        }

                        if (!array_key_exists('0', $post['regra']['order'])) {

                            # valida se não existe "to" em @post>regra>order, que identifica um campo para setar a ordem ede exibição
                            if (!array_key_exists('to', $post['regra']['order'])) {

                                # define @post>regra>order como false
                                $post['regra']['order'] = false;


                                # adiciona em @return>warning>[@~length]>type o um relato do que houve
                                $return['warning'][$return['warning']['length']]['type'] = 'Não foi encontrado um dos parametros de seleção de ordem, assim definindo como sem ordenamento para exibição';

                                # adiciona +1 em $return>error>length
                                $return['warning']['length']++;
                            }

                            # valida se não existe "by" em @post>regra>order, define se a ordem é acendente ou descendente
                            if (!array_key_exists('by', $post['regra']['order'])) {

                                # define @post>regra>order como false
                                $post['regra']['order'] = false;


                                # adiciona em @return>warning>[@~length]>type o um relato do que houve
                                $return['warning'][$return['warning']['length']]['type'] = 'Não foi encontrado um dos parametros de seleção de ordem, assim definindo como sem ordenamento para seleção';

                                # adiciona +1 em $return>error>length
                                $return['warning']['length']++;
                            }

                            # trata os valores de @post>regra>order caso não tenha havido nem um erro
                            if ($post['regra']['order'] != false) {

                                # adiciona em @temp>move>0 os arquivos de @post>regra>order
                                $temp['move'][0] = $post['regra']['order'];

                                # substitui os valores de @post>regra>order por @temp>move
                                $post['regra']['order'] = $temp['move'];

                                # declara a quantidade de todos os valores de @post>regra>order
                                $post['regra']['order']['length'] = 1;

                                # apaga @temp
                                unset($temp);
                            }
                        }
                    }


                    # valida se "order" em @post>regra mão é um array
                    if (!is_array($post['regra']['order'])) {

                        # define @post>regra>order como false
                        $post['regra']['order'] = false;


                        # adiciona em @return>warning>[@~length]>type o um relato do que houve
                        $return['warning'][$return['warning']['length']]['type'] = 'Não foi encontrado um dos parametros de seleção de ordem, assim definindo como sem ordenamento para exibição';

                        # adiciona +1 em $return>error>length
                        $return['warning']['length']++;
                    }
                }

                # valida se não existe "limit" em @post>regra, deve conter as regras de quantos itens a ser encontrados
                if (!array_key_exists('limit', $post['regra'])) {

                    # define @post>regra>limit como 1
                    $post['regra']['limit'] = "1";


                    # adiciona em @return>warning>[@~length]>type o um relato do que houve
                    $return['warning'][$return['warning']['length']]['type'] = ' Não foi definido a regra para limite de impressão da busca do sql, assim sendo setada com limite igual a 1 (um)';

                    # adiciona +1 em $return>error>length
                    $return['warning']['length']++;
                }

                # valida se existe "limit" em @post>regra, deve conter as regras de quantos itens a ser encontrados 
                if (array_key_exists('limit', $post['regra'])) {

                    # padroniza o tamanho de @post>regra>limit caso seja menor que zero
                    if ($post['regra']['limit'] <= 0) {

                        # define @post>regra>limit com false
                        $post['regra']['limit'] = false;
                    }
                }
            }

            # valida se não existe @post>return, contem a lista de campos a serem retornados
            if (!array_key_exists('return', $post)) {

                # adiciona em @post>regra a array como lista com valor 1
                $post['return'] = array("*");


                # adiciona em @return>warning>[@~length]>type o um relato do que houve
                $return['warning'][$return['warning']['length']]['type'] = 'Não foi definido os campos a serem retornados, assim sendo setado com um retorno de todos os campos da tabela selecionada';

                # adiciona +1 em $return>error>length
                $return['warning']['length']++;
            }

            # valida se existe @post>return, contem a lista de campos a serem retornados
            if (array_key_exists('return', $post)) {

                # valida se existe array em @post>return
                if (is_array($post['return'])) {

                    # valida se existe algo na posição zero, adiciona a contagen length
                    if (array_key_exists('0', $post['return'])) {

                        # adiciona em @post>return>length o valor da função count(), referente a quantia de valores na posição
                        $post['return']['length'] = count($post['return']);
                    }

                    # valida se não existe algo na posição zero
                    if (!array_key_exists('0', $post['return'])) {

                        # define em @post>return com a função array_keys() os keys das arrays em lista numerica
                        $post['return'] = array_keys($post['return']);

                        # adiciona em @post>return>length o valor da função count(), referente a quantia de valores na posição
                        $post['return']['length'] = count($post['return']);
                    }
                }

                # valida se não existe array em @post>return
                if (!is_array($post['return'])) {

                    # valida se o conteudo de @post>return não é vazio
                    if ($post['return'] != '') {

                        # define array em @post>return na posição zero contendo @post>return
                        $post['return'] = array($post['return']);

                        # adiciona em @post>return>length o valor 1, referente a quantia de valores na posição
                        $post['return']['length'] = 1;


                        # adiciona em @return>warning>[@~length]>type o um relato do que houve
                        $return['warning'][$return['warning']['length']]['type'] = 'Não foi definido nem um campo array para a seleção do banco, desta forma por padrão foi declarado na posição zero a string repassada';

                        # adiciona +1 em $return>error>length
                        $return['warning']['length'] = 1;
                    }

                    # valida se o conteudo de @post>return é vazio
                    if ($post['return'] == '') {

                        # adiciona em @return>error>[@~length]>type o um relato do que houve
                        $return['error'][$return['error']['length']]['type'] = 'Não foi encontrado nem um valor referente a seleção para o banco, defina ao menos um ou apenas não declare esta propriedade';

                        # adiciona +1 em $return>error>length
                        $return['error']['length']++;
                    }
                }
            }


            # valida os campos que podem ser reconfigurados conforme um padrão
            # # 
        }
        # caso @post>type seja do tipo "select"
        # # #

        # # #
        # caso @post>type seja do tipo "select"
        else if ($post['type'] == 'update') {

            # #
            # valida os campos não configuraveis internamente

            # valida se existe em @post a arary where, que contem os dados de seleção
            if (array_key_exists('where', $post)) {

                # valida se @post>where não possui elementos arrays
                if (!is_array($post['where'])){

                    # adiciona em @return>error>[@~length]>type o um relato do que houve
                    $return['error'][$return['error']['length']]['type'] = 'O conteúdo de where esta incompatível, era esperado arrays com valores para seleção do banco';

                    # adiciona +1 em $return>error>length
                    $return['error']['length']++;
                }
            }

            # valida se não existe em @post a arary where, que deve conter todos os dados
            if (!array_key_exists('where', $post)){

                # adiciona em @return>error>[@~length]>type o um relato do que houve
                $return['error'][$return['error']['length']]['type'] = 'Não existe o grupo where que contem os valores de afunilamento na seleção do banco';

                # adiciona +1 em $return>error>length
                $return['error']['length']++;
            }


            # valida se existe em @post a arary values, que contem os dados de seleção
            if (array_key_exists('values', $post)) {

                # valida se @post>values não possui elementos arrays
                if (!is_array($post['values'])){

                    # adiciona em @return>error>[@~length]>type o um relato do que houve
                    $return['error'][$return['error']['length']]['type'] = 'O conteúdo de values esta incompatível, era esperado arrays com dados para atualização';

                    # adiciona +1 em $return>error>length
                    $return['error']['length']++;
                }
            }

            # valida se não existe em @post a arary values, que deve conter todos os dados
            if (!array_key_exists('values', $post)){

                # adiciona em @return>error>[@~length]>type o um relato do que houve
                $return['error'][$return['error']['length']]['type'] = 'Não existe o grupo values que contem os valores de atualização da tabela';

                # adiciona +1 em $return>error>length
                $return['error']['length']++;
            }

            # valida os campos não configuraveis internamente
            # #


            # # 
            # valida os campos que podem ser reconfigurados conforme um padrão


            # valida se existe "regra" em @post, deve conter as configurações a mais
            if (array_key_exists('regra', $post)) {
                echo 'oi';
                # valida se não existe "relative" em @post>regra
                if (!array_key_exists('relative', $post['regra'])) {

                    # define @post>regra>relative como false
                    $post['regra']['relative'] = false;


                    # adiciona em @return>warning>[@~length]>type o um relato do que houve
                    $return['warning'][$return['warning']['length']]['type'] = 'Não foi definido a regra para busca relativa ou especifica, assim por padrão ficando estabelecida como especifica';

                    # adiciona +1 em $return>error>length
                    $return['warning']['length']++;
                }

                # valida se não existe "order" em @post>regra, que deve conter as regras de ordenação
                if (!array_key_exists('order', $post['regra'])) {

                    # define @post>regra>order como false
                    $post['regra']['order'] = false;


                    # adiciona em @return>warning>[@~length]>type o um relato do que houve
                    $return['warning'][$return['warning']['length']]['type'] = 'Não foi encontrado o parametro "order", assim defininco com sem ordenação para seleção';

                    # adiciona +1 em $return>error>length
                    $return['warning']['length']++;
                }

                # valida se existe "order" em @post>regra, que deve conter as regras de ordenação
                if (array_key_exists('order', $post['regra'])) {

                    # valida se não existe "to" em @post>regra>order, que identifica um campo para setar a ordem ede exibição
                    if (!array_key_exists('to', $post['regra']['order'])) {

                        # define @post>regra>order como false
                        $post['regra']['order'] = false;


                        # adiciona em @return>warning>[@~length]>type o um relato do que houve
                        $return['warning'][$return['warning']['length']]['type'] = 'Não foi encontrado um dos parametros de seleção de ordem, assim definindo como sem ordenamento para exibição';

                        # adiciona +1 em $return>error>length
                        $return['warning']['length']++;
                    }

                    # valida se não existe "by" em @post>regra>order, define se a ordem é acendente ou descendente
                    if (!array_key_exists('by', $post['regra']['order'])) {

                        # define @post>regra>order como false
                        $post['regra']['order'] = false;


                        # adiciona em @return>warning>[@~length]>type o um relato do que houve
                        $return['warning'][$return['warning']['length']]['type'] = 'Não foi encontrado um dos parametros de seleção de ordem, assim definindo como sem ordenamento para seleção';

                        # adiciona +1 em $return>error>length
                        $return['warning']['length']++;
                    }
                }

                # valida se não existe "limit" em @post>regra, deve conter as regras de quantos itens a ser encontrados
                if (!array_key_exists('limit', $post['regra'])) {

                    # define @post>regra>limit como 1
                    $post['regra']['limit'] = "1";


                    # adiciona em @return>warning>[@~length]>type o um relato do que houve
                    $return['warning'][$return['warning']['length']]['type'] = ' Não foi definido a regra para limite de impressão da busca do sql, assim sendo setada com limite igual a 1 (um)';

                    # adiciona +1 em $return>error>length
                    $return['warning']['length']++;
                }

                # valida se existe "limit" em @post>regra, deve conter as regras de quantos itens a ser encontrados 
                if (array_key_exists('limit', $post['regra'])) {

                    # padroniza o tamanho de @post>regra>limit caso seja menor que zero
                    if ($post['regra']['limit'] <= 0) {

                        # define @post>regra>limit com false
                        $post['regra']['limit'] = false;
                    }
                }
            }

            # valida se não existe "regra" em @post, deve conter as configurações a mais
            if (!array_key_exists('regra', $post)) {

                # define @post>regra>relative como false
                $post['regra']['relative'] = false;

                # define @post>regra>order como false
                $post['regra']['order'] = false;

                # define @post>regra>limine com 1
                $post['regra']['limit'] = "1";


                # adiciona em @return>warning>[@~length]>type o um relato do que houve
                $return['warning'][$return['warning']['length']]['type'] = 'Não foi passado nem um parametro regra, assim sendo definido todos com as configurações padrões ';

                # adiciona +1 em $return>error>length
                $return['warning']['length']++;
            }


            # valida se existe @post>return, contem a lista de campos a serem retornados
            if (array_key_exists('return', $post)) {

                # valida se existe array em @post>return
                if (is_array($post['return'])) {

                    # valida se existe algo na posição zero, adiciona a contagen length
                    if (array_key_exists('0', $post['return'])) {

                        # adiciona em @post>return>length o valor da função count(), referente a quantia de valores na posição
                        $post['return']['length'] = count($post['return']);
                    }

                    # valida se não existe algo na posição zero
                    if (!array_key_exists('0', $post['return'])) {

                        # define em @post>return com a função array_keys() os keys das arrays em lista numerica
                        $post['return'] = array_keys($post['return']);

                        # adiciona em @post>return>length o valor da função count(), referente a quantia de valores na posição
                        $post['return']['length'] = count($post['return']);
                    }
                }

                # valida se não existe array em @post>return
                if (!is_array($post['return'])) {

                    # valida se o conteudo de @post>return não é vazio
                    if ($post['return'] != '') {

                        # define array em @post>return na posição zero contendo @post>return
                        $post['return'] = array($post['return']);

                        # adiciona em @post>return>length o valor 1, referente a quantia de valores na posição
                        $post['return']['length'] = 1;


                        # adiciona em @return>warning>[@~length]>type o um relato do que houve
                        $return['warning'][$return['warning']['length']]['type'] = 'Não foi definido nem um campo array para a seleção do banco, desta forma por padrão foi declarado na posição zero a string repassada';

                        # adiciona +1 em $return>error>length
                        $return['warning']['length'] = 1;
                    }

                    # valida se o conteudo de @post>return é vazio
                    if ($post['return'] == '') {

                        # adiciona em @return>error>[@~length]>type o um relato do que houve
                        $return['error'][$return['error']['length']]['type'] = 'Não foi encontrado nem um valor referente a seleção para o banco, defina ao menos um ou apenas não declare esta propriedade';

                        # adiciona +1 em $return>error>length
                        $return['error']['length']++;
                    }
                }
            }

            # valida se não existe @post>return, contem a lista de campos a serem retornados
            if (!array_key_exists('return', $post)) {

                # adiciona em @post>regra a array como lista com valor 1
                $post['return'] = array("*");


                # adiciona em @return>warning>[@~length]>type o um relato do que houve
                $return['warning'][$return['warning']['length']]['type'] = 'Não foi definido os campos a serem retornados, assim sendo setado com um retorno de todos os campos da tabela selecionada';

                # adiciona +1 em $return>error>length
                $return['warning']['length']++;
            }

            # valida os campos que podem ser reconfigurados conforme um padrão
            # # 
        }
        # caso @post>type seja do tipo "select"
        # # #

        # # #
        # caso @post>type seja do tipo "select"
        else if ($post['type'] == 'insert') {

            # # # # #
            # # configura os valores de retorno interno

            # define @temp>insert>error com 0
            $temp['insert']['error'] = 0;

            # # configura os valores de retorno interno
            # # # # #


            # #
            # valida os campos não configuraveis internamente

            # valida se não existe em @post a arary values, que deve conter todos os dados
            if (!array_key_exists('values', $post)) {

                # adiciona em @return>error>[@~length]>type o um relato do que houve
                $return['error'][$return['error']['length']]['type'] = 'Não foi encontrado nem um campo a ser inserido, é necessario ao menos setar um campo para que seja inserido';

                # adiciona +1 em $return>error>length
                $return['error']['length']++;
            }

            # valida se existe em @post a arary values, que deve conter todos os dados
            if (array_key_exists('values', $post)) {

                # valida se não foi recebido um conjunto de arrays de @post>values
                if (!is_array($post['values'])) {

                    # valida se a string recebida de @post>values não é vazia
                    if ($post['values'] != '') {

                        # adiciona em @temp>result>field na posição 0 o valor da chave equivalente a coluna da tabela
                        $temp['result']['field']['0'] = $post['values'];

                        # adiciona em @temp>result>val na posição 0 o valor a ser inserido na coluna em @~field
                        $temp['result']['values']['0'] = null;

                        # adiciona em @temp>values>length a quantidade de valores a serem inseridos com a função count
                        $temp['result']['length'] = count($temp['result']['field']);


                        # adiciona em @return>warning>[@~length]>type o um relato do que houve
                        $return['warning'][$return['warning']['length']]['type'] = 'Não foi passado nem um parametro array, assim será pego o valor string e definido como campo, com valor "NULL"';

                        # adiciona +1 em $return>error>length
                        $return['warning']['length']++;
                    }

                    # valida se a string recebida de @post>values é vazia
                    if ($post['values'] == '') {

                        # adiciona +1 em @temp>insert>error
                        $temp['insert']['error']++;

                        # adiciona em @return>error>[@~length]>type o um relato do que houve
                        $return['error'][$return['error']['length']]['type'] = 'Não foi encontrado nada no campo definido como values';

                        # adiciona +1 em $return>error>length
                        $return['error']['length']++;
                    }
                }

                # valida se foi recebido um conjunto de arrays de @post>values
                if (is_array($post['values'])) {

                    # explode os campos de @post>values em @return>result>field
                    $temp['result']['field'] = array_keys($post['values']);

                    # explode os valores de @post>values em @temp>result>valores
                    $temp['result']['values'] = array_values($post['values']);

                    # adiciona em @temp>values>length a quantidade de valores a serem inseridos com a função count
                    $temp['result']['length'] = count($temp['result']['field']);
                }

                # valida se houve algum erro em @post>values, para definir os dados de resposta
                if ($return['error']['length'] == 0) {

                    # apaga os valores de @post>values, para serem redefinidos
                    unset($post['values']);

                    # adiciona em @post>length para a quantidade de resultados
                    $post['length'] = $temp['result']['length'];

                    # adiciona em @post>field os campos da tabela a ser seelcionado
                    $post['field'] = $temp['result']['field'];

                    # adiciona em @post>values os valores de cada campo a ser inserido
                    $post['values'] = $temp['result']['values'];
                }
            }

            # apaga os valores de @temp
            unset($temp);

            # valida os campos não configuraveis internamente
            # #
        }
        # caso @post>type seja do tipo "insert"
        # # #

        # # #
        # caso @post>type seja do tipo "delete"
        else if ($post['type'] == 'delete') {

            # #
            # valida os campos não configuraveis internamente

            # valida se existe em @post a arary where, que deve conter todos os dados
            if (array_key_exists('where', $post)) {
                
                # valida se @post>where não possui elementos arrays
                if (!is_array($post['where'])){

                    # valida se @post>where não possui os valores do tipo false
                    if ($post['where'] != false) {

                        # adiciona em @return>error>[@~length]>type o um relato do que houve
                        $return['error'][$return['error']['length']]['type'] = 'O conteúdo de where esta incompatível, era esperado arrays ou bolean:false';

                        # adiciona +1 em $return>error>length
                        $return['error']['length']++;
                    }

                    # adiciona em @return>warning>[@~length]>type o um relato do que houve
                    $return['warning'][$return['warning']['length']]['type'] = 'Não foi passado nem um parametro array, isso pode acarretar um excesso na memória por exibir todos os resultados';

                    # adiciona +1 em $return>error>length
                    $return['warning']['length']++;
                }
            }

            # valida se não existe em @post a arary where, que deve conter todos os dados
            if (!array_key_exists('where', $post)){

                # adiciona em @return>error>[@~length]>type o um relato do que houve
                $return['error'][$return['error']['length']]['type'] = 'Não existe o grupo where que contem os valores de afunilamento na seleção do banco';

                # adiciona +1 em $return>error>length
                $return['error']['length']++;
            }

            # valida os campos não configuraveis internamente
            # #


            # # 
            # valida os campos que podem ser reconfigurados conforme um padrão

            # valida se existe "regra" em @post, deve conter as configurações a mais
            if (array_key_exists('regra', $post)) {

                # valida se não existe "relative" em @post>regra
                if (!array_key_exists('relative', $post['regra'])) {

                    # define @post>regra>relative como false
                    $post['regra']['relative'] = false;


                    # adiciona em @return>warning>[@~length]>type o um relato do que houve
                    $return['warning'][$return['warning']['length']]['type'] = 'Não foi definido a regra para busca relativa ou especifica, assim por padrão ficando estabelecida como especifica';

                    # adiciona +1 em $return>error>length
                    $return['warning']['length']++;
                }

                # valida se existe "order" em @post>regra, que deve conter as regras de ordenação
                if (array_key_exists('order', $post['regra'])) {

                    # valida se não existe "to" em @post>regra>order, que identifica um campo para setar a ordem ede exibição
                    if (!array_key_exists('to', $post['regra']['order'])) {

                        # define @post>regra>order como false
                        $post['regra']['order'] = false;


                        # adiciona em @return>warning>[@~length]>type o um relato do que houve
                        $return['warning'][$return['warning']['length']]['type'] = 'Não foi encontrado um dos parametros de seleção de ordem, assim definindo como sem ordenamento para exibição';

                        # adiciona +1 em $return>error>length
                        $return['warning']['length']++;
                    }

                    # valida se não existe "by" em @post>regra>order, define se a ordem é acendente ou descendente
                    if (!array_key_exists('by', $post['regra']['order'])) {

                        # define @post>regra>order como false
                        $post['regra']['order'] = false;


                        # adiciona em @return>warning>[@~length]>type o um relato do que houve
                        $return['warning'][$return['warning']['length']]['type'] = 'Não foi encontrado um dos parametros de seleção de ordem, assim definindo como sem ordenamento para seleção';

                        # adiciona +1 em $return>error>length
                        $return['warning']['length']++;
                    }
                }

                # valida se não existe "order" em @post>regra, que deve conter as regras de ordenação
                if (!array_key_exists('order', $post['regra'])) {

                    # define @post>regra>order como false
                    $post['regra']['order'] = false;


                    # adiciona em @return>warning>[@~length]>type o um relato do que houve
                    $return['warning'][$return['warning']['length']]['type'] = 'Não foi encontrado o parametro "order", assim defininco com sem ordenação para seleção';

                    # adiciona +1 em $return>error>length
                    $return['warning']['length']++;
                }

                # valida se existe "limit" em @post>regra, deve conter as regras de quantos itens a ser encontrados 
                if (array_key_exists('limit', $post['regra'])) {

                    # padroniza o tamanho de @post>regra>limit caso seja menor que zero
                    if ($post['regra']['limit'] <= 0) {

                        # define @post>regra>limit com false
                        $post['regra']['limit'] = false;
                    }
                }

                # valida se não existe "limit" em @post>regra, deve conter as regras de quantos itens a ser encontrados
                if (!array_key_exists('limit', $post['regra'])) {

                    # define @post>regra>limit como 1
                    $post['regra']['limit'] = "1";


                    # adiciona em @return>warning>[@~length]>type o um relato do que houve
                    $return['warning'][$return['warning']['length']]['type'] = ' Não foi definido a regra para limite de impressão da busca do sql, assim sendo setada com limite igual a 1 (um)';

                    # adiciona +1 em $return>error>length
                    $return['warning']['length']++;
                }
            }

            # valida se não existe "regra" em @post, deve conter as configurações a mais
            if (!array_key_exists('regra', $post)) {

                # define @post>regra>relative como false
                $post['regra']['relative'] = false;

                # define @post>regra>order como false
                $post['regra']['order'] = false;

                # define @post>regra>limine com 1
                $post['regra']['limit'] = "1";


                # adiciona em @return>warning>[@~length]>type o um relato do que houve
                $return['warning'][$return['warning']['length']]['type'] = 'Não foi passado nem um parametro regra, assim sendo definido todos com as configurações padrões ';

                # adiciona +1 em $return>error>length
                $return['warning']['length']++;
            }

            # valida se existe @post>return, contem a lista de campos a serem retornados
            if (array_key_exists('return', $post)) {

                # valida se existe array em @post>return
                if (is_array($post['return'])) {

                    # valida se existe algo na posição zero, adiciona a contagen length
                    if (array_key_exists('0', $post['return'])) {

                        # adiciona em @post>return>length o valor da função count(), referente a quantia de valores na posição
                        $post['return']['length'] = count($post['return']);
                    }

                    # valida se não existe algo na posição zero
                    if (!array_key_exists('0', $post['return'])) {

                        # define em @post>return com a função array_keys() os keys das arrays em lista numerica
                        $post['return'] = array_keys($post['return']);

                        # adiciona em @post>return>length o valor da função count(), referente a quantia de valores na posição
                        $post['return']['length'] = count($post['return']);
                    }
                }

                # valida se não existe array em @post>return
                if (!is_array($post['return'])) {

                    # valida se o conteudo de @post>return não é vazio
                    if ($post['return'] != '') {

                        # define array em @post>return na posição zero contendo @post>return
                        $post['return'] = array($post['return']);

                        # adiciona em @post>return>length o valor 1, referente a quantia de valores na posição
                        $post['return']['length'] = 1;


                        # adiciona em @return>warning>[@~length]>type o um relato do que houve
                        $return['warning'][$return['warning']['length']]['type'] = 'Não foi definido nem um campo array para a seleção do banco, desta forma por padrão foi declarado na posição zero a string repassada';

                        # adiciona +1 em $return>error>length
                        $return['warning']['length'] = 1;
                    }

                    # valida se o conteudo de @post>return é vazio
                    if ($post['return'] == '') {

                        # adiciona em @return>error>[@~length]>type o um relato do que houve
                        $return['error'][$return['error']['length']]['type'] = 'Não foi encontrado nem um valor referente a seleção para o banco, defina ao menos um ou apenas não declare esta propriedade';

                        # adiciona +1 em $return>error>length
                        $return['error']['length']++;
                    }
                }
            }

            # valida se não existe @post>return, contem a lista de campos a serem retornados
            if (!array_key_exists('return', $post)) {

                # adiciona em @post>regra a array como lista com valor 1
                $post['return'] = array("*");


                # adiciona em @return>warning>[@~length]>type o um relato do que houve
                $return['warning'][$return['warning']['length']]['type'] = 'Não foi definido os campos a serem retornados, assim sendo setado com um retorno de todos os campos da tabela selecionada';

                # adiciona +1 em $return>error>length
                $return['warning']['length']++;
            }

            # valida os campos que podem ser reconfigurados conforme um padrão
            # # 
        }
        # caso @post>type seja do tipo "delete"
        # # #

        # # #
        # caso @post>type não esteja na lista de validação
        else {

            # adiciona em @return>error>[@~length]>type o um relato do que houve
            $return['error'][$return['error']['length']]['type'] = 'O valor de validação deve ser "select", "update" ou "inset")';

            # adiciona +1 em $return>error>length
            $return['error']['length']++;
        }
        # caso @post>type não esteja na lista de validação
        # # #
    }

    # adiciona em @return>result o resultado da compilação
    $return['result'] = $post;

    # # # # #
    # # Finializa validação

    # valida se @return>error>length é maior que 0
    if ($return['error']['length'] > 0) {

        # adiciona em @return>success com bolean:false
        $return['success'] = false;
    }
    # # Finializa validação
    # # # # #

    # # # # # # # # #
    # # Finaliza exibindo o resultado
    # caso @print seja verdadeiro, exibe return
    if ($print == true) {
 
        # imprime na tela os valores de #return
        print_r($return);
    }

    # caso @print seja falso apenas retorna o valor
    if ($print == false) {

        # retorna o valor de @return
        return $return;
    }
    # # Finaliza exibindo o resultado
    # # # # # # # # #
}
# Função: valida valores arrays e restrurura
# # # # # # # # # # #
?>

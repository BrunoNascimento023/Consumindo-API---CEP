<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de CEP</title>
</head>
<body>
    <h1>Consulta de CEP</h1>

    <form action="" method="GET">
        <label for="cep">Digite o CEP:</label>
        <input type="text" id="cep" name="cep" required>
        <button type="submit">Consultar</button>
    </form>

    <div id="resultado">
        <?php
        // Verifica se foi enviado um CEP via GET
        if(isset($_GET['cep'])) {
            // Chama a função consultarCEP para obter os dados do CEP
            $cep = $_GET['cep'];
            $endereco = consultarCEP($cep);
            // Verifica se o retorno não é nulo
            if($endereco !== null) {
                // Exibe os dados do endereço
                echo "<h2>Dados do Endereço</h2>";
                echo "<p>CEP: " . $endereco['cep'] . "</p>";
                echo "<p>Logradouro: " . $endereco['logradouro'] . "</p>";
                echo "<p>Bairro: " . $endereco['bairro'] . "</p>";
                echo "<p>Cidade: " . $endereco['localidade'] . "</p>";
                echo "<p>Estado: " . $endereco['uf'] . "</p>";
            } else {
                echo "<p>CEP não encontrado.</p>";
            }
        }
        ?>
    </div>

</body>
</html>

<?php
function consultarCEP($cep){
    // inicia o curl
    $curl = curl_init();

    // configurações do curl 
    curl_setopt_array($curl,[
        CURLOPT_URL => 'https://viacep.com.br/ws/'.$cep.'/json/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'GET'
    ]);

    // Resposta
    $response = curl_exec($curl);

    // Fechar conexão com o Curl
    curl_close($curl);

    // Transformando resposta json em array
    $array = json_decode($response, true);

    // Retorna o conteúdo em array
    return isset($array['cep']) ? $array : null;
}
?>

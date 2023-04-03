<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cotação do Dólar</title>
</head>
<body>
    <main>
        <h1>Conversor de Moedas</h1>
            <?php 
                $inicio = date("m-d-Y", strtotime("-7 days"));
                $fim = date("m-d-Y");
                $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''. $inicio .'\'&@dataFinalCotacao=\''. $fim .'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';
            
                $dados = json_decode(file_get_contents($url), true);
                   
                $cotação = $dados["value"][0]["cotacaoCompra"]; // cotação vida da API do Banco Central
                $real = $_REQUEST["din"] ?? 0; // quanto dinheiro eu possuo
                $dólar = $real / $cotação;

                //echo "Seus R\$$real equivalem a  USD$dólar";
                // Formatação de moeda em internacionalização!
                // Biblioteca intl (Internalization PHP)
            
                $padrão = numfmt_create("pt_BR", NumberFormatter::CURRENCY);
                
                echo "Seus " . numfmt_format_currency($padrão, $real,"BRL") . " equivalem a " . numfmt_format_currency($padrão, $dólar, "USD");
            
            ?>

            <button onclick="javascript:history.go(-1)">Voltar</button>
    </main>
    
</body>
</html>
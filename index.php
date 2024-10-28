<?php
// Função para validação de entrada (valor deve ser numérico e positivo)
function validarEntrada($valor) {
    return is_numeric($valor) && $valor > 0;
}

// Função pura para aplicar a taxa de câmbio e calcular o valor convertido
function converterMoeda($valor, $taxa) {
    return $valor * $taxa;
}

// Função para obter a taxa de câmbio com base nas moedas selecionadas
function obterTaxaDeCambio($moedaOrigem, $moedaDestino) {
    // Tabelas de taxas de câmbio pré-definidas
    $taxas = [
        'USD_EUR' => 0.85,
        'EUR_USD' => 1.18,
        // Adicione mais pares de moedas conforme necessário
    ];
    
    $chave = "{$moedaOrigem}_{$moedaDestino}";
    return $taxas[$chave] ?? null;
}

// Função de ordem superior para realizar a conversão
function realizarConversao($valor, $moedaOrigem, $moedaDestino) {
    if (!validarEntrada($valor)) {
        return "Valor inválido. Insira um número positivo.";
    }
    
    $taxa = obterTaxaDeCambio($moedaOrigem, $moedaDestino);
    if ($taxa === null) {
        return "Taxa de câmbio não encontrada para as moedas selecionadas.";
    }
    
    return converterMoeda($valor, $taxa);
}

// Interface de entrada
$valor = $_POST['valor'] ?? 0;
$moedaOrigem = $_POST['moedaOrigem'] ?? 'USD';
$moedaDestino = $_POST['moedaDestino'] ?? 'EUR';

// Resultado da conversão
$resultado = realizarConversao($valor, $moedaOrigem, $moedaDestino);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Conversor de Moedas</title>
</head>
<body>
    <form method="POST">
        <label for="valor">Valor a converter:</label>
        <input type="text" id="valor" name="valor" required>
        
        <label for="moedaOrigem">Moeda de Origem:</label>
        <select id="moedaOrigem" name="moedaOrigem">
            <option value="USD">Dólar</option>
            <option value="EUR">Euro</option>
            <!-- Adicione mais opções de moeda conforme necessário -->
        </select>
        
        <label for="moedaDestino">Moeda de Destino:</label>
        <select id="moedaDestino" name="moedaDestino">
            <option value="USD">Dólar</option>
            <option value="EUR">Euro</option>
            <!-- Adicione mais opções de moeda conforme necessário -->
        </select>
        
        <button type="submit">Converter</button>
    </form>
    
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p>Resultado da Conversão: <?php echo htmlspecialchars($resultado); ?></p>
    <?php endif; ?>
</body>
<footer>
    <p>Feito por: Iago Trentini Etur</p>
</footer>
</html>

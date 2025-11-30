<?php
// php/processar_pedido.php
session_start();
require_once 'conexao.php'; // Certifique-se que este arquivo conecta ao banco corretamente

// Recebe o JSON enviado pelo JavaScript
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if ($data) {
    $nome = $conn->real_escape_string($data['cliente']['nome']);
    $email = $conn->real_escape_string($data['cliente']['email']);
    $total = floatval($data['total']);
    
    // 1. Inserir o Pedido Principal
    $sql_pedido = "INSERT INTO pedidos (cliente_nome, cliente_email, total, status, data_pedido) VALUES (?, ?, ?, 'Pendente', NOW())";
    $stmt = $conn->prepare($sql_pedido);
    $stmt->bind_param("ssd", $nome, $email, $total);
    
    if ($stmt->execute()) {
        $pedido_id = $conn->insert_id; // Pega o ID do pedido gerado
        
        // 2. Inserir os Itens do Pedido
        $sql_item = "INSERT INTO itens_pedido (pedido_id, produto_nome, categoria, quantidade, preco_unitario) VALUES (?, ?, ?, ?, ?)";
        $stmt_item = $conn->prepare($sql_item);
        
        foreach ($data['itens'] as $item) {
    // PADRÃO: Se não encontrar nada, será 'Outros'
    $categoria = 'Outros';
    
    // Converte o nome para minúsculo para facilitar a busca
    $nome_prod = mb_strtolower($item['name'], 'UTF-8');
    
    // --- LÓGICA MELHORADA DE CATEGORIAS ---
    
    // 1. Camisetas
    if (strpos($nome_prod, 'camisa') !== false || 
        strpos($nome_prod, 'shirt') !== false || 
        strpos($nome_prod, 'camiseta') !== false ||
        strpos($nome_prod, 'baby look') !== false) {
        $categoria = 'Camisetas';
    }
    // 2. Moletons e Casacos
    elseif (strpos($nome_prod, 'moletom') !== false || 
            strpos($nome_prod, 'hoodie') !== false || 
            strpos($nome_prod, 'casaco') !== false || 
            strpos($nome_prod, 'jaqueta') !== false) {
        $categoria = 'Moletons';
    }
    // 3. Acessórios (Bonés, Canecas, etc)
    elseif (strpos($nome_prod, 'bone') !== false || 
            strpos($nome_prod, 'boné') !== false || 
            strpos($nome_prod, 'chapéu') !== false || 
            strpos($nome_prod, 'caneca') !== false ||
            strpos($nome_prod, 'colar') !== false) {
        $categoria = 'Acessórios';
    }
    // 4. Coleções Específicas (Se o nome tiver o nome da coleção)
    elseif (strpos($nome_prod, 'coleção') !== false || 
            strpos($nome_prod, 'especial') !== false) {
        $categoria = 'Coleções';
    }
    // 5. Calças (Bonés, Canecas, etc)
    elseif (strpos($nome_prod, 'calça') !== false || 
            
            strpos($nome_prod, 'bermuda') !== false) {
        $categoria = 'calças';
    }
    // Preparar dados para o banco
    $nome_produto = $item['name'];
    $qtd = $item['quantity'];
    $preco = $item['price'];
    
    // Salvar no banco
    $stmt_item->bind_param("issid", $pedido_id, $nome_produto, $categoria, $qtd, $preco);
    $stmt_item->execute();
}
        
        echo json_encode(['success' => true, 'message' => 'Pedido realizado com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar pedido.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Nenhum dado recebido.']);
}
?>
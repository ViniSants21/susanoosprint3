<?php
// php/processar_pedido.php
session_start();
require_once 'conexao.php'; 

// ==============================================================================
// 1. LÓGICA PARA DESCOBRIR O NOME DA TABELA E DA COLUNA DE ESTOQUE
// ==============================================================================
function find_products_table($conn) {
    $candidates = ['products', 'produtos'];
    foreach ($candidates as $t) {
        $res = $conn->query("SHOW TABLES LIKE '" . $conn->real_escape_string($t) . "'");
        if ($res && $res->num_rows > 0) return $t;
    }
    return 'products';
}
$table_products = find_products_table($conn);

// Verifica se a coluna chama 'stock' ou 'estoque'
$col_estoque = 'stock';
$res_col = $conn->query("SHOW COLUMNS FROM `$table_products` LIKE 'estoque'");
if ($res_col && $res_col->num_rows > 0) {
    $col_estoque = 'estoque';
}
// ==============================================================================


// Recebe o JSON enviado pelo JavaScript
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if ($data) {
    $nome = $conn->real_escape_string($data['cliente']['nome']);
    $email = $conn->real_escape_string($data['cliente']['email']);
    $total = floatval($data['total']);
    
    // 2. Inserir o Pedido Principal
    $sql_pedido = "INSERT INTO pedidos (cliente_nome, cliente_email, total, status, data_pedido) VALUES (?, ?, ?, 'Pendente', NOW())";
    $stmt = $conn->prepare($sql_pedido);
    $stmt->bind_param("ssd", $nome, $email, $total);
    
    if ($stmt->execute()) {
        $pedido_id = $conn->insert_id; // Pega o ID do pedido gerado
        
        // Preparar inserção dos itens no pedido
        $sql_item = "INSERT INTO itens_pedido (pedido_id, produto_nome, categoria, quantidade, preco_unitario) VALUES (?, ?, ?, ?, ?)";
        $stmt_item = $conn->prepare($sql_item);
        
        foreach ($data['itens'] as $item) {
            // PADRÃO: Se não encontrar nada, será 'Outros'
            $categoria = 'Outros';
            
            // Converte o nome para minúsculo para facilitar a busca de categoria
            $nome_prod = mb_strtolower($item['name'], 'UTF-8');
            
            // --- LÓGICA DE CATEGORIAS ---
            if (strpos($nome_prod, 'camisa') !== false || strpos($nome_prod, 'shirt') !== false || strpos($nome_prod, 'camiseta') !== false || strpos($nome_prod, 'baby look') !== false) {
                $categoria = 'Camisetas';
            } elseif (strpos($nome_prod, 'moletom') !== false || strpos($nome_prod, 'hoodie') !== false || strpos($nome_prod, 'casaco') !== false || strpos($nome_prod, 'jaqueta') !== false) {
                $categoria = 'Moletons';
            } elseif (strpos($nome_prod, 'bone') !== false || strpos($nome_prod, 'boné') !== false || strpos($nome_prod, 'chapéu') !== false || strpos($nome_prod, 'caneca') !== false || strpos($nome_prod, 'colar') !== false || strpos($nome_prod, 'anel') !== false) {
                $categoria = 'Acessórios';
            } elseif (strpos($nome_prod, 'coleção') !== false || strpos($nome_prod, 'especial') !== false) {
                $categoria = 'Coleções';
            } elseif (strpos($nome_prod, 'calça') !== false || strpos($nome_prod, 'bermuda') !== false) {
                $categoria = 'Calças';
            }

            // Dados do Item
            $nome_produto = $item['name'];
            $qtd = (int)$item['quantity'];
            $preco = $item['price'];
            
            // 3. Salvar item na tabela 'itens_pedido'
            $stmt_item->bind_param("issid", $pedido_id, $nome_produto, $categoria, $qtd, $preco);
            $stmt_item->execute();

            // ==============================================================================
            // 4. ATUALIZAR (BAIXAR) O ESTOQUE DO PRODUTO
            // ==============================================================================
            // Busca pelo nome exato do produto para descontar a quantidade
            $nome_busca = $conn->real_escape_string($nome_produto);
            
            $sql_baixa_estoque = "UPDATE `$table_products` 
                                  SET `$col_estoque` = `$col_estoque` - $qtd 
                                  WHERE name = '$nome_busca' 
                                  AND `$col_estoque` >= $qtd";
            
            $conn->query($sql_baixa_estoque);
            // ==============================================================================
        }
        
        echo json_encode(['success' => true, 'message' => 'Pedido realizado com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar pedido.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Nenhum dado recebido.']);
}
?>
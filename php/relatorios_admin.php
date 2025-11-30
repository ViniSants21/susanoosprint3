<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentários - Susanoo Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        (function(){
            const theme = localStorage.getItem('theme');
            if(theme === 'light') {
                document.documentElement.classList.add('light-mode');
            }
        })();
    </script>
    <style>
        /* ===== ESTILOS GERAIS DO PAINEL (Mantidos do original) ===== */
        .admin-dashboard { background-color: var(--bg-primary); min-height: 100vh; padding-top: 80px; }
        .admin-container { display: flex; max-width: 1400px; margin: 0 auto; padding: 0 20px; }
        
        /* Sidebar (INTACTO) */
        .admin-sidebar { width: 280px; background: var(--bg-card); border-radius: 20px; padding: 2rem 1.5rem; margin-right: 2rem; height: fit-content; position: sticky; top: 100px; box-shadow: var(--shadow-soft); border: 1px solid rgba(139, 92, 246, 0.1); }
        .admin-logo { text-align: center; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); }
        .admin-logo h2 { font-family: var(--font-display); color: var(--primary-purple); margin: 0; font-size: 1.8rem; }
        .admin-logo span { color: var(--text-secondary); font-size: 0.9rem; }
        .admin-nav { list-style: none; padding: 0; margin: 0; }
        .admin-nav li { margin-bottom: 0.5rem; }
        .admin-nav a { display: flex; align-items: center; gap: 1rem; padding: 1rem 1.2rem; text-decoration: none; color: var(--text-secondary); border-radius: 12px; transition: all 0.3s ease; font-weight: 500; }
        .admin-nav a:hover, .admin-nav a.active { background: rgba(139, 92, 246, 0.1); color: var(--primary-purple); transform: translateX(5px); }
        .admin-nav a i { width: 20px; text-align: center; font-size: 1.1rem; }
        
        /* Main e Header */
        .admin-main { flex: 1; padding-bottom: 3rem; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); }
        .admin-title { font-family: var(--font-display); font-size: 2.5rem; color: var(--text-primary); margin: 0; }
        .admin-actions { display: flex; gap: 1rem; }
        .btn-primary { background: var(--primary-purple); color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 10px; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 600; transition: all 0.3s ease; }
        .btn-primary:hover { background: var(--secondary-purple); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3); }

        /* ===== ESTILOS ESPECÍFICOS DA PÁGINA DE COMENTÁRIOS (NOVO CSS) ===== */
        
        /* Container Principal do Relatório */
        .report-card {
            background: var(--bg-card);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(139, 92, 246, 0.1);
            animation: fadeIn 0.5s ease;
        }

        /* Cabeçalho do Card */
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .report-title {
            font-size: 1.5rem;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .report-title i { color: var(--primary-purple); }

        /* Botão de Exportar */
        #export-comments {
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        #export-comments:hover {
            border-color: var(--primary-purple);
            color: var(--primary-purple);
            background: rgba(139, 92, 246, 0.05);
        }

        /* Lista de Comentários */
        .comments-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        /* Item Individual (Card do Comentário) */
        .comment-item {
            background: rgba(255, 255, 255, 0.02); /* Fundo sutil para destacar */
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.8rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .comment-item:hover {
            border-color: rgba(139, 92, 246, 0.5);
            background: rgba(139, 92, 246, 0.03);
            transform: translateY(-2px);
            box-shadow: var(--shadow-soft);
        }

        /* Metadados (Nome, Email, Data) */
        .comment-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 1.2rem;
            padding-bottom: 1rem;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
        }

        .comment-avatar-placeholder {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-purple), var(--secondary-purple));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .comment-info {
            display: flex;
            flex-direction: column;
        }

        .comment-name {
            font-weight: 700;
            color: var(--text-primary);
            font-size: 1.05rem;
        }

        .comment-email {
            color: var(--primary-purple);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .comment-date {
            margin-left: auto;
            color: var(--text-muted);
            font-size: 0.8rem;
            background: rgba(0,0,0,0.2);
            padding: 4px 10px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Assunto e Corpo */
        .comment-subject {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .comment-subject i {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .comment-body {
            color: var(--text-secondary);
            line-height: 1.7;
            font-size: 0.95rem;
            background: rgba(0,0,0,0.1); /* Fundo escuro para o texto */
            padding: 1rem;
            border-radius: 10px;
        }

        /* Responsividade Específica */
        @media (max-width: 768px) {
            .comment-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            .comment-date {
                margin-left: 0;
                margin-top: 5px;
            }
            .report-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
            .report-actions {
                width: 100%;
                display: flex;
                justify-content: flex-end;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="admin-dashboard">

<?php
require_once 'conexao.php';

// Buscar comentários na tabela mensagens_contato
$comments = [];
$res = $conn->query("SELECT nome, email, assunto, mensagem, data_envio FROM mensagens_contato ORDER BY data_envio DESC");
if ($res) {
    while($row = $res->fetch_assoc()) {
        $comments[] = $row;
    }
}
?>

<div class="admin-container">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-logo">
            <h2>Susanoo Admin</h2>
            <span>Painel de Controle</span>
        </div>
        <ul class="admin-nav">
            <li><a href="admin.php"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
            <li><a href="produtos_admin.php"><i class="fas fa-box"></i> Produtos</a></li>
            <li><a href="usuarios_admin.php"><i class="fas fa-users"></i> Usuários</a></li>
            <li><a href="pedidos_admin.php"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
            <li><a href="relatorios_admin.php" class="active"><i class="fas fa-comment"></i>Mensagens</a></li>
            
            <li><a href="../index.php"><i class="fas fa-sign-out-alt"></i> Voltar ao Site</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <div class="admin-header">
            <h1 class="admin-title">Gestão de Comentários</h1>
            <div class="admin-actions">
                <a href="relatorios_admin.php" class="btn btn-primary"><i class="fas fa-sync-alt"></i> Atualizar</a>
            </div>
        </div>

        <div class="report-card">
            <div class="report-header">
                <h2 class="report-title">
                    <i class="fas fa-inbox"></i> Caixa de Entrada
                    <span style="font-size:0.9rem; color:var(--text-muted); margin-left:10px; font-weight:400;">(<?php echo count($comments); ?> mensagens)</span>
                </h2>
                
            </div>

            <?php if (count($comments) === 0): ?>
                <div style="text-align:center; padding: 4rem 2rem;">
                    <i class="fas fa-comment-slash" style="font-size:3rem; color:var(--text-muted); margin-bottom:1rem;"></i>
                    <p style="color:var(--text-secondary); font-size:1.1rem;">Nenhum comentário encontrado.</p>
                </div>
            <?php else: ?>
                <ul class="comments-list">
                    <?php foreach($comments as $c): 
                        // Pega a inicial para o avatar
                        $initial = strtoupper(substr($c['nome'], 0, 1));
                    ?>
                        <li class="comment-item">
                            <div class="comment-meta">
                                <!-- Avatar Placeholder -->
                                <div class="comment-avatar-placeholder"><?php echo $initial; ?></div>
                                
                                <div class="comment-info">
                                    <div class="comment-name"><?php echo htmlspecialchars($c['nome']); ?></div>
                                    <div class="comment-email"><?php echo htmlspecialchars($c['email']); ?></div>
                                </div>
                                
                                <div class="comment-date">
                                    <i class="far fa-clock"></i>
                                    <?php echo isset($c['data_envio']) ? date('d/m/Y H:i', strtotime($c['data_envio'])) : 'Data desconhecida'; ?>
                                </div>
                            </div>

                            <?php if (!empty($c['assunto'])): ?>
                                <div class="comment-subject">
                                    <i class="fas fa-quote-left"></i>
                                    <?php echo htmlspecialchars($c['assunto']); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="comment-body">
                                <?php echo nl2br(htmlspecialchars($c['mensagem'])); ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </main>
</div>

<script src="../js/script.js"></script>
<script>
    document.getElementById('export-comments')?.addEventListener('click', function(){
        alert('Funcionalidade de exportação em desenvolvimento.');
    });
</script>
</body>
</html>
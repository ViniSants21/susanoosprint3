-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/11/2025 às 03:19
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `susanoo_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `status`, `price`, `stock`, `image`, `descricao`, `created_at`, `updated_at`) VALUES
(11, 'Produto qualquer', 'camisetas', '', 99.01, 123, NULL, 'ESSE produto\r\n..\r\n..\r\n..\r\n.', '2025-11-28 01:13:59', '2025-11-28 01:14:17');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `nome`, `email`, `senha`, `foto`, `created_at`) VALUES
(12, NULL, 'lucasds@gmail.com', '$2y$10$H8nxu7XroBiqVj3.jl62P.2nB8qBBhMQzuPOMgX3YbluHpxWXudQe', 'uploads/1763580887_', '2025-11-19 19:34:47'),
(13, NULL, 'lucas@gmail.com', '$2y$10$RNhqyvQwmL4kPDLBzIkqjeLKmtWzJYrVv/Lvi2IqxVpyqUIn05VL.', 'uploads/1763581546_', '2025-11-19 19:45:46'),
(18, NULL, 'kaka@gmail.com', '$2y$10$bWoBvs2ntxhomd/UJ94mEud.Ac0Y9gJmORzjOEpA.TgGBUo78U46m', 'uploads/1763581878_', '2025-11-19 19:51:18'),
(19, NULL, 'lucasgg@gmail.com', '$2y$10$28qamS0xZfiKAOoxBPeWMuUUELEUA2Tm.Fzg4k1X1977avCXREcse', 'uploads/1763582143_', '2025-11-19 19:55:43'),
(20, NULL, 'abacate@gmail.com', '$2y$10$J0Mo46IFRmydHBbAUP7WTuc/DlGyUqGmTdWmsOooes.J8q/ImxU0W', 'uploads/1763582604_', '2025-11-19 20:03:24'),
(21, NULL, 'lucas12@gmail.com', '$2y$10$wgsIV9dF9cuiqIc3rLAXzu8Cs3R8CCrRvTQOZbsO.Qoavc0S/tMNy', 'uploads/1763583189_', '2025-11-19 20:13:09'),
(22, NULL, 'bogaboga@gmail.com', '$2y$10$RlMGPX0hpxLjpaaVc34TE.fRpaqlOFtjw9GZbGG/e.7ofyZRnXi9m', 'uploads/1763645119_', '2025-11-20 13:25:19'),
(23, NULL, 'samuelzin@gmail.com', '$2y$10$SGNZmgY5fAk/XZBHE2CkNeXSLhbvKLBJw3rbNx2jE632Cabf9UZFO', 'uploads/1763766811_', '2025-11-21 23:13:31');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

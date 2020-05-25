-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 25-Maio-2020 às 02:34
-- Versão do servidor: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ta_na_mesa`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_mesa`
--

CREATE TABLE `tb_mesa` (
  `idMesa` int(10) UNSIGNED NOT NULL,
  `situacao` char(1) NOT NULL,
  `numero` int(4) NOT NULL,
  `numLugares` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_mesa`
--

INSERT INTO `tb_mesa` (`idMesa`, `situacao`, `numero`, `numLugares`) VALUES
(1, 'L', 1, 3),
(3, 'L', 2, 4),
(4, 'L', 3, 5),
(5, 'L', 6, 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_perfil_usuario`
--

CREATE TABLE `tb_perfil_usuario` (
  `idPerfilUsuario` int(10) UNSIGNED NOT NULL,
  `perfil` varchar(200) NOT NULL,
  `index_perfil` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_perfil_usuario`
--

INSERT INTO `tb_perfil_usuario` (`idPerfilUsuario`, `perfil`, `index_perfil`) VALUES
(1, 'Cliente', 'CLIENTE'),
(2, 'Atendente', 'ATENDENTE'),
(3, 'Administrador', 'ADMINISTRADOR'),
(4, 'Gerente', 'GERENTE'),
(5, 'teste', 'TESTE');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_perfil_usuario_has_tb_recurso`
--

CREATE TABLE `tb_perfil_usuario_has_tb_recurso` (
  `idPerfilUsuarioRecurso` int(10) UNSIGNED NOT NULL,
  `idPerfilUsuario` int(10) UNSIGNED NOT NULL,
  `idRecurso` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_perfil_usuario_has_tb_recurso`
--

INSERT INTO `tb_perfil_usuario_has_tb_recurso` (`idPerfilUsuarioRecurso`, `idPerfilUsuario`, `idRecurso`) VALUES
(1, 3, 1),
(2, 3, 2),
(3, 3, 3),
(4, 3, 4),
(5, 3, 5),
(6, 3, 6),
(7, 3, 7),
(8, 3, 8);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_recurso`
--

CREATE TABLE `tb_recurso` (
  `idRecurso` int(10) UNSIGNED NOT NULL,
  `nome` varchar(300) NOT NULL,
  `s_n_menu` char(1) NOT NULL,
  `index_recurso` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_recurso`
--

INSERT INTO `tb_recurso` (`idRecurso`, `nome`, `s_n_menu`, `index_recurso`) VALUES
(1, 'cadastrar_usuario', 's', 'CADASTRAR_USUARIO'),
(2, 'editar_usuário', 's', 'EDITAR_USUARIO'),
(3, 'remover_usuario', 's', 'REMOVER_USUARIO'),
(4, 'listar_usuario', 's', 'LISTAR_USUARIO'),
(5, 'cadastrar_usuario_perfilUsuario', 's', 'CADASTRAR_USUARIO_PERFILUSUARIO'),
(6, 'editar_usuario_perfilUsuario', 's', 'EDITAR_USUARIO_PERFILUSUARIO'),
(7, 'listar_usuario_perfilUsuario', 's', 'LISTAR_USUARIO_PERFILUSUARIO'),
(8, 'remover_usuario_perfilUsuario', 's', 'REMOVER_USUARIO_PERFILUSUARIO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `CPF` varchar(11) NOT NULL,
  `senha` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`idUsuario`, `CPF`, `senha`) VALUES
(1, '86251791004', '123456'),
(2, '11111111111', '1234'),
(3, '00000000000', '1234');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario_has_tb_perfil_usuario`
--

CREATE TABLE `tb_usuario_has_tb_perfil_usuario` (
  `idUsuarioPerfilUsuario` int(10) UNSIGNED NOT NULL,
  `idPerfilUsuario` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_usuario_has_tb_perfil_usuario`
--

INSERT INTO `tb_usuario_has_tb_perfil_usuario` (`idUsuarioPerfilUsuario`, `idPerfilUsuario`, `idUsuario`) VALUES
(1, 3, 1),
(3, 1, 2),
(4, 2, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_mesa`
--
ALTER TABLE `tb_mesa`
  ADD PRIMARY KEY (`idMesa`);

--
-- Indexes for table `tb_perfil_usuario`
--
ALTER TABLE `tb_perfil_usuario`
  ADD PRIMARY KEY (`idPerfilUsuario`);

--
-- Indexes for table `tb_perfil_usuario_has_tb_recurso`
--
ALTER TABLE `tb_perfil_usuario_has_tb_recurso`
  ADD PRIMARY KEY (`idPerfilUsuarioRecurso`),
  ADD KEY `tb_perfil_usuario_has_tb_recurso_FKIndex1` (`idPerfilUsuario`),
  ADD KEY `tb_perfil_usuario_has_tb_recurso_FKIndex2` (`idRecurso`);

--
-- Indexes for table `tb_recurso`
--
ALTER TABLE `tb_recurso`
  ADD PRIMARY KEY (`idRecurso`);

--
-- Indexes for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indexes for table `tb_usuario_has_tb_perfil_usuario`
--
ALTER TABLE `tb_usuario_has_tb_perfil_usuario`
  ADD PRIMARY KEY (`idUsuarioPerfilUsuario`),
  ADD KEY `tb_usuario_has_tb_perfil_usuario_FKIndex1` (`idUsuario`),
  ADD KEY `tb_usuario_has_tb_perfil_usuario_FKIndex2` (`idPerfilUsuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_mesa`
--
ALTER TABLE `tb_mesa`
  MODIFY `idMesa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_perfil_usuario`
--
ALTER TABLE `tb_perfil_usuario`
  MODIFY `idPerfilUsuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_perfil_usuario_has_tb_recurso`
--
ALTER TABLE `tb_perfil_usuario_has_tb_recurso`
  MODIFY `idPerfilUsuarioRecurso` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_recurso`
--
ALTER TABLE `tb_recurso`
  MODIFY `idRecurso` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `idUsuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_usuario_has_tb_perfil_usuario`
--
ALTER TABLE `tb_usuario_has_tb_perfil_usuario`
  MODIFY `idUsuarioPerfilUsuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

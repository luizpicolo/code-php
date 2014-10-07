-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 01/04/2013 às 14h24min
-- Versão do Servidor: 5.5.29
-- Versão do PHP: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `code`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos`
--

CREATE TABLE IF NOT EXISTS `alunos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aluno` varchar(45) DEFAULT NULL,
  `responsavel` varchar(45) DEFAULT NULL,
  `contatoResponsavel` varchar(70) DEFAULT NULL,
  `dataMatricula` date DEFAULT NULL,
  `dataTerminoEstudos` date DEFAULT NULL,
  `foto` varchar(45) DEFAULT NULL,
  `status` enum('1','2') DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNICOS` (`aluno`),
  KEY `INDEXES` (`aluno`,`status`,`dataTerminoEstudos`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('1037cdff61b090f873295165a3fd1ca9', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:19.0) Gecko/20100101 Firefox/19.0', 1364839647, ''),
('46871a1f74d9eb8dd46ebafdb43aa6a6', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:19.0) Gecko/20100101 Firefox/19.0', 1364839646, 'a:6:{s:9:"user_data";s:0:"";s:2:"id";s:2:"38";s:4:"nome";s:13:"Administrador";s:5:"nivel";s:1:"1";s:6:"logado";b:1;s:8:"mensagem";s:0:"";}');

-- --------------------------------------------------------

--
-- Estrutura da tabela `desempenho`
--

CREATE TABLE IF NOT EXISTS `desempenho` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `idAluno` int(10) DEFAULT NULL,
  `idUsuario` int(5) DEFAULT NULL,
  `dataInicio` date DEFAULT NULL,
  `dataFinal` date DEFAULT NULL,
  `desempenhoEscolar` mediumtext,
  PRIMARY KEY (`id`),
  KEY `OcorreciaAlunos_idx` (`idAluno`),
  KEY `OcorrenciaUsuario_idx` (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ocorrencias`
--

CREATE TABLE IF NOT EXISTS `ocorrencias` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `idAluno` int(10) DEFAULT NULL,
  `idUsuario` int(5) DEFAULT NULL,
  `dataOcorrencia` date DEFAULT NULL,
  `ocorrencia` mediumtext,
  `dataSolucao` date DEFAULT NULL,
  `solucao` mediumtext,
  PRIMARY KEY (`id`),
  KEY `OcorreciaAlunos_idx` (`idAluno`),
  KEY `OcorrenciaUsuario_idx` (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `usuario` varchar(45) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `nivel` enum('1','2') DEFAULT '2' COMMENT '1 - Administrador e 2 - Usuário',
  `dataCadastro` datetime DEFAULT NULL,
  `dataAcesso` datetime DEFAULT NULL,
  `status` enum('1','2') DEFAULT '1' COMMENT '1 - ativo\\n2 - inativo\\n',
  PRIMARY KEY (`id`),
  KEY `INDEXES` (`nome`,`senha`,`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `usuario`, `senha`, `nivel`, `dataCadastro`, `dataAcesso`, `status`) VALUES
(38, 'Administrador', '21232f297a57a5a743894a0e4a801fc3', '21232f297a57a5a743894a0e4a801fc3', '1', '2013-04-01 00:00:00', '2013-04-01 14:07:27', '1');

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `desempenho`
--
ALTER TABLE `desempenho`
  ADD CONSTRAINT `OcorreciasAlunos0` FOREIGN KEY (`idAluno`) REFERENCES `alunos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `OcorrenciaUsuarios0` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `ocorrencias`
--
ALTER TABLE `ocorrencias`
  ADD CONSTRAINT `OcorreciasAlunos` FOREIGN KEY (`idAluno`) REFERENCES `alunos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `OcorrenciaUsuarios` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

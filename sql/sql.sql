-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 27/03/2013 às 13h15min
-- Versão do Servidor: 5.5.29
-- Versão do PHP: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `sistemaalunos`
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
  `foto` varchar(45) NOT NULL,
  `status` enum('1','2') DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNICOS` (`aluno`),
  KEY `INDEXES` (`aluno`,`status`,`dataTerminoEstudos`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Extraindo dados da tabela `alunos`
--

INSERT INTO `alunos` (`id`, `aluno`, `responsavel`, `contatoResponsavel`, `dataMatricula`, `dataTerminoEstudos`, `foto`, `status`) VALUES
(29, 'Lorem ipsum dolor', 'Lorem ipsum', '(99)9999-9999', '2013-03-01', '2013-03-31', 'd32d18e8347ba7eaa3eb2b8572714aa8.jpg', '1');

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
('c69c087c0f593d75034d55e306ff962d', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:19.0) Gecko/20100101 Firefox/19.0', 1364394422, '');

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

--
-- Extraindo dados da tabela `desempenho`
--

INSERT INTO `desempenho` (`id`, `idAluno`, `idUsuario`, `dataInicio`, `dataFinal`, `desempenhoEscolar`) VALUES
(3, 29, 11, '2013-03-01', '2013-03-31', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tristique\n adipiscing aliquet. Aenean pellentesque libero vel est eleifend eget \nluctus dolor mattis. Mauris vitae dui eu purus ornare interdum vel \nblandit elit. In volutpat quam in leo dignissim non porta nisl mattis. \nCras pretium cursus ipsum, non ultrices massa accumsan sed. Vestibulum \nante ipsum primis in faucibus orci luctus et ultrices posuere cubilia \nCurae; Donec at hendrerit tellus. Cras sem felis, vulputate eget \nvenenatis malesuada, auctor eget quam. Morbi suscipit nulla tellus, \ncursus rutrum ligula.\n<br>');

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

--
-- Extraindo dados da tabela `ocorrencias`
--

INSERT INTO `ocorrencias` (`id`, `idAluno`, `idUsuario`, `dataOcorrencia`, `ocorrencia`, `dataSolucao`, `solucao`) VALUES
(3, 29, 11, '2013-03-01', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tristique\n adipiscing aliquet. Aenean pellentesque libero vel est eleifend eget \nluctus dolor mattis. Mauris vitae dui eu purus ornare interdum vel \nblandit elit. In volutpat quam in leo dignissim non porta nisl mattis. \nCras pretium cursus ipsum, non ultrices massa accumsan sed. Vestibulum \nante ipsum primis in faucibus orci luctus et ultrices posuere cubilia \nCurae; Donec at hendrerit tellus. Cras sem felis, vulputate eget \nvenenatis malesuada, auctor eget quam. Morbi suscipit nulla tellus, \ncursus rutrum ligula.\n<br>', '2013-03-31', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tristique\n adipiscing aliquet. Aenean pellentesque libero vel est eleifend eget \nluctus dolor mattis. Mauris vitae dui eu purus ornare interdum vel \nblandit elit. In volutpat quam in leo dignissim non porta nisl mattis. \nCras pretium cursus ipsum, non ultrices massa accumsan sed. Vestibulum \nante ipsum primis in faucibus orci luctus et ultrices posuere cubilia \nCurae; Donec at hendrerit tellus. Cras sem felis, vulputate eget \nvenenatis malesuada, auctor eget quam. Morbi suscipit nulla tellus, \ncursus rutrum ligula.\n<br>');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `nivel` enum('1','2') DEFAULT '2' COMMENT '1 - Administrador e 2 - Usuário',
  `dataCadastro` datetime DEFAULT NULL,
  `dataAcesso` datetime DEFAULT NULL,
  `status` enum('1','2') DEFAULT '1' COMMENT '1 - ativo\\n2 - inativo\\n',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`email`),
  KEY `INDEXES` (`nome`,`senha`,`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `nivel`, `dataCadastro`, `dataAcesso`, `status`) VALUES
(11, 'Adminitrador', 'admin@admin.com.br', '21232f297a57a5a743894a0e4a801fc3', '1', '2013-03-09 07:27:09', '2013-03-27 10:26:50', '1');

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

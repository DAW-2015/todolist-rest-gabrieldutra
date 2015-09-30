-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 30-Set-2015 às 08:28
-- Versão do servidor: 5.5.38-0ubuntu0.14.04.1
-- versão do PHP: 5.5.9-1ubuntu4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `daw-aluno3`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `mylist_categories`
--

CREATE TABLE IF NOT EXISTS `mylist_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Extraindo dados da tabela `mylist_categories`
--

INSERT INTO `mylist_categories` (`id`, `category`) VALUES
(9, ''),
(8, '1'),
(5, 'Como criar'),
(10, 'dsadas'),
(3, 'Outros'),
(1, 'Pessoal'),
(4, 'teste'),
(12, 'teste29'),
(6, 'testesa'),
(7, 'testesadsadsa'),
(2, 'Trabalho');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mylist_tasks`
--

CREATE TABLE IF NOT EXISTS `mylist_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`),
  KEY `fk_categoryid` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Extraindo dados da tabela `mylist_tasks`
--

INSERT INTO `mylist_tasks` (`id`, `user_id`, `category_id`, `description`) VALUES
(1, 1, 1, 'teste'),
(2, 1, 2, 'teste3'),
(3, 1, 3, 'dsaddas'),
(4, 1, 4, 'tedsads'),
(5, 1, 5, 'adadsa'),
(8, 1, 1, 'testeaaa'),
(9, 1, 1, 'teste2'),
(13, 1, 2, 'teste2'),
(14, 1, 2, 'testedasadsdsa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mylist_users`
--

CREATE TABLE IF NOT EXISTS `mylist_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `login` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Extraindo dados da tabela `mylist_users`
--

INSERT INTO `mylist_users` (`id`, `name`, `email`, `login`, `password`) VALUES
(1, 'teste22', 'teste@teste', 'teste', 'teste'),
(3, 'absabs', 'nesk@abs', 'absabs', 'absabs'),
(4, 'testeaaa', 'testea@aaa', 'testea', 'ateste'),
(5, 'Gabriel', 'nesk.frz@gmail.com', 'neskfrz', 'Ne4sk6655'),
(6, 'Teste da Silva', 'teste@teste', 'testee', 'testee'),
(7, 'Teste da Silva', 'teste2@teste', 'testee2', 'teste2e'),
(13, 'teste', 'testesa@teste', 'testesa', 'teste');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `mylist_tasks`
--
ALTER TABLE `mylist_tasks`
  ADD CONSTRAINT `fk_categoryid` FOREIGN KEY (`category_id`) REFERENCES `mylist_categories` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `mylist_users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

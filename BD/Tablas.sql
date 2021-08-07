-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.30-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla bingo.cantado
CREATE TABLE IF NOT EXISTS `cantado` (
  `NumeroCantado` int(11) NOT NULL,
  `juego_NumeroJuego` int(11) NOT NULL,
  `FechaHora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `NumeroCantado_juego_NumeroJuego` (`NumeroCantado`,`juego_NumeroJuego`),
  KEY `FK_cantado_juego` (`juego_NumeroJuego`),
  CONSTRAINT `FK_cantado_juego` FOREIGN KEY (`juego_NumeroJuego`) REFERENCES `juego` (`NumeroJuego`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bingo.carton_bingo
CREATE TABLE IF NOT EXISTS `carton_bingo` (
  `NumeroCartonBingo` int(11) NOT NULL AUTO_INCREMENT,
  `b_1` int(11) DEFAULT NULL,
  `b_2` int(11) DEFAULT NULL,
  `b_3` int(11) DEFAULT NULL,
  `b_4` int(11) DEFAULT NULL,
  `b_5` int(11) DEFAULT NULL,
  `i_1` int(11) DEFAULT NULL,
  `i_2` int(11) DEFAULT NULL,
  `i_3` int(11) DEFAULT NULL,
  `i_4` int(11) DEFAULT NULL,
  `i_5` int(11) DEFAULT NULL,
  `n_1` int(11) DEFAULT NULL,
  `n_2` int(11) DEFAULT NULL,
  `n_4` int(11) DEFAULT NULL,
  `n_5` int(11) DEFAULT NULL,
  `g_1` int(11) DEFAULT NULL,
  `g_2` int(11) DEFAULT NULL,
  `g_3` int(11) DEFAULT NULL,
  `g_4` int(11) DEFAULT NULL,
  `g_5` int(11) DEFAULT NULL,
  `o_1` int(11) DEFAULT NULL,
  `o_2` int(11) DEFAULT NULL,
  `o_3` int(11) DEFAULT NULL,
  `o_4` int(11) DEFAULT NULL,
  `o_5` int(11) DEFAULT NULL,
  `NombreComprador` varchar(300) DEFAULT NULL,
  `NumeroManual` int(11) DEFAULT NULL,
  PRIMARY KEY (`NumeroCartonBingo`),
  UNIQUE KEY `NumeroManual` (`NumeroManual`)
) ENGINE=InnoDB AUTO_INCREMENT=482 DEFAULT CHARSET=latin1;
-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bingo.juego
CREATE TABLE IF NOT EXISTS `juego` (
  `NumeroJuego` int(11) NOT NULL AUTO_INCREMENT,
  `FechaJuego` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`NumeroJuego`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

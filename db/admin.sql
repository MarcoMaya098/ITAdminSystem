-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2022 at 05:51 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP-Ingreso` (IN `mesI` INT, IN `mesF` INT, IN `year` INT, IN `idUsuario` INT)  BEGIN
    SET @mes1 = mesI;
SET @mes2 = mesF;
SET @yearv = year;
SET @idusuario = idUsuario;

SET @start = CONCAT(@yearv,'-',@mes1,'-01');
SET @end = CONCAT(@yearv,'-',@mes2,'-01');

(SELECT SUM(cantidad) Ingresos, SUM(iva) TotalIva 
FROM `ingresos` WHERE fecha BETWEEN @start AND LAST_DAY(@end) AND usuario=@idusuario );  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Gasto` (IN `mesI` INT, IN `mesF` INT, IN `año` INT, IN `idUsuario` INT)  BEGIN
SET @mes1 = mesI;
SET @mes2 = mesF;
SET @yearv = año;
SET @ivaporciento8 = 8;
SET @ivaporciento16 = 16;
SET @idusuario = idUsuario;

SET @start = CONCAT(@yearv,'-',@mes1,'-01');
SET @end = CONCAT(@yearv,'-',@mes2,'-01');

Set @total8 = (SELECT COALESCE ((SELECT SUM(cantidad)
FROM `gastos` WHERE fecha BETWEEN @start AND LAST_DAY(@end) AND ivaporcentaje = @ivaporciento8 AND usuario=@idusuario ),0));

SET @total16 = (SELECT COALESCE ((SELECT SUM(cantidad) FROM `gastos` WHERE fecha BETWEEN @start AND LAST_DAY(@end) AND ivaporcentaje = @ivaporciento16 AND usuario=@idusuario ),0)); 

Set @totaliva8 = (SELECT COALESCE ((SELECT SUM(iva)
FROM `gastos` WHERE fecha BETWEEN @start AND LAST_DAY(@end) AND ivaporcentaje = @ivaporciento8 AND usuario=@idusuario ),0));

SET @totaliva16 = (SELECT COALESCE ((SELECT SUM(iva) FROM `gastos` WHERE fecha BETWEEN @start AND LAST_DAY(@end) AND ivaporcentaje = @ivaporciento16 AND usuario=@idusuario ),0)); 

SET @ivatotal = (SELECT COALESCE ((SELECT SUM(iva) FROM `gastos` WHERE fecha BETWEEN @start AND LAST_DAY(@end) AND usuario=@idusuario),0)); 

SET @suma = @total8 + @total16;
SELECT @total8 AS GastoPagado8 , @total16 AS GastoPagado16, @totaliva16 AS iva16 , @totaliva8 AS iva8, @suma AS SumaGastos, @ivatotal  AS IvaRetenido;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Mensual` (IN `mes` INT, IN `year` INT, IN `idUsuario` INT)  BEGIN
SET @mes1 = mes;
SET @yearv = year;
SET @start = CONCAT(@yearv,'-',@mes1,'-01');
SET @end = CONCAT(@yearv,'-',@mes1,'-01');
SET @idusuario = idUsuario;
SET @gasto = 'Gasto';
SET @ingreso = 'Ingreso';

SELECT * FROM (
SELECT concepto, fecha, cantidad, @gasto AS Tipo
FROM gastos 
	WHERE fecha BETWEEN @start AND LAST_DAY(@end) AND usuario=@idusuario     
UNION ALL SELECT concepto, fecha, cantidad, @ingreso AS Tipo
FROM ingresos
 	WHERE fecha BETWEEN @start AND LAST_DAY(@end) AND usuario=@idusuario )
a ORDER BY fecha;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_TotalAnual` (IN `year` INT, IN `idUsuario` INT)  BEGIN

SET @yearv = year;
SET @start = CONCAT(@yearv,'-01-01');
SET @end = CONCAT(@yearv,'-12-31');
SET @idusuario = idUsuario;

SET @Totalingreso = (SELECT COALESCE ((SELECT SUM(cantidad) FROM ingresos WHERE fecha BETWEEN @start AND LAST_DAY(@end) AND usuario=@idusuario),0));
SET @Totalgasto = (SELECT COALESCE ((SELECT SUM(cantidad) FROM gastos WHERE fecha BETWEEN @start AND LAST_DAY(@end) AND usuario=@idusuario ),0));
SET @diferencia = @Totalingreso -  @Totalgasto;
SELECT @Totalingreso AS tIngreso, @Totalgasto AS tGasto, @diferencia AS dAnual;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_TOTALCHART` (IN `idUsuario` INT)  BEGIN
SET @idusuario = idUsuario;

SET @Totalingreso = (SELECT COALESCE ((SELECT SUM(cantidad) FROM ingresos WHERE usuario=@idusuario),0));
SET @Totalgasto = (SELECT COALESCE ((SELECT SUM(cantidad) FROM gastos WHERE usuario=@idusuario),0));

SET @diferencia = @Totalingreso -  @Totalgasto;
SET @suma = @Totalingreso +  @Totalgasto;
SET @gastoChart = @Totalgasto/@suma*100;
SET @ingresoChart = @Totalingreso/@suma*100;

SELECT @Totalingreso AS tIngreso, @Totalgasto AS tGasto, @diferencia AS dChart, @suma as suma, @gastoChart as gastoChart, @ingresoChart as ingresoChart;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_TotalMensual` (IN `mes` INT, IN `year` INT, IN `idUsuario` INT)  BEGIN
SET @mes1 = mes;
SET @yearv = year;
SET @start = CONCAT(@yearv,'-',@mes1,'-01');
SET @end = CONCAT(@yearv,'-',@mes1,'-01');
SET @idusuario = idUsuario;

SET @Totalingreso = (SELECT COALESCE ((SELECT SUM(cantidad) FROM ingresos WHERE fecha BETWEEN @start AND LAST_DAY(@end) AND usuario=@idusuario ),0));
SET @Totalgasto = (SELECT COALESCE ((SELECT SUM(cantidad) FROM gastos WHERE fecha BETWEEN @start AND LAST_DAY(@end) AND usuario=@idusuario),0));
SET @diferencia = @Totalingreso -  @Totalgasto;
SELECT @Totalingreso AS ingresoTotal, @Totalgasto AS gastoTotal, @diferencia AS diferencia;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `empresa`
--

CREATE TABLE `empresa` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `active_service` varchar(1) NOT NULL,
  `is_enable` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `empresa`
--

INSERT INTO `empresa` (`id`, `name`, `address`, `zip_code`, `state`, `country`, `phone`, `active_service`, `is_enable`) VALUES
(1, 'Samsumg', 'Tijuana, Otay #367', '87121', 'Baja California', 'Mexico', '664-901-2811', 'Y', ''),
(2, 'Despacho binacional', 'Tijuana, Mariano Matamoros', '87132', 'San Diego', 'USA', '664-901-2890', 'Y', '');

-- --------------------------------------------------------

--
-- Table structure for table `gastos`
--

CREATE TABLE `gastos` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `moneda` varchar(11) NOT NULL,
  `tipoCambio` decimal(10,2) NOT NULL,
  `ivaporcentaje` int(11) NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gastos`
--

INSERT INTO `gastos` (`id`, `fecha`, `concepto`, `cantidad`, `moneda`, `tipoCambio`, `ivaporcentaje`, `iva`, `usuario`) VALUES
(2, '2022-07-29', 'Servicios publicos', '800.00', 'Pesos', '0.00', 8, '64.00', 1),
(3, '2022-08-16', 'Gasolina', '900.00', 'Pesos', '0.00', 16, '144.00', 1),
(5, '2022-08-16', 'Pasajes de avión', '1500.00', 'Pesos', '0.00', 8, '240.00', 1),
(8, '2022-08-04', 'Servicios publicos', '800.00', 'Pesos', '0.00', 16, '120.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ingresos`
--

CREATE TABLE `ingresos` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `empresa` varchar(100) NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `moneda` varchar(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `tipoCambio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ingresos`
--

INSERT INTO `ingresos` (`id`, `fecha`, `cantidad`, `iva`, `empresa`, `concepto`, `moneda`, `usuario`, `tipoCambio`) VALUES
(1, '2022-09-08', '2000.00', '160.00', 'samsung', 'instalacion de camaras', 'Pesos', 1, '0.00'),
(2, '2022-08-19', '4000.00', '1200.00', 'samsung', 'Soporte tecnico', 'Dolares', 1, '20.00'),
(3, '2022-08-03', '3000.00', '240.00', 'samsung', 'desarrollo de software', 'Pesos', 1, '0.00'),
(4, '2022-10-20', '3640.00', '640.00', 'Despacho binacional', 'Desarrollo Frontend', 'Dolares', 1, '20.00');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `clave` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `clave`) VALUES
(1, 'admin', '04ddc4a20d5239be4fd6c59bb642188853a642700442988ff94487130469ed639ba3b4399d7b3a1dc9a431b2c2d8a285d69b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

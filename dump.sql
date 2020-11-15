/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `distanze`
--

DROP TABLE IF EXISTS `distanze`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distanze` (
  `id_negozio` int NOT NULL,
  `id_azienda` int NOT NULL,
  `distanza` int NOT NULL,
  PRIMARY KEY (`id_negozio`,`id_azienda`),
  KEY `fk_azienda_idx` (`id_azienda`),
  CONSTRAINT `fk_azienda` FOREIGN KEY (`id_azienda`) REFERENCES `utenti` (`id`),
  CONSTRAINT `fk_negozio` FOREIGN KEY (`id_negozio`) REFERENCES `utenti` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `distanze`
--

LOCK TABLES `distanze` WRITE;
/*!40000 ALTER TABLE `distanze` DISABLE KEYS */;
/*!40000 ALTER TABLE `distanze` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prodotti`
--

DROP TABLE IF EXISTS `prodotti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prodotti` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pubblicazione` datetime NOT NULL,
  `id_negozio` int NOT NULL,
  `descrizione` varchar(255) NOT NULL,
  `fresco` bit(1) NOT NULL,
  `stato` char(3) NOT NULL,
  `id_utente` int DEFAULT NULL,
  `quantita` varchar(45) DEFAULT NULL,
  `data_ritiro` datetime DEFAULT NULL,
  `id_tipo` int DEFAULT NULL,
  `data_scadenza` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `negozio_idx` (`id_negozio`),
  KEY `utente_prenotato_idx` (`id_utente`),
  KEY `tipo_prodotto_idx` (`id_tipo`),
  CONSTRAINT `negozio` FOREIGN KEY (`id_negozio`) REFERENCES `utenti` (`id`),
  CONSTRAINT `tipo_prodotto` FOREIGN KEY (`id_tipo`) REFERENCES `tipi_prodotti` (`id`),
  CONSTRAINT `utente_prenotato` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=latin1 COMMENT='id, data pubblicazione, id utente che pubblica, nome prodotto, fresco(si,no),stato, id utente preso o prenotato(anche nullo)';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prodotti`
--

LOCK TABLES `prodotti` WRITE;
/*!40000 ALTER TABLE `prodotti` DISABLE KEYS */;
/*!40000 ALTER TABLE `prodotti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipi_prodotti`
--

DROP TABLE IF EXISTS `tipi_prodotti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipi_prodotti` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `icona` varchar(45) NOT NULL,
  `unita_misura` varchar(6) NOT NULL,
  `theme` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipi_prodotti`
--

LOCK TABLES `tipi_prodotti` WRITE;
/*!40000 ALTER TABLE `tipi_prodotti` DISABLE KEYS */;
INSERT INTO `tipi_prodotti` VALUES (1,'Pasta','ico/pasta.svg','kg','blue'),(2,'Riso','ico/riso.svg','kg','blue'),(3,'Legumi','ico/legumi.svg','kg','blue'),(4,'Biscotti','ico/biscotti.svg','kg','blue'),(5,'Zucchero','ico/zucchero.svg','kg','blue'),(6,'Caffe\'','ico/caffe.svg','kg','blue'),(7,'Farina','ico/farina.svg','kg','blue'),(8,'Pelati','ico/pelati.svg','kg','blue'),(9,'Formaggi','ico/formaggi.svg','kg','red'),(10,'Latte','ico/latte.svg','lt','red'),(11,'Affettati','ico/affettati.svg','kg','red'),(14,'Verdura','ico/verdura.svg','kg','red'),(15,'Frutta','ico/frutta.svg','kg','red'),(16,'Pane','ico/pane.svg','kg','red'),(17,'Surgelati','ico/surgelati.svg','conf','green'),(18,'Carne','ico/carne.svg','kg','green'),(19,'Pesce','ico/pesce.svg','kg','green'),(20,'Scatolame','ico/tuna.svg','kg','green'),(21,'Pannolini','ico/pannolini.svg','conf','purple'),(22,'Omogeneizzati','ico/omogeneizzati.svg','kg','purple'),(24,'Altro','ico/altro.svg','kg','pink');
/*!40000 ALTER TABLE `tipi_prodotti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utenti`
--

DROP TABLE IF EXISTS `utenti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utenti` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `cognome` varchar(45) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` char(128) NOT NULL,
  `indirizzo` varchar(200) NOT NULL,
  `tipo` char(3) NOT NULL,
  `orariApertura` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utenti`
--

LOCK TABLES `utenti` WRITE;
/*!40000 ALTER TABLE `utenti` DISABLE KEYS */;
INSERT INTO `utenti` VALUES (1,'Admin','Admin','admin@mirror.cc','$2y$10$xA5L/eIi1f6O0tY3qiKbe.mZzwQvkKkM3pnQphal0ygUIDHBuFX8m','','ADM',NULL);
/*!40000 ALTER TABLE `utenti` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

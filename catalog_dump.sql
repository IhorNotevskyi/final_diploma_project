-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: localhost    Database: catalog
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu0.17.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `callback`
--

DROP TABLE IF EXISTS `callback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `callback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '',
  `phone` varchar(14) NOT NULL,
  `message` varchar(255) DEFAULT '',
  `active` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `callback`
--

LOCK TABLES `callback` WRITE;
/*!40000 ALTER TABLE `callback` DISABLE KEYS */;
INSERT INTO `callback` VALUES (1,'Mike','(534) 534-5345','Some long text',1,'2018-07-02 10:23:52'),(2,NULL,'(432) 423-4234',NULL,1,'2018-07-01 04:24:25'),(3,NULL,'(534) 534-5345',NULL,1,'2018-07-01 05:06:00'),(4,NULL,'(555) 555-5555',NULL,1,'2018-07-01 20:24:29'),(5,'Kevin','(093) 999-9999','Say some idiocy',0,'2018-07-01 20:34:57'),(6,'Paul','(543) 554-3534','Say say say',1,'2018-07-01 20:36:37'),(7,'Kav','(432) 432-4234','Bob bill buty',1,'2018-07-01 21:24:20'),(8,NULL,'(432) 423-4234',NULL,0,'2018-07-01 23:37:53'),(9,'Ann','(543) 534-5345',NULL,1,'2018-07-02 18:10:08');
/*!40000 ALTER TABLE `callback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_64C19C15E237E06` (`name`),
  UNIQUE KEY `UNIQ_64C19C1C53D045F` (`image`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Consequuntur',1,'http://localhost:8000/img/b94dbeeba6ec6d9593c7c801bab888b9.jpeg','Latis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia.'),(2,'Numquam',1,'http://localhost:8000/img/9f628a24bc576409df4c2b5879ae808a.jpeg','Velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum.'),(3,'Reprehenderit',0,'http://localhost:8000/img/cf85cb2ed02c384f6c788eea87247fd2.jpeg','Ngs of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again.'),(4,'Laborious',1,'http://localhost:8000/img/2db40206973b7b1cf511bbf8681efc81.jpeg','Mos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime pla.'),(5,'Praesentium',1,'http://localhost:8000/img/8f207fec24b5dfa976c31e8d26d41e51.jpeg','Because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some af.');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D34A04ADC53D045F` (`image`),
  KEY `IDX_D34A04AD12469DE2` (`category_id`),
  CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,1,'Sed quia non numquam','Latis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia.',53453.00,0,'http://localhost:8000/img/0a1f795901921b3163af950d920eebb6.png'),(2,2,'Quis nostrum exercitationem ullam corporis','Velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum.',86867.00,1,'http://localhost:8000/img/0a5d5f3b5943f5c6672b561b7a4277d9.jpeg'),(3,3,'Except to obtain some advantage','Ngs of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again.',37212.00,1,'http://localhost:8000/img/0becf9393fe4bc0299f22283cd01253e.png'),(4,4,'Quia consequuntur magni dolores','Mos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime pla.',53453.00,1,'http://localhost:8000/img/d29563fd9860f508f82b299896b6f842.png'),(5,5,'Itate non provident, similique su','Because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some af.',21312.00,0,'http://localhost:8000/img/806a71493e95e335db59637669930cf8.jpeg'),(6,2,'Et harum quidem rerum fac','Tate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus.',23131.00,1,'http://localhost:8000/img/8580456210286e253f41afcf0d1ea755.png'),(7,2,'Omnis voluptas assumenda est','Is voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.',34535.00,1,'http://localhost:8000/img/4b93f3f840160f22863cf07669a520bc.jpeg'),(8,3,'The pain and trouble that are bound','Ur duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to disting.',96456.00,1,'http://localhost:8000/img/81dd8da04a37da1ea0077f30296a56b3.png'),(9,1,'Welcomed and eve','Our when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures hyu.',42312.00,1,'http://localhost:8000/img/b2824ff8a2b6e973efe6c2fc828a21a1.png'),(10,5,'Ninot foresee the das','Ve to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.',23444.00,1,'http://localhost:8000/img/d940ba013bb6a6cb6e64b99b1f7ce9d2.png'),(11,3,'Xime placeat face','On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that the hil.',42427.00,1,'http://localhost:8000/img/d34d2bed1b570b35b63ae3dec49ca979.png'),(12,1,'Ni our power of choice','Annot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that plea.',75466.00,1,'http://localhost:8000/img/18bdbb1ce12b699fe67a777bf1d747b4.png'),(13,3,'Thi pleasures have to be rep','Reat explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to hip.',54435.00,1,'http://localhost:8000/img/7fa15c271a838a48fa72ec4a5c5cfa32.png'),(14,3,'Ations of business it will','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',48574.00,1,'http://localhost:8000/img/b2325498e99c4feb70cecfdc0a53fa26.png'),(15,4,'As saying through shri','Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur mak.',93474.00,1,'http://localhost:8000/img/fa6b57c2ffeecca5fcfbe333c8c8327f.png'),(16,3,'Uently occur that pleasures hag','Gni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?',21343.00,1,'http://localhost:8000/img/87a35b57047c068dd45af0bb980e3609.png'),(17,5,'Ays holds in these matters','Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',43847.00,1,'http://localhost:8000/img/0ef1ffb1b7e02a747fc82a427d5b169f.png'),(18,4,'Pain avoided','Xtremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise.',72383.00,1,'http://localhost:8000/img/49f47332083d73621634a8153f16cc23.jpeg'),(19,1,'Nsequences that are extr','Ovident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reh.',21344.00,1,'http://localhost:8000/img/66ec20ff601371ee7e5c9a3aaa49f914.jpeg'),(20,4,'Du pain can procure him some','Kness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that ple.',32748.00,1,'http://localhost:8000/img/0b6ffea4d26270682815bcf6d3e85c2a.jpeg');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_tag`
--

DROP TABLE IF EXISTS `product_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_tag` (
  `product_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`tag_id`),
  KEY `IDX_E3A6E39C4584665A` (`product_id`),
  KEY `IDX_E3A6E39CBAD26311` (`tag_id`),
  CONSTRAINT `FK_E3A6E39C4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_E3A6E39CBAD26311` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_tag`
--

LOCK TABLES `product_tag` WRITE;
/*!40000 ALTER TABLE `product_tag` DISABLE KEYS */;
INSERT INTO `product_tag` VALUES (1,5),(1,7),(2,7),(2,8),(3,5),(3,9),(4,11),(4,15),(5,18),(6,13),(7,14),(7,15),(8,16),(9,18),(9,19),(10,78),(11,5),(12,7),(13,8),(13,9),(14,11),(15,13),(16,14),(16,15),(17,15),(17,16),(18,18),(18,19),(19,9),(19,71),(20,19),(20,86);
/*!40000 ALTER TABLE `product_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_389B7835E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (18,'Abfipol'),(16,'Avionfur'),(71,'Blintu'),(11,'Blokor'),(13,'Cripol'),(15,'Elilulilu'),(8,'Euma'),(86,'Lolipop'),(9,'Lorem'),(78,'Quinones'),(5,'Quis'),(19,'Qurby'),(7,'Velar'),(14,'Vinidabor');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(254) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `roles` json NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','$2y$13$1NwszxF30saxvUvdqANWQOX44ALRZPZIjVgDb2bypOUOuCKIY5sxW','admin@example.com',1,'[\"ROLE_USER\", \"ROLE_ADMIN\"]'),(8,'root15','$2y$13$oFBMjqAXCok5c38m4vP/fenxQ7vlhEq/8OkTx2S9UYcVKf4Nm.B4e','roo15@example.com',1,'[\"ROLE_USER\"]'),(9,'blog','$2y$13$YjQdX5dm7EzoVweS/zCWce1eTEz95AsZcc3gA4F8YfP9R5V5KfBgK','blog@blog.com',0,'[\"ROLE_USER\"]'),(10,'bodron','$2y$13$d4U2t2D82w5JlDBui8bW/OtVTN9qm80sUIe872/0CFy1MMaGPMQ..','bodron@bodron.ua',0,'[\"ROLE_USER\"]'),(12,'user','$2y$13$1LEWj2AJf2CkZssMC6rUIe2YnzMlCm5Ac0q9PIIbvWR6vDeTH02zG','user@use.com',1,'[\"ROLE_USER\"]'),(16,'abc','$2y$13$uTbyiQdlusYyb.hC/9bZXekhAOZifLyZbGENOSrigR1ZSfhDZmG1.','abc@ukr.com',1,'[\"ROLE_USER\"]');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-07-13  1:13:24

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 25 août 2024 à 12:17
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `booking_bd`
--

-- --------------------------------------------------------

--
-- Structure de la table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `categories` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `blogs`
--

INSERT INTO `blogs` (`id`, `titre`, `image`, `date`, `description`, `categories`, `tags`, `created_at`, `updated_at`) VALUES
(3, 'Maximisez vos économies avec nos offres exclusives : Comment Wanderwise révolutionne la réservation d\'hôtel', 'https://i.imgur.com/dyA6vIi.jpeg https://i.imgur.com/fArGu4U.jpeg https://i.imgur.com/E10B8Ci.jpeg https://i.imgur.com/6uhZvHb.jpeg', '2024-08-22', 'Dans un monde où voyager est devenu une seconde nature pour beaucoup, la question du budget reste primordiale. Que vous planifiiez une escapade romantique, une réunion de famille, ou un voyage d\'affaires, trouver des offres qui respectent votre budget est essentiel. C\'est ici que Wanderwise intervient, en vous proposant des offres exclusives sur une vaste sélection d\'hôtels à travers le monde. Mais qu\'est-ce qui rend ces offres si spéciales, et comment pouvez-vous en tirer le meilleur parti ?\n\n<<Les offres exclusives : Un accès privilégié à des réductions exceptionnelles>>\nContrairement à d\'autres plateformes, Wanderwise a établi des partenariats directs avec des hôtels pour vous offrir des réductions qui ne sont disponibles nulle part ailleurs. Ces offres peuvent inclure des réductions sur les tarifs de chambre, des packages incluant petit-déjeuner gratuit, des surclassements de chambre, ou même des crédits de spa. En vous inscrivant à notre newsletter ou en créant un compte membre, vous accédez à des offres réservées uniquement à notre communauté.\n\n<<Optimiser vos réservations avec les offres saisonnières et de dernière minute>>\nLe timing est crucial lorsqu\'il s\'agit de réserver un hôtel. En utilisant Wanderwise, vous pouvez profiter de nos offres saisonnières, qui sont parfaitement adaptées à la période de l\'année et à votre destination. Par exemple, vous pouvez bénéficier de réductions sur les stations de ski en hiver ou des tarifs avantageux pour les destinations balnéaires en basse saison. Pour les aventuriers de dernière minute, nos offres de dernière minute vous permettent de réserver un hôtel à un prix imbattable, tout en ayant la garantie d\'une chambre de qualité.\n\n<<Programmes de fidélité et avantages pour les membres>>\nEn rejoignant Wanderwise, vous pouvez également profiter de notre programme de fidélité. Chaque réservation vous rapporte des points que vous pouvez utiliser pour des réductions supplémentaires ou des nuits gratuites lors de vos futurs séjours. De plus, nos membres bénéficient souvent d\'avantages supplémentaires, comme des check-ins anticipés, des check-outs tardifs, ou des commodités spéciales à l\'arrivée.\n\n<<Comment ne jamais manquer une bonne affaire>>\nPour ne jamais rater une de nos offres exclusives, nous vous recommandons de télécharger notre application mobile et d\'activer les notifications. Vous serez ainsi toujours informé en temps réel des dernières promotions. Vous pouvez également suivre nos pages sur les réseaux sociaux pour des annonces spéciales et des concours qui pourraient vous faire gagner des séjours gratuits dans certains des meilleurs hôtels du monde.\n\n<<Conclusion>>\nVoyager sans se ruiner est possible grâce à Wanderwise. En tirant parti de nos offres exclusives et en planifiant intelligemment vos réservations, vous pouvez économiser considérablement sur vos séjours tout en profitant d\'une expérience de voyage exceptionnelle. Explorez nos offres aujourd\'hui et préparez-vous à découvrir le monde sans compromis.', 'Offres Spéciales, Économies de Voyage, Réductions Hôtelières, Promotions, Réservations Intelligentes', 'Offres Exclusives, Économies, Réduction, Promotions Saisonnières, Fidélité, Réservation en Ligne', '2024-08-22 08:49:15', '2024-08-22 09:26:12'),
(5, 'Les meilleurs hôtels du monde : Une sélection d\'expériences inoubliables pour les voyageurs exigeants', 'https://i.imgur.com/A89L48r.jpeg https://i.imgur.com/94Bj1sz.jpeg https://i.imgur.com/IyHsYNr.jpeg https://i.imgur.com/yAK5ZJl.jpeg', '2024-08-23', 'Choisir un hôtel ne se résume pas seulement à trouver un endroit pour dormir. Pour beaucoup, c\'est une partie intégrante de l\'expérience de voyage, une extension du voyage lui-même. Wanderwise a parcouru le globe pour dénicher des hôtels qui ne sont pas seulement des lieux d\'hébergement, mais des destinations en soi. Dans cet article, nous vous invitons à découvrir certains des hôtels les plus remarquables au monde, chacun offrant une expérience unique qui transcende le simple séjour.\n\n<<Les hôtels-boutiques : L\'art du détail et du service personnalisé>>\nLes hôtels-boutiques sont souvent de petites propriétés indépendantes, connues pour leur caractère distinctif et leur service personnalisé. Prenons, par exemple, le Riad Fès au Maroc, une magnifique demeure historique transformée en hôtel de luxe. Ici, chaque chambre est décorée avec des matériaux locaux, des mosaïques colorées aux tissus somptueux, et le personnel se fait un devoir d\'anticiper vos moindres besoins. Un séjour dans un hôtel-boutique, c\'est vivre une expérience authentique et intime qui vous connecte profondément avec la culture locale.\n\n<<Les hôtels de luxe : Le summum du confort et du raffinement>>\nPour ceux qui recherchent une expérience ultime en matière de luxe, des établissements comme le Burj Al Arab à Dubaï ou le Ritz Paris offrent une hospitalité sans égale. Ces hôtels ne sont pas seulement des endroits où passer la nuit; ils sont des sanctuaires de raffinement, où chaque détail est pensé pour sublimer votre séjour. Du service de majordome privé aux restaurants étoilés Michelin, en passant par des suites somptueuses avec vue panoramique, ces hôtels redéfinissent les standards du luxe.\n\n<<Les éco-hôtels : Un séjour durable sans compromis sur le confort>>\nAvec la montée en puissance du tourisme durable, de plus en plus de voyageurs cherchent des hôtels qui respectent l\'environnement tout en offrant une expérience mémorable. Des établissements comme le Soneva Fushi aux Maldives, pionnier en matière de luxe durable, proposent des villas en bord de mer construites à partir de matériaux locaux et respectueux de l\'environnement. Ces hôtels offrent également des programmes de conservation, des jardins biologiques, et des activités qui vous permettent de contribuer activement à la protection de la planète, tout en profitant d\'un confort exceptionnel.\n\n<<Les hôtels historiques : Voyagez dans le temps sans quitter votre chambre>>\nCertains hôtels sont des monuments en eux-mêmes, offrant aux visiteurs une immersion dans l\'histoire et la culture d\'une époque révolue. Le Raffles Hotel à Singapour, par exemple, est un joyau architectural du 19e siècle qui a accueilli des légendes du monde entier. Séjourner dans un hôtel historique, c\'est voyager dans le temps, tout en bénéficiant des commodités modernes. Ces établissements allient l\'authenticité historique à un confort raffiné, créant ainsi une expérience de séjour véritablement unique.\n\n<<Conclusion>>\nLes hôtels que vous choisissez lors de vos voyages peuvent transformer un séjour ordinaire en une expérience inoubliable. Que vous soyez à la recherche d\'un service personnalisé dans un hôtel-boutique, d\'un luxe inégalé dans un grand hôtel, ou d\'une retraite écologique dans un éco-hôtel, Wanderwise a sélectionné pour vous les meilleures adresses à travers le monde. Prenez le temps de découvrir ces trésors cachés et préparez-vous à vivre des moments magiques lors de votre prochain voyage.', 'Hôtels de Luxe, Expériences de Voyage, Hôtels Boutique, Hôtels Historiques, Éco-Hôtels', 'Hôtels de Luxe, Hôtels Boutique, Hôtels Écologiques, Hôtels Historiques, Séjour de Luxe, Expérience de Voyage', '2024-08-22 09:16:10', '2024-08-22 09:16:10'),
(6, 'Réserver un hôtel en ligne : Un guide complet pour trouver l\'hébergement parfait', 'https://i.imgur.com/mXDTdRA.jpeg https://i.imgur.com/P88ypiJ.jpeg https://i.imgur.com/JYklJj2.jpeg https://i.imgur.com/DIUsfWY.jpeg', '2024-08-24', 'Dans un monde de plus en plus numérique, la réservation en ligne d\'un hôtel est devenue la norme. Cependant, avec tant d\'options disponibles, il peut être difficile de savoir par où commencer. Chez Wanderwise, nous avons simplifié ce processus pour vous. Dans cet article, nous vous proposons un guide complet pour vous aider à trouver l\'hébergement parfait, tout en tirant parti des meilleures offres et en évitant les pièges courants.\n\n<<1. Commencez par définir vos besoins>>\nLa première étape pour trouver l\'hôtel idéal est de définir clairement ce que vous recherchez. Posez-vous des questions simples : Quel est votre budget ? Préférez-vous un hôtel en centre-ville ou en périphérie ? Avez-vous besoin de commodités spécifiques comme une piscine, un centre de fitness ou un service de garde d\'enfants ? En répondant à ces questions, vous pouvez filtrer les résultats de recherche pour n\'afficher que les hôtels qui correspondent à vos critères.\n\n<<2. Utilisez des filtres pour affiner votre recherche>>\nLes plateformes de réservation en ligne comme Wanderwise proposent des filtres qui vous permettent de préciser votre recherche en fonction de vos préférences. Vous pouvez trier les hôtels par prix, distance par rapport aux points d\'intérêt, note des utilisateurs, et type d\'hébergement. En utilisant ces filtres, vous gagnez du temps et trouvez rapidement les options qui répondent à vos attentes.\n\n<<3. Comparez les avis et les notes des utilisateurs>>\nLes avis des utilisateurs sont une mine d\'or d\'informations pour choisir un hôtel. Lisez attentivement les commentaires pour avoir une idée de l\'expérience des autres voyageurs. Recherchez des informations sur la propreté, la qualité du service, et l\'emplacement. Attention toutefois à ne pas vous fier uniquement aux extrêmes : les avis très négatifs ou très positifs peuvent parfois être biaisés. Essayez de repérer des tendances générales dans les retours des clients.\n\n<<4. Vérifiez les politiques de l\'hôtel>>\nAvant de finaliser votre réservation, assurez-vous de bien comprendre les politiques de l\'hôtel. Par exemple, vérifiez les conditions d\'annulation, les frais supplémentaires éventuels (comme les taxes de séjour), et les horaires d\'enregistrement et de départ. Si vous voyagez avec des enfants ou des animaux de compagnie, assurez-vous que l\'hôtel est adapté à vos besoins.\n\n<<5. Profitez des offres spéciales et des programmes de fidélité>>\nLorsque vous réservez avec Wanderwise, vous avez accès à des offres spéciales qui peuvent vous permettre d\'économiser sur votre séjour. Recherchez les promotions, les codes de réduction, et les offres groupées qui incluent le petit-déjeuner ou d\'autres commodités. Si vous voyagez fréquemment, envisagez de rejoindre un programme', 'Réservation d\'Hôtel, Guides de Voyage, Conseils de Réservation, Astuces de Voyage, Sélection d\'Hébergement', 'Réservation en Ligne, Conseils de Réservation, Sélection d\'Hôtel, Avis d\'Hôtel, Comparaison des Tarifs, Offres Spéciales', '2024-08-22 09:21:32', '2024-08-22 09:21:32');

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `chambres`
--

CREATE TABLE `chambres` (
  `num_chambre` varchar(255) NOT NULL,
  `code_hb` varchar(255) NOT NULL,
  `disponibilite` tinyint(1) NOT NULL,
  `prix_par_nuit` double NOT NULL,
  `nb_personnes_max` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chambres`
--

INSERT INTO `chambres` (`num_chambre`, `code_hb`, `disponibilite`, `prix_par_nuit`, `nb_personnes_max`, `description`, `created_at`, `updated_at`) VALUES
('1H3', 'H3', 1, 100, 3, 'Chaque chambre est équipée de deux lits de 1,10 m de large chacun, offrant ainsi suffisamment d\'espace pour une nuit de sommeil paisible et confortable. Les chambres disposent également d\'un téléphone direct, d\'un mini-bar, d\'une télévision par satellite et de la climatisation individuelle pour une expérience de séjour agréable.', '2024-08-20 10:18:27', '2024-08-20 10:18:27'),
('C1H1', 'H1', 1, 100, 2, 'Chambre Standard', '2024-08-20 09:53:26', '2024-08-20 09:53:26'),
('C1H2', 'H2', 0, 150, 3, 'Chambre Standard avec balcon', '2024-08-20 10:05:31', '2024-08-20 10:24:04'),
('C2H1', 'H1', 1, 150, 2, 'Chambre Supérieure', '2024-08-20 09:54:40', '2024-08-20 09:54:40'),
('C2H2', 'H2', 1, 500, 4, 'Chambre Familiale avec balcon', '2024-08-20 10:06:58', '2024-08-20 10:06:58'),
('C3H2', 'H2', 1, 1000, 3, 'Suite avec balcon - Vue sur la mer', '2024-08-20 10:09:03', '2024-08-20 10:09:03'),
('Ex1H1', 'H1', 0, 250, 3, 'Chambres Exécutive', '2024-08-20 09:55:24', '2024-08-20 10:22:22'),
('SH3', 'H3', 1, 250, 3, 'Nos suites spacieuses et confortables de notre hôtel offrent une vue imprenable sur la mer et sont équipées de tout ce dont vous avez besoin pour un séjour inoubliable.', '2024-08-20 10:21:11', '2024-08-25 09:15:22'),
('SSH1', 'H1', 0, 999, 4, 'Suite Présidentielle', '2024-08-20 09:55:57', '2024-08-20 10:25:08');

-- --------------------------------------------------------

--
-- Structure de la table `dashusers`
--

CREATE TABLE `dashusers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `date_naiss` date NOT NULL,
  `IDCARD` varchar(255) DEFAULT NULL,
  `nationalite` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `genre` enum('H','F') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `dashusers`
--

INSERT INTO `dashusers` (`id`, `nom`, `prenom`, `date_naiss`, `IDCARD`, `nationalite`, `email`, `password`, `genre`, `created_at`, `updated_at`) VALUES
(4, 'admin', '456', '2000-01-01', NULL, 'Tunisie', 'admin@gmail.com', '$2y$12$lsMTyZFn0cNOFQvXpsKVyuUV/i/ZKfone/8teyE/MkBKvZPK1BImC', 'H', '2024-08-19 08:25:12', '2024-08-19 08:25:12'),
(5, 'ali', 'ali', '1999-01-01', '01234567', 'Tunisie', 'ali@gmail.com', '$2y$12$RMIVsVBUtNgU63Z1wL/Nge.z2GgBUZd.Rm2EsNjxqJg06gV0bH8N2', 'H', '2024-08-20 09:41:17', '2024-08-20 09:41:17'),
(6, 'Samira', 'Samira', '2000-10-10', '11111111', 'Maroc', 'samira@yahoo.fr', '$2y$12$gQaSh8CxjvOtxjwcq09PO.mdRAAA1Tv2O7hLIw1.iSnUj5M5PDR7i', 'F', '2024-08-20 09:41:51', '2024-08-20 09:41:51');

-- --------------------------------------------------------

--
-- Structure de la table `disponibilites`
--

CREATE TABLE `disponibilites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code_hb` bigint(20) UNSIGNED NOT NULL,
  `num_chambre` bigint(20) UNSIGNED NOT NULL,
  `date_min` date NOT NULL,
  `date_max` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `hebergements`
--

CREATE TABLE `hebergements` (
  `code_hb` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `type` enum('hotel','maison','appartement','villa') NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `nbr_de_chambres` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `pts_forts` text DEFAULT NULL,
  `num_tel` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `hebergements`
--

INSERT INTO `hebergements` (`code_hb`, `nom`, `type`, `adresse`, `nbr_de_chambres`, `description`, `pts_forts`, `num_tel`, `created_at`, `updated_at`) VALUES
('H1', 'El Mouradi Gammarth', 'hotel', 'Les côtes de Carthage, La Marsa, Tunis, BP 597-2070, Gammarth, Tunisie', 506, 'L’hôtel offre 506 chambres dont 337 chambres standards, 92 chambres supérieures, 54 chambres exécutives, 22 suites juniors et 1 suite présidentielle spacieuses et lumineuses, les chambres avec terrasse ou balcon offrent toutes une superbe vue sur la piscine ou sur les jardins verdoyants.\n\nL\'hôtel EL Mouradi Gammarth offre des chambres confortables équipées de l\'air conditionné, du chauffage individuel, d\'une salle de bains avec sèche cheveux, du téléphone direct, d\'un mini-bar, de la télévision satellite, du chauffage individuel, un coffre-fort sécurisé et d\'internet haut débit .\n\nEntre plage et forêt, proche de Tunis et des vestiges de Carthage, El Mouradi Gammarth est admirablement situé pour accueillir vos séjours d’affaires et vos moments de détente.', 'Pieds dans l\'eau, Front de mer, Chauffage, Climatisation, Salle de bains avec baignoire, Salle de bains Privative, Coffre fort dans la chambre, Douche, Wi-Fi gratuit', '71 000 000', '2024-08-20 09:51:12', '2024-08-20 09:51:12'),
('H2', 'Radisson Blu Resort & Thalasso, Hammamet', 'hotel', 'Avenue Hedi Nouira, Hammamet, 8050, Tunisie', 450, 'Le Radisson Blu Resort & Thalasso offre un endroit paisible pour se reposer sur les bords de la Méditerranée. Les plages sublimes de sable blanc ponctuées de citronniers et d’oliviers donnent à Hammamet son surnom de « station balnéaire aux magnifiques jardins ». Un arrêt de bus se trouve à 500 m de l’hôtel ; il est donc très facile de partir découvrir les sites environnants.\n\nTrois restaurants vous proposent une cuisine méditerranéenne, tunisienne ou internationale, tandis que quatre bars servent des boissons rafraîchissantes.\n\nFaites de l’exercice dans le centre de fitness ou détendez-vous au spa. Nous proposons également des prestations comme le service One Touch, ainsi qu’un service de change disponible 24 h/24.', 'Navette aéroport, Navette, Plage, Plage à proximité, Buffet petit-déjeuner, Petit-déjeuner buffet, Paiement sans espèces, Paiement sans espèces, Lits bébé disponibles, Lits bébé disponibles sur demande, Wi-Fi gratuit, Salon de coiffure, Personnel multilingue, Restauration sur place, Restaurant(s) sur place, Service en chambre, Service de chambre, Parking, Protégé, Spa, Centre de spa et de bien-être sur place, Centre de fitness, Tennis, Courts de tennis sur place, Consigne, Sentiers de course, Parcours de course personnalisés autour de l\'hôtel, Coffre-fort', '72 000 111', '2024-08-20 10:03:02', '2024-08-20 10:03:02'),
('H3', 'Bizerta Resort', 'hotel', 'Rue de la Corniche- Sidi Salem-BP:246-7000 Bizerte', 350, 'Un hôtel 4 étoiles de qualité, certifié ISO 9001, ISO 22000 et travelife Gold, de standing international, au Nord- Est de la Tunisie, dans la région de Bizerte, riche de potentialités. Bizerta Resort est situé dans la ville de Bizerte .', 'Wi-Fi gratuit, Bar, Restaurant, Pieds dans l\'eau', '72 436 966', '2024-08-20 10:16:58', '2024-08-20 10:16:58');

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `mime_type` varchar(255) NOT NULL,
  `size` bigint(20) UNSIGNED DEFAULT NULL,
  `code_hb` varchar(255) DEFAULT NULL,
  `num_chambre` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id`, `name`, `path`, `mime_type`, `size`, `code_hb`, `num_chambre`, `created_at`, `updated_at`) VALUES
(4, 'Hotel-586-20240222-114943.jpg', '66c47520b5607.jpg', 'image/jpeg', 66893, 'H1', NULL, '2024-08-20 09:51:12', '2024-08-20 09:51:12'),
(5, 'Hotel-586-20150903-103717.jpg', '66c475210ccd5.jpg', 'image/jpeg', 134799, 'H1', NULL, '2024-08-20 09:51:13', '2024-08-20 09:51:13'),
(6, 'Hotel-586-20150903-103442.jpg', '66c47521543c1.jpg', 'image/jpeg', 143300, 'H1', NULL, '2024-08-20 09:51:13', '2024-08-20 09:51:13'),
(7, 'Hotel-586-20141125-031023.jpg', '66c4752198e3f.jpg', 'image/jpeg', 143912, 'H1', NULL, '2024-08-20 09:51:13', '2024-08-20 09:51:13'),
(8, 'Hotel-586-20141125-031002.jpg', '66c4752257d25.jpg', 'image/jpeg', 146056, 'H1', NULL, '2024-08-20 09:51:14', '2024-08-20 09:51:14'),
(9, 'Hotel-587-20150903-101744.jpg', '66c475a69cf2b.jpg', 'image/jpeg', 130582, NULL, 'C1H1', '2024-08-20 09:53:26', '2024-08-20 09:53:26'),
(10, 'Hotel-587-20150903-101510.jpg', '66c475a6e95dc.jpg', 'image/jpeg', 125071, NULL, 'C1H1', '2024-08-20 09:53:26', '2024-08-20 09:53:26'),
(11, 'Hotel-587-20240222-123354.jpg', '66c475f114c03.jpg', 'image/jpeg', 87580, NULL, 'C2H1', '2024-08-20 09:54:41', '2024-08-20 09:54:41'),
(12, 'Hotel-587-20240222-121338.jpg', '66c475f15fa08.jpg', 'image/jpeg', 62513, NULL, 'C2H1', '2024-08-20 09:54:41', '2024-08-20 09:54:41'),
(13, 'Hotel-587-20240222-123031.jpg', '66c475f1a76db.jpg', 'image/jpeg', 80749, NULL, 'C2H1', '2024-08-20 09:54:41', '2024-08-20 09:54:41'),
(14, '16256-114177-f73259691_3xl.jpg', '66c477e785979.jpg', 'image/jpeg', 772509, 'H2', NULL, '2024-08-20 10:03:03', '2024-08-20 10:03:03'),
(15, '16256-114177-f62759914_3xl.jpg', '66c477e7e0eb2.jpg', 'image/jpeg', 567987, 'H2', NULL, '2024-08-20 10:03:03', '2024-08-20 10:03:03'),
(16, '16256-114177-f62759938_3xl.jpg', '66c477e838b8c.jpg', 'image/jpeg', 691320, 'H2', NULL, '2024-08-20 10:03:04', '2024-08-20 10:03:04'),
(17, '16256-114177-f62759032_3xl.jpg', '66c477e88f654.jpg', 'image/jpeg', 629978, 'H2', NULL, '2024-08-20 10:03:04', '2024-08-20 10:03:04'),
(18, '16256-114177-f62759650_3xl.jpg', '66c477e8cbd70.jpg', 'image/jpeg', 518900, 'H2', NULL, '2024-08-20 10:03:04', '2024-08-20 10:03:04'),
(19, '16256-114177-f62759454_3xl.jpg', '66c4787bcf477.jpg', 'image/jpeg', 153441, NULL, 'C1H2', '2024-08-20 10:05:31', '2024-08-20 10:05:31'),
(20, '16256-114177-f73259555_3xl.jpg', '66c4787c17ba6.jpg', 'image/jpeg', 62975, NULL, 'C1H2', '2024-08-20 10:05:32', '2024-08-20 10:05:32'),
(21, '16256-114177-f73259541_3xl.jpg', '66c4787c588f6.jpg', 'image/jpeg', 59928, NULL, 'C1H2', '2024-08-20 10:05:32', '2024-08-20 10:05:32'),
(22, '16256-114177-f73259543_3xl.jpg', '66c478d2771d9.jpg', 'image/jpeg', 51163, NULL, 'C2H2', '2024-08-20 10:06:58', '2024-08-20 10:06:58'),
(24, '16256-114177-f73259549_3xl.jpg', '66c478d321940.jpg', 'image/jpeg', 54970, NULL, 'C2H2', '2024-08-20 10:06:59', '2024-08-20 10:06:59'),
(26, '16256-114177-f62759982_3xl.jpg', '66c4794faeaeb.jpg', 'image/jpeg', 76397, NULL, 'C3H2', '2024-08-20 10:09:03', '2024-08-20 10:09:03'),
(27, '16256-114177-f62759974_3xl.jpg', '66c4795005ff9.jpg', 'image/jpeg', 130051, NULL, 'C3H2', '2024-08-20 10:09:04', '2024-08-20 10:09:04'),
(28, 'restaurant-kahena-hotel-bizerta-resort.png', '66c47b2b844a8.png', 'image/png', 472624, 'H3', NULL, '2024-08-20 10:16:59', '2024-08-20 10:16:59'),
(29, 'Photo-Stylizer-CEP-4.png', '66c47b2bcbc75.png', 'image/png', 420698, 'H3', NULL, '2024-08-20 10:16:59', '2024-08-20 10:16:59'),
(30, 'BIZERTA_RESORT_3.jpg', '66c47b2c23dfb.jpg', 'image/jpeg', 133889, 'H3', NULL, '2024-08-20 10:17:00', '2024-08-20 10:17:00'),
(31, 'chambre-vue-mer-hotel-bizerte-tunisie-2.jpg', '66c47b848875c.jpg', 'image/jpeg', 217016, NULL, '1H3', '2024-08-20 10:18:28', '2024-08-20 10:18:28'),
(32, 'chambre-vue-mer-hotel-bizerte-tunisie.jpg', '66c47b84d07b1.jpg', 'image/jpeg', 293070, NULL, '1H3', '2024-08-20 10:18:28', '2024-08-20 10:18:28'),
(33, 'Suites-et-Chambres-Bizerta-Resort-6.jpg', '66c47c2885cfa.jpg', 'image/jpeg', 618224, NULL, 'SH3', '2024-08-20 10:21:12', '2024-08-20 10:21:12'),
(34, 'Suites-et-Chambres-Bizerta-Resort-7.jpg', '66c47c28d1289.jpg', 'image/jpeg', 718096, NULL, 'SH3', '2024-08-20 10:21:12', '2024-08-20 10:21:12'),
(35, 'chambre-vue-mer-hotel-bizerte-tunis-4-1-950x633.jpg', '66c47c291d418.jpg', 'image/jpeg', 117615, NULL, 'SH3', '2024-08-20 10:21:13', '2024-08-20 10:21:13');

-- --------------------------------------------------------

--
-- Structure de la table `inbox`
--

CREATE TABLE `inbox` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '2024_07_02_083945_create_reservations_table', 1),
(6, '2024_07_04_135215_create_hebergements_table', 3),
(7, '2024_07_04_140555_create_chambres_table', 4),
(8, '2024_07_08_130402_create_dashusers_table', 5),
(36, '2024_08_19_090815_add_image_to_offres_table', 6),
(99, '0001_01_01_000000_create_users_table', 7),
(100, '0001_01_01_000001_create_cache_table', 7),
(101, '0001_01_01_000002_create_jobs_table', 7),
(102, '2024_07_03_101218_create_personal_access_tokens_table', 7),
(103, '2024_07_08_132654_create_dashusers_table', 7),
(104, '2024_07_08_154332_create_blogs_table', 7),
(105, '2024_07_09_083356_create_offres_table', 7),
(106, '2024_07_10_084545_create_hebergements_table', 7),
(107, '2024_07_10_084617_create_chambres_table', 7),
(108, '2024_07_10_084642_create_reservations_table', 7),
(109, '2024_07_10_131436_create_images_table', 7),
(110, '2024_08_10_112224_create_inbox_table', 7),
(111, '2024_08_17_210028_add_client_to_reservations_table', 7);

-- --------------------------------------------------------

--
-- Structure de la table `offres`
--

CREATE TABLE `offres` (
  `id_offre` varchar(255) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_deb` date NOT NULL,
  `date_fin` date NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `offres`
--

INSERT INTO `offres` (`id_offre`, `titre`, `description`, `date_deb`, `date_fin`, `image`, `created_at`, `updated_at`) VALUES
('0f0533a0-eb2d-42d4-b15c-9bf2a6906778', 'Sun-Kissed Getaway: Summer 2024 Special Offer!', 'Escape to paradise this summer with our exclusive 2024 booking offer! Enjoy up to 25% off on your stay at our luxurious beachfront properties, where golden sands and crystal-clear waters await. Whether you\'re planning a romantic retreat, a fun-filled family vacation, or a solo adventure, our Sun-Kissed Getaway package offers the perfect blend of relaxation and excitement. Book now and take advantage of complimentary breakfast, late checkout, and a special welcome gift upon arrival. This limited-time offer is your ticket to an unforgettable summer escape—don\'t miss out!', '2024-08-19', '2024-08-31', 'https://e1.pxfuel.com/desktop-wallpaper/45/857/desktop-wallpaper-beach-sunset-vertical-summer-vertical-thumbnail.jpg', '2024-08-21 09:23:02', '2024-08-21 09:23:02');

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id_resv` bigint(20) UNSIGNED NOT NULL,
  `client` varchar(255) NOT NULL,
  `date_arr` date NOT NULL,
  `date_dep` date NOT NULL,
  `nbr_adultes` int(11) NOT NULL,
  `nbr_enfants` int(11) NOT NULL,
  `nbr_chambres` int(11) NOT NULL,
  `code_hb` varchar(255) NOT NULL,
  `num_chambre` varchar(255) NOT NULL,
  `prix_total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id_resv`, `client`, `date_arr`, `date_dep`, `nbr_adultes`, `nbr_enfants`, `nbr_chambres`, `code_hb`, `num_chambre`, `prix_total`, `created_at`, `updated_at`) VALUES
(2, '01234567', '2024-08-20', '2024-08-30', 2, 1, 1, 'H1', 'Ex1H1', 2500, '2024-08-20 10:22:21', '2024-08-20 10:22:21'),
(5, '11111111', '2024-08-26', '2024-08-29', 1, 0, 1, 'H1', 'SSH1', 2997, '2024-08-20 10:25:08', '2024-08-20 10:25:08');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('EfslqVfFO2MlBZwbBgt3NL0tqs3JhSo8hkDRyKsi', NULL, '127.0.0.1', 'PostmanRuntime/7.41.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiamdPcHpXQ05QNlVCNk5PaVRDbHRKdUtDQ2NFN2MzNndMMXA0M3YyUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1724319163);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `chambres`
--
ALTER TABLE `chambres`
  ADD PRIMARY KEY (`num_chambre`),
  ADD KEY `chambres_code_hb_foreign` (`code_hb`);

--
-- Index pour la table `dashusers`
--
ALTER TABLE `dashusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dashusers_email_unique` (`email`);

--
-- Index pour la table `disponibilites`
--
ALTER TABLE `disponibilites`
  ADD PRIMARY KEY (`id`,`code_hb`,`num_chambre`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `hebergements`
--
ALTER TABLE `hebergements`
  ADD PRIMARY KEY (`code_hb`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `images_name_unique` (`name`),
  ADD KEY `images_code_hb_foreign` (`code_hb`),
  ADD KEY `images_num_chambre_foreign` (`num_chambre`);

--
-- Index pour la table `inbox`
--
ALTER TABLE `inbox`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `offres`
--
ALTER TABLE `offres`
  ADD PRIMARY KEY (`id_offre`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id_resv`),
  ADD KEY `reservations_code_hb_foreign` (`code_hb`),
  ADD KEY `reservations_num_chambre_foreign` (`num_chambre`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `dashusers`
--
ALTER TABLE `dashusers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `disponibilites`
--
ALTER TABLE `disponibilites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `inbox`
--
ALTER TABLE `inbox`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id_resv` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chambres`
--
ALTER TABLE `chambres`
  ADD CONSTRAINT `chambres_code_hb_foreign` FOREIGN KEY (`code_hb`) REFERENCES `hebergements` (`code_hb`) ON DELETE CASCADE;

--
-- Contraintes pour la table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_code_hb_foreign` FOREIGN KEY (`code_hb`) REFERENCES `hebergements` (`code_hb`) ON DELETE CASCADE,
  ADD CONSTRAINT `images_num_chambre_foreign` FOREIGN KEY (`num_chambre`) REFERENCES `chambres` (`num_chambre`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_code_hb_foreign` FOREIGN KEY (`code_hb`) REFERENCES `hebergements` (`code_hb`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_num_chambre_foreign` FOREIGN KEY (`num_chambre`) REFERENCES `chambres` (`num_chambre`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2021 at 02:26 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jsta_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `hiragana`
--

CREATE TABLE `hiragana` (
  `id_hi` int(11) NOT NULL COMMENT 'hiragana id',
  `kana_hi` tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'kana',
  `roman_hi` tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'kana in roman letters (based on english)',
  `note_hi` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '\'    \'' COMMENT 'magyar note to this kana',
  `note_ehi` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'english note to this kana',
  `learn_hi` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '\'    \'' COMMENT 'how to learn this kana',
  `note_uhi` char(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'usernote id (hi0-hi<X>) (max hi999)',
  `row_hi` char(1) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'which row it is',
  `mod_hi` char(1) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'which modified main row it is'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hiragana`
--

INSERT INTO `hiragana` (`id_hi`, `kana_hi`, `roman_hi`, `note_hi`, `note_ehi`, `learn_hi`, `note_uhi`, `row_hi`, `mod_hi`) VALUES
(1, 'あ', 'a', ' ', ' ', ' ', 'hi0', '-', '-'),
(2, 'い', 'i', ' ', ' ', ' ', 'hi1', '-', '-'),
(3, 'う', 'u', ' ', ' ', ' ', 'hi2', '-', '-'),
(4, 'え', 'e', ' ', ' ', ' ', 'hi3', '-', '-'),
(5, 'お', 'o', ' ', ' ', ' ', 'hi4', '-', '-'),
(6, 'か', 'ka', ' ', ' ', ' ', 'hi5', 'k', '-'),
(7, 'き', 'ki', ' ', ' ', ' ', 'hi6', 'k', '-'),
(8, 'く', 'ku', ' ', ' ', ' ', 'hi7', 'k', '-'),
(9, 'け', 'ke', ' ', ' ', ' ', 'hi8', 'k', '-'),
(10, 'こ', 'ko', ' ', ' ', ' ', 'hi9', 'k', '-'),
(11, 'が', 'ga', ' ', ' ', ' ', 'hi10', 'g', 'k'),
(12, 'ぎ', 'gi', ' ', ' ', ' ', 'hi11', 'g', 'k'),
(13, 'ぐ', 'gu', ' ', ' ', ' ', 'hi12', 'g', 'k'),
(14, 'げ', 'ge', ' ', ' ', ' ', 'hi13', 'g', 'k'),
(15, 'ご', 'go', ' ', ' ', ' ', 'hi14', 'g', 'k'),
(16, 'さ', 'sa', ' ', ' ', ' ', 'hi15', 's', '-'),
(17, 'し', 'shi', ' ', ' ', ' ', 'hi16', 's', '-'),
(18, 'す', 'su', ' ', ' ', ' ', 'hi17', 's', '-'),
(19, 'せ', 'se', ' ', ' ', ' ', 'hi18', 's', '-'),
(20, 'そ', 'so', ' ', ' ', ' ', 'hi19', 's', '-'),
(21, 'ざ', 'za', ' ', ' ', ' ', 'hi20', 'z', 's'),
(22, 'じ', 'ji', ' ', ' ', ' ', 'hi21', 'z', 's'),
(23, 'ず', 'zu', ' ', ' ', ' ', 'hi22', 'z', 's'),
(24, 'ぜ', 'ze', ' ', ' ', ' ', 'hi23', 'z', 's'),
(25, 'ぞ', 'zo', ' ', ' ', ' ', 'hi24', 'z', 's'),
(26, 'た', 'ta', ' ', ' ', ' ', 'hi25', 't', '-'),
(27, 'ち', 'chi', ' ', ' ', ' ', 'hi26', 't', '-'),
(28, 'つ', 'tsu', 'A kisebb változata, \"ちいさいつ\" (\"chisai tsu\", vagy \"kicsi tsu\") <br>(\"っ\"; Normál méretű \"tsu\":\"つ\", a kettő egymás mellett: つ っ) kettős manánhangzót jelöl: \"ちょ っ と\" (\"cho t to\" jelentés: kicsi). <br> Ha szó végén van, akkor hirtelen megállást jelöl (az utolsó manánhangzót rövidebb ideig tartjuk).', 'The smaller version, \"ちいさいつ\" (\"chisai tsu\", or \"small tsu\")<br>(\"っ\"; normal sized \"tsu\":\"つ\", both side by side: つ っ) indicates a double consonant \"ちょ っ と\" (\"cho t to\" meaning: small). <br> If it is on the end of a word, it indicates a glottal stop (the last vowel is pronounced shorter than usual).', ' ', 'hi27', 't', '-'),
(29, 'て', 'te', ' ', ' ', ' ', 'hi28', 't', '-'),
(30, 'と', 'to', ' ', ' ', ' ', 'hi29', 't', '-'),
(31, 'だ', 'da', ' ', ' ', ' ', 'hi30', 'd', 't'),
(32, 'ぢ', 'dzi', 'A \"di\" karakterösszetétellel lehet leírni Windows IME tábla Hiragana módjában.', 'Should be written as \"di\" while using Windows IME table with Hiragana input enabled.', ' ', 'hi31', 'd', 't'),
(33, 'づ', 'dzu', 'A \"du\" karakterösszetétellel lehet leírni Windows IME tábla Hiragana módjában.', 'Should be written as \"du\" while using Windows IME table with Hiragana input enabled.', ' ', 'hi32', 'd', 't'),
(34, 'で', 'de', ' ', ' ', ' ', 'hi33', 'd', 't'),
(35, 'ど', 'do', ' ', ' ', ' ', 'hi34', 'd', 't'),
(36, 'な', 'na', ' ', ' ', ' ', 'hi35', 'n', '-'),
(37, 'に', 'ni', ' ', ' ', ' ', 'hi36', 'n', '-'),
(38, 'ぬ', 'nu', ' ', ' ', ' ', 'hi37', 'n', '-'),
(39, 'ね', 'ne', ' ', ' ', ' ', 'hi38', 'n', '-'),
(40, 'の', 'no', ' ', ' ', ' ', 'hi39', 'n', '-'),
(41, 'は', 'ha', ' A karakter は (ha) egy gyakori tételjelölő hang, ám \"wa\"-ként ejtik.<br> Ugyan úgy hangzik, mint a Hiragana わ (wa), de NEM felcserélhető!<br> <strong>Példa:</strong>\r\nこねははしです。(kone Wa hashi desu.)\r\n(jelentése: Ez egy [pár] evőpálca.)<br>\r\nA harmadik karakter azonos a negyedikkel, mégis másként van kiejtve.<br> Ezt könnyebb észrevenni, amikor nem csak Hiragana karaktereket használunk \r\na mondat írásához.', '  は (ha) is a common topic marking particle, but it pronounced as \'wa\'. <br> Sounds identical to Hiragana わ (wa), but NOT interchangeable! <br> <strong>Example:</strong>\r\nこねははしです。(kone Wa hashi desu.)\r\n(meaning: This is [a pair of] chopsticks.) <br>\r\nNotice how the 3rd syllable looks identical to the 4th, but pronounced differently. <br> This is more apparent when not only Hiragana is used to write a sentence.', ' ', 'hi40', 'h', '-'),
(42, 'ひ', 'hi', ' ', ' ', ' ', 'hi41', 'h', '-'),
(43, 'ふ', 'fu', ' ', ' ', ' ', 'hi42', 'h', '-'),
(44, 'へ', 'he', 'A karakter へ (he) kötőszóként azt a helyet jelöli, ami felé valami halad. <br>\"e\" hangként ejtik, ám nem azonos, vagy felcserélhető az え (e) karakterrel!<br> <strong>Példa:</strong> がっこうへいく。 (gakkou E iku.) (jelentése: [Én] iskolába fogok menni.)', ' へ (he) is a particle that indicates a place that towards something is moving. <br> It\'s pronounciation changes to \'e\', however it is not identical or interchangable with the character え (e)!<br> <strong>Example:</strong> がっこうへいく。 (gakkou E iku.) (meaning: [I] will go TO school.)', ' ', 'hi43', 'h', '-'),
(45, 'ほ', 'ho', ' ', ' ', ' ', 'hi44', 'h', '-'),
(46, 'ば', 'ba', ' ', ' ', ' ', 'hi45', 'b', 'h'),
(47, 'び', 'bi', ' ', ' ', ' ', 'hi46', 'b', 'h'),
(48, 'ぶ', 'bu', ' ', ' ', ' ', 'hi47', 'b', 'h'),
(49, 'べ', 'be', ' ', ' ', ' ', 'hi48', 'b', 'h'),
(50, 'ぼ', 'bo', ' ', ' ', ' ', 'hi49', 'b', 'h'),
(51, 'ぱ', 'pa', ' ', ' ', ' ', 'hi50', 'p', 'h'),
(52, 'ぴ', 'pi', ' ', ' ', ' ', 'hi51', 'p', 'h'),
(53, 'ぷ', 'pu', ' ', ' ', ' ', 'hi52', 'p', 'h'),
(54, 'ぺ', 'pe', ' ', ' ', ' ', 'hi53', 'p', 'h'),
(55, 'ぽ', 'po', ' ', ' ', ' ', 'hi54', 'p', 'h'),
(56, 'や', 'ya', ' ', ' ', ' ', 'hi55', 'y', '-'),
(57, 'ゆ', 'yu', ' ', ' ', ' ', 'hi56', 'y', '-'),
(58, 'よ', 'yo', ' ', ' ', ' ', 'hi57', 'y', '-'),
(59, 'ら', 'ra', ' ', ' ', ' ', 'hi58', 'r', '-'),
(60, 'り', 'ri', ' ', ' ', ' ', 'hi59', 'r', '-'),
(61, 'る', 'ru', ' ', ' ', ' ', 'hi60', 'r', '-'),
(62, 'れ', 're', ' ', ' ', ' ', 'hi61', 'r', '-'),
(63, 'ろ', 'ro', ' ', ' ', ' ', 'hi62', 'r', '-'),
(64, 'わ', 'wa', ' ', ' ', ' ', 'hi63', 'w', '-'),
(65, 'を', 'wo', 'A karakter を (wo) soha nem lehet szó része, csupán tárgyjelölő kötőszó.<br>Általában \'o\' hangként ejtik, de NEM azonos, vagy felcserélhető az お (o) karakterrel! <br>Egy mondaton bellül ay előtte álló szót jelöli meg tárgyként. <br> <strong>Példa:</strong>りんごをたべました。(ringo O tabemashita.) (meaning: [Én] megettem egy almát.)', ' を (wo) is never used in words, but used as the object marking particle.<br> It\'s usually pronounced as \'o\', but not interchangeable with the syllable お (o)! <br> In a sentence, the word before it is the object of the sentence. <br> <strong>Example:</strong>りんごをたべました。(ringo wo tabemashita.) (meaning: [I] ate an apple.)', ' ', 'hi64', 'w', '-'),
(66, 'ん', 'n', 'Az egyetlen egyedül álló mássalhangzó, kiejtése általában hasonló az \"n\" hanghoz.<br>Szó soha nem kezdődik ezzel a karakterrel!<br>A kiejtése változhat az utánna következő mássalhangzó hatására.<br>(Hasonlóan a Magyar nyelvben megfigyelhető zöngésség szerinti hasonuláshoz.)<br><strong>Példák:</strong> かんぱい (kanpai) kiejtve \'kampai\'.<br>はんがく (hangaku) Ebben a szóban az ん hangot \'ng\'-ként ejtik.', 'The only syllable that consists of only a consonant, its pronunciation is similar to the sound \"n\".<br>Words never start with this character!<br>It\'s pronunciation can change according to the sound that follows it.<br><strong>Examples:</strong> かんぱい (kanpai) is pronounced as \'kampai\'.<br>はんがく (hangaku) In this word, the syllable ん is pronounced like \'ng\'.', ' ', 'hi65', '-', '-'),
(67, 'ま', 'ma', ' ', ' ', ' ', 'hi66', 'ｍ', '-'),
(68, 'み', 'mi', ' ', ' ', ' ', 'hi67', 'ｍ', '-'),
(69, 'む', 'mu', ' ', ' ', ' ', 'hi68', 'ｍ', '-'),
(70, 'め', 'me', ' ', ' ', ' ', 'hi69', 'ｍ', '-'),
(71, 'も', 'mo', ' ', ' ', ' ', 'hi70', 'ｍ', '-');

-- --------------------------------------------------------

--
-- Table structure for table `kanji`
--

CREATE TABLE `kanji` (
  `id` int(11) NOT NULL COMMENT 'azonosito',
  `kanji` tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'kanji',
  `eng` tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'english meaning',
  `hun` tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'magyar jelentes',
  `note_kan` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'useful to know',
  `note_hkan` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'magyar useful to know',
  `note_ukan` char(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'user note id (kj0-kj<X>) (max kj999)',
  `read_on` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ON readings',
  `read_kun` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'KUN readings',
  `radical` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'radical',
  `comm_en` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'common words it is used in (english)',
  `comm_hu` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'common words it is used in (hungarian)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `katakana`
--

CREATE TABLE `katakana` (
  `id_ka` int(11) NOT NULL COMMENT 'katakana id',
  `kana_ka` tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'kana',
  `roman_ka` tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'kana in roman letters (based on english)',
  `note_ka` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '\'    \'' COMMENT 'magyar note to this kana',
  `note_eka` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'english note this kana',
  `learn_ka` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '\'    \'' COMMENT 'how to learn this kana',
  `note_uka` char(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'usernote id (ka0-ka<X>) (max ka999)',
  `row_ka` char(1) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'which row it is',
  `mod_ka` char(1) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'which modified main row it is'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `pw` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefLang` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `user_notes`
--

CREATE TABLE `user_notes` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT 'a user azonositoja (users.id)',
  `note_index` char(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'defines where the note belongs (fe.: hiragana E will appear as hi3',
  `user_note` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'the note the user created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `words`
--

CREATE TABLE `words` (
  `id_word` int(11) NOT NULL COMMENT 'word id',
  `kana_w` tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'kana form',
  `roman_w` tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'romanji form',
  `eng_w` tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'english meaning',
  `eng2_w` tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'secondary meaning',
  `hun_w` tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'magyar meaning',
  `hun2_w` tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'secondary meaning magyar',
  `note_uw` tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'user note id (w0-w<X>) (max: w9999)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `words`
--

INSERT INTO `words` (`id_word`, `kana_w`, `roman_w`, `eng_w`, `eng2_w`, `hun_w`, `hun2_w`, `note_uw`) VALUES
(1, 'きれい', 'kirei', 'pretty', 'tidy', 'szép', 'rendezett', 'w0'),
(2, 'めんどうくさい', 'mendoukusai', 'it is bothersome', 'it is a lot of effort', 'problémás', 'kellemetlen', 'w1'),
(3, 'でかい', 'dekai', 'huge', 'gigantic', 'hatalmas', 'hatalmas', 'w2'),
(4, 'ありがとう', 'arigatou', 'thank you', 'thank you', 'köszönöm', 'köszönöm', 'w3'),
(5, 'すみません', 'sumimasen', 'excuse me', 'sorry', 'elnézést', 'bocsánat', 'w4'),
(6, 'トイレ', 'toire', 'toilet', 'toilet', 'WC', 'mellékhelyiség', 'w5'),
(7, 'ホテル', 'hoteru', 'hotel', 'hotel', 'hotel', 'hotel', 'w6'),
(8, 'コンビニ', 'konbini', 'convenience store', 'convenience store', 'kisbolt', 'kisbolt', 'w7'),
(9, 'あい', 'ai', 'love', 'love', 'szerelem', 'szerelem', 'w8'),
(10, 'うえ', 'ue', 'up', 'above', 'fel', 'felette', 'w9'),
(11, 'いいえ', 'iie', 'no', 'no', 'nem', 'nem', 'w10'),
(12, 'いえ', 'ie', 'house', 'house', 'ház', 'ház', 'w11'),
(13, 'あう', 'au', 'to meet', 'to meet', 'találkozni', 'találkozni', 'w12'),
(14, 'あお', 'ao', 'blue', 'blue', 'kék', 'kék', 'w13'),
(15, 'いう', 'iu', 'to say', 'to say', 'mondani', 'mondani', 'w14'),
(16, 'おい', 'oi', 'nephew', 'nephew', 'unokaöcs', 'unokaöcs', 'w15'),
(17, 'おう', 'ou', 'king', 'king', 'király', 'király', 'w16'),
(18, 'かく', 'kaku', 'to write', 'to write', 'írni', 'írni', 'w17'),
(19, 'かげ', 'kage', 'shadow', 'shadow', 'árnyék', 'árnyék', 'w18'),
(20, 'きく', 'to listen', 'to listen', 'to listen', 'hallgatni', 'hallgatni', 'w19'),
(21, 'こえ', 'koe', 'voice', 'voice', 'hang', 'hang', 'w20'),
(22, 'かぎ', 'kagi', 'key', 'key', 'kulcs', 'kulcs', 'w21'),
(23, 'きおく', 'kioku', 'memory', 'memory', 'emlék', 'memória', 'w22'),
(24, 'えいが', 'eiga', 'movie', 'movie', 'film', 'film', 'w23'),
(25, 'おおきい', 'ookii', 'big', 'big', 'nagy', 'nagy', 'w24'),
(26, 'か', 'ka', 'mosquito', 'mosquito', 'szúnyog', 'szúnyog', 'w25'),
(27, 'あか', 'aka', 'red', 'red', 'piros', 'piros', 'w26'),
(28, 'かご', 'kago', 'basket', 'basket', 'kosár', 'kosár', 'w27'),
(29, 'くぎ', 'kugi', 'nail', 'nail', 'szeg', 'szeg', 'w28'),
(30, 'かい', 'kai', 'seashell', 'seashell', 'kagyló', 'kagyló', 'w29'),
(31, 'えき', 'eki', 'station', 'station', 'állomás', 'állomás', 'w30'),
(32, 'くうき', 'kuuki', 'air', 'air', 'levegő', 'levegő', 'w31'),
(33, 'えいご', 'eigo', 'English', 'English', 'Angol', 'Angol', 'w32'),
(34, 'きあい', 'kiai', 'fighting spirit', 'fighting spirit', 'harci szellem', 'harci szellem', 'w33'),
(35, 'けいかく', 'keikaku', 'plan', 'plan', 'terv', 'terv', 'w34'),
(36, 'かいけい', 'kaikei', 'accounting', 'accounting', 'könyvelés', 'számvitel', 'w35'),
(37, 'かさ', 'kasa', 'umbrella', 'umbrella', 'esernyő', 'ernyő', 'w36'),
(38, 'おす', 'osu', 'to push', 'to push', 'nyomni', 'tolni', 'w37'),
(39, 'きし', 'kishi', 'knight', 'knight', 'lovag', 'lovag', 'w38'),
(40, 'すぐ', 'sugu', 'immediately', 'immediately', 'azonnal', 'rögtön', 'w39'),
(41, 'すき', 'suki', 'like', 'like', 'kedvel', 'kedvel', 'w40'),
(42, 'けす', 'kesu', 'to erase', 'to erase', 'kitörölni', 'kitörölni', 'w41'),
(43, 'くじ', 'kuji', 'lottery', 'lottery', 'lottó', 'lottó', 'w42'),
(44, 'しお', 'shio', 'salt', 'salt', 'só', 'só', 'w43'),
(45, 'いしき', 'ishiki', 'consciousness', 'consciousness', 'öntudat', 'öntudat', 'w44'),
(46, 'しぐさ', 'shigusa', 'gesture', 'mannerism', 'gesztus', 'modorosság', 'w45'),
(47, 'おこす', 'okosu', 'to wake somebody up', 'to cause to happen', 'felébreszteni valakit', 'valami történését okorzni', 'w46'),
(48, 'さそう', 'sasou', 'to invite', 'to invite', 'meghívni', 'meghívni', 'w47'),
(49, 'すこし', 'sukoshi', 'a little', 'a little', 'egy kicsit', 'egy kicsit', 'w48'),
(50, 'さがす', 'sagasu', 'to search', 'to search', 'keresni', 'keresni', 'w49'),
(51, 'しかく', 'shikaku', 'square', 'square', 'négyzet', 'négyszög', 'w50'),
(52, 'かえす', 'kaesu', 'to return', 'to return', 'visszavinni', 'visszatérni', 'w51'),
(53, 'うさぎ', 'usagi', 'rabbit', 'rabbit', 'nyúl', 'nyúl', 'w52'),
(54, 'さいせい', 'saisei', 'playback', 'playback', 'lejátszás', 'visszajátszás', 'w53'),
(55, 'おかしい', 'okashii', 'strange', 'strange', 'furcsa', 'furcsa', 'w54'),
(56, 'がくせい', 'gakusei', 'student', 'student', 'diák', 'diák', 'w55'),
(57, 'あさけ', 'asake', 'alcohol', 'alcohol', 'alkohol', 'alkohol', 'w56'),
(58, 'さく', 'saku', 'bloom', 'bloom', 'virágzás', 'virágzás', 'w57'),
(59, 'あかし', 'akashi', 'testimony', 'testimony', 'bizonyság', 'tanúságtétel', 'w58'),
(60, 'あかしい', 'akashii', 'amusing', 'amusing', 'szórakoztató', 'szórakoztató', 'w59'),
(61, 'さいご', 'saigo', 'last', 'last', 'utolsó', 'utolsó', 'w60'),
(62, 'て', 'te', 'hand', 'hand', 'kéz', 'kéz', 'w61'),
(63, 'くつ', 'kutsu', 'shoes', 'shoes', 'cipő', 'cipő', 'w62'),
(64, 'ちず', 'chizu', 'map', 'map', 'térkép', 'térkép', 'w63'),
(65, 'でし', 'deshi', 'apprentice', 'apprentice', 'tanonc', 'tanonc', 'w64'),
(66, 'たつ', 'tatsu', 'to stand', 'to stand', 'állni', 'állni', 'w65'),
(67, 'とおい', 'tooi', 'far', 'far', 'messze', 'messze', 'w66'),
(68, 'つずく', 'tsudzuku', 'to continue', 'to continue', 'folytatni', 'folytatni', 'w67'),
(69, 'どっち', 'docchi', 'witch', 'witch', 'boszorkány', 'boszorkány', 'w68'),
(70, 'だいがく', 'daigaku', 'university', 'big school', 'egyetem', 'nagy iskola', 'w69'),
(71, 'あさって', 'asatte', 'day after tomorrow', 'day after tomorrow', 'holnapután', 'holnapután', 'w70'),
(72, 'おちつく', 'ochitsuku', 'to calm down', 'to calm down', 'lenyugodni', 'lenyugodni', 'w71'),
(73, 'つち', 'tsuchi', 'soil', 'soil', 'talaj', 'talaj', 'w72'),
(74, 'たす', 'tasu', 'add', 'add', 'összead', 'hozzáad', 'w73'),
(75, 'くち', 'kushi', 'mouth', 'mouth', 'száj', 'száj', 'w74'),
(76, 'てつ', 'tetsu', 'iron', 'iron', 'Vas', 'Vas', 'w75'),
(77, 'ちかい', 'chikai', 'near', 'near', 'közel', 'közel', 'w76'),
(78, 'とけい', 'tokei', 'clock', 'clock', 'óra', 'óra', 'w77'),
(79, 'ちがう', 'chigau', 'different', 'different', 'különböző', 'különböző', 'w78'),
(80, 'かえで', 'kaede', 'maple tree', 'maple tree', 'juharfa', 'juharfa', 'w79'),
(81, 'ちかてつ', 'chikatetsu', 'subway', 'subway', 'metró', 'metró', 'w80'),
(82, 'たたかう', 'tatakau', 'to fight', 'to fight', 'harcolni', 'harcolni', 'w81'),
(83, 'けってい', 'kettei', 'decision', 'decision', 'döntés', 'döntés', 'w82'),
(84, 'てつづき', 'tetsudzuki', 'procedure', 'procedure', 'eljárás', 'eljárás', 'w83'),
(85, 'おちついた', 'ochitsuita', 'calmed down', 'calm down!', 'megnyugodott', 'nyugodj meg!', 'w84'),
(86, 'かっこいい', 'kakkoii', 'cool', 'cool', 'menő', 'menő', 'w85'),
(87, 'なに', 'nani', 'what', 'what', 'mit?', 'mi?', 'w86'),
(88, 'いぬ', 'inu', 'dog', 'dog', 'kutya', 'kutya', 'w87'),
(89, 'ねこ', 'neko', 'cat', 'cat', 'macska', 'cica', 'w88'),
(90, 'にじ', 'niji', 'rainbow', 'rainbow', 'szivárvány', 'szivárvány', 'w89'),
(91, 'おかね', 'okane', 'money', 'money', 'pénz', 'pénz', 'w90'),
(92, 'せなか', 'senaka', 'upper back', 'upper back', 'felső hát', 'felső hát', 'w91'),
(93, 'なっとう', 'nattou', 'fermented soybeans', 'fermented soybeans', 'erjesztett szójabab', 'erjesztett szójabab', 'w92'),
(94, 'なつ', 'natsu', 'summer', 'summer', 'nyári', 'nyári', 'w93'),
(95, 'のど', 'nodo', 'throat', 'throat', 'torok', 'torok', 'w94'),
(96, 'にく', 'niku', 'meat', 'meat', 'hús', 'hús', 'w95'),
(97, 'ぬの', 'nuno', 'fabric', 'fabric', 'szövet', 'szövet', 'w96'),
(98, 'ねつ', 'netsu', 'fever', 'heat', 'láz', 'hő', 'w97'),
(99, 'のう', 'nou', 'brain', 'brain', 'agy', 'agy', 'w98'),
(100, 'くに', 'kuni', 'country', 'country', 'ország', 'ország', 'w99'),
(101, 'にっき', 'nikki', 'diary', 'diary', 'napló', 'napló', 'w100'),
(102, 'きのう', 'kinou', 'yesterday', 'yesterday', 'tegnap', 'tegnap', 'w101'),
(103, 'のうか', 'nouka', 'farmer', 'farmer', 'gazda', 'földműves', 'w102'),
(104, 'きのこ', 'kinoko', 'mushroom', 'mushroom', 'gomba', 'gomba', 'w103'),
(105, 'いかない', 'ikanaki', 'to not go', 'to not go', 'ne menj', 'ne menj', 'w104'),
(106, 'たけのこ', 'takenoko', 'bamboo shoot', 'bamboo shoot', 'bambusz hajtás', 'bambusz hajtás', 'w105'),
(107, 'なつかしい', 'natsukashii', 'yearning for the past', 'yearning for the past', 'vágyakozik a múlt után', 'Nosztalgikus', 'w106'),
(108, 'にし', 'nishi', 'west', 'west', 'nyugat', 'nyugat', 'w107'),
(109, 'っきつ', 'kkitsu', 'tight', 'tight', 'szoros', 'szűk', 'w108'),
(110, 'あそこ', 'asoko', 'over there', 'that place', 'az a hely', 'ott', 'w109'),
(111, 'ここ', 'koko', 'here', 'here', 'itt', 'itt', 'w110'),
(112, 'そこ', 'soko', 'there', 'there', 'ott', 'ott', 'w111'),
(113, 'こっちだ', 'kocchida', 'this way', '(it is) this way', 'erre', 'erre', 'w112');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hiragana`
--
ALTER TABLE `hiragana`
  ADD PRIMARY KEY (`id_hi`);

--
-- Indexes for table `kanji`
--
ALTER TABLE `kanji`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `katakana`
--
ALTER TABLE `katakana`
  ADD PRIMARY KEY (`id_ka`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `user_notes`
--
ALTER TABLE `user_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `words`
--
ALTER TABLE `words`
  ADD PRIMARY KEY (`id_word`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hiragana`
--
ALTER TABLE `hiragana`
  MODIFY `id_hi` int(11) NOT NULL AUTO_INCREMENT COMMENT 'hiragana id', AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `kanji`
--
ALTER TABLE `kanji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'azonosito';

--
-- AUTO_INCREMENT for table `katakana`
--
ALTER TABLE `katakana`
  MODIFY `id_ka` int(11) NOT NULL AUTO_INCREMENT COMMENT 'katakana id';

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_notes`
--
ALTER TABLE `user_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `words`
--
ALTER TABLE `words`
  MODIFY `id_word` int(11) NOT NULL AUTO_INCREMENT COMMENT 'word id', AUTO_INCREMENT=114;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_notes`
--
ALTER TABLE `user_notes`
  ADD CONSTRAINT `user_notes_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2021 at 06:54 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quanlydathang`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `code_category` char(3) NOT NULL,
  `name_category` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`code_category`, `name_category`) VALUES
('C00', 'DEFAULT'),
('C01', 'GAMES HOT'),
('C02', 'GAMES HAY'),
('C03', 'GAMES MỚI');

-- --------------------------------------------------------

--
-- Table structure for table `chitietdathang`
--

CREATE TABLE `chitietdathang` (
  `SoDonDH` int(11) NOT NULL,
  `MSHH` char(5) NOT NULL,
  `Gia` decimal(19,0) DEFAULT NULL,
  `SoLuong` int(5) DEFAULT NULL,
  `GiaDatHang` decimal(19,0) DEFAULT NULL,
  `GiamGia` decimal(5,0) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chitietdathang`
--

INSERT INTO `chitietdathang` (`SoDonDH`, `MSHH`, `Gia`, `SoLuong`, `GiaDatHang`, `GiamGia`) VALUES
(1, 'G010', '480000', 1, '480000', '0'),
(1, 'G011', '390000', 1, '390000', '0'),
(2, 'G002', '390000', 2, '390000', '0'),
(2, 'G003', '833000', 1, '833000', '0'),
(2, 'G004', '1290000', 1, '1290000', '0'),
(2, 'G006', '480000', 1, '480000', '0'),
(2, 'G007', '455000', 1, '455000', '0'),
(2, 'G011', '390000', 1, '390000', '0'),
(2, 'G012', '1300000', 1, '1300000', '0'),
(2, 'G014', '1400000', 1, '1400000', '0'),
(2, 'G018', '800000', 1, '800000', '0'),
(4, 'G001', '1280000', 2, '1280000', '0'),
(4, 'G005', '1135000', 2, '1135000', '0'),
(4, 'G010', '480000', 2, '480000', '0'),
(5, 'G001', '1280000', 2, '1280000', '0'),
(5, 'G002', '390000', 1, '390000', '0'),
(5, 'G003', '833000', 2, '833000', '0'),
(5, 'G004', '1290000', 4, '1290000', '0'),
(5, 'G008', '900000', 1, '900000', '0'),
(5, 'G018', '800000', 1, '800000', '0');

-- --------------------------------------------------------

--
-- Table structure for table `dathang`
--

CREATE TABLE `dathang` (
  `SoDonDH` int(11) NOT NULL,
  `MSKH` char(5) DEFAULT NULL,
  `NgayDH` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dathang`
--

INSERT INTO `dathang` (`SoDonDH`, `MSKH`, `NgayDH`) VALUES
(1, '123', '2021-05-03 23:42:26'),
(2, 'abc', '2021-05-03 21:19:59'),
(4, 'xyz', '2021-05-03 23:45:59'),
(5, 'gnoul', '2021-05-05 02:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `diachikh`
--

CREATE TABLE `diachikh` (
  `MaDC` char(5) NOT NULL,
  `DiaChi` varchar(50) DEFAULT NULL,
  `MSKH` char(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hanghoa`
--

CREATE TABLE `hanghoa` (
  `MSHH` char(5) NOT NULL,
  `TenHH` varchar(100) DEFAULT NULL,
  `QuyCach` varchar(100) DEFAULT NULL,
  `Gia` decimal(19,0) DEFAULT NULL,
  `SoLuongHang` int(5) DEFAULT NULL,
  `GhiChu` varchar(5000) DEFAULT NULL,
  `thumbnail` varchar(500) DEFAULT NULL,
  `MaLoaiHang` char(5) DEFAULT NULL,
  `code_category` char(3) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hanghoa`
--

INSERT INTO `hanghoa` (`MSHH`, `TenHH`, `QuyCach`, `Gia`, `SoLuongHang`, `GhiChu`, `thumbnail`, `MaLoaiHang`, `code_category`, `created_at`, `updated_at`) VALUES
('G001', 'Yakuza: Like A Dragon', NULL, '1280000', 1000, 'BAY NHƯ RỒNG\r\n\r\nIchiban Kasuga, một kẻ càu nhàu cấp thấp của một gia đình yakuza cấp thấp ở Tokyo, phải đối mặt với bản án 18 năm tù sau khi nhận tội mà mình không phạm phải. Không bao giờ đánh mất niềm tin, anh trung thành phục vụ thời gian của mình và quay trở lại xã hội để phát hiện ra rằng không có ai đang chờ đợi anh ở bên ngoài, và gia tộc của anh đã bị tiêu diệt bởi người đàn ông mà anh kính trọng nhất.\r\nIchiban bắt đầu khám phá sự thật đằng sau sự phản bội của gia đình mình và lấy lại cuộc sống của mình, lôi kéo một nhóm tàn ác bị xã hội ruồng bỏ về phía mình: Adachi, một cảnh sát lừa đảo, Nanba, một cựu y tá vô gia cư, và Saeko, một nữ tiếp viên trong một nhiệm vụ . Cùng nhau, họ bị lôi kéo vào một cuộc xung đột đang diễn ra bên dưới bề mặt ở Yokohama và phải vươn lên để trở thành những anh hùng mà họ không bao giờ mong đợi.\r\n\r\nLÊN CẤP TỪ UNDERDOG ĐẾN RỒNG TRONG KẾT HỢP RPG sống động\r\n\r\nTrải nghiệm chiến đấu RPG năng động không giống ai. Chuyển đổi giữa 19 công việc độc đáo khác nhau, từ Vệ sĩ đến Nhạc sĩ, sử dụng chiến trường làm vũ khí của bạn. Lấy dơi, ô dù, xe đạp, biển báo và mọi thứ khác theo ý của bạn để dọn dẹp đường phố!\r\n\r\nVÀO VÒNG CHƠI DƯỚI THẾ GIỚI\r\n\r\nKhi bạn không bận bịu, hãy thư giãn bằng cách tham gia trò chơi điện tử địa phương để chơi một số trò chơi SEGA cổ điển, cạnh tranh với người dân địa phương trong một cuộc đua xe go-kart không giới hạn xung quanh Yokohama, hoàn thành 50 trạm xe điện độc đáo hoặc chỉ ngắm nhìn khung cảnh của một thành phố hiện đại của Nhật Bản. Luôn luôn có một cái gì đó mới xung quanh góc.', '/images/Game-covers/yakuza_likeadragon.jpg', 'GT002', 'C01', '2021-05-01 14:38:15', '2021-05-01 17:15:23'),
('G002', 'The Witcher 3: Wild Hunt - Game of the Year Edition', NULL, '390000', 350, 'The Witcher: Wild Hunt là một game nhập vai thế giới mở có cốt truyện lấy bối cảnh trong một vũ trụ giả tưởng trực quan tuyệt đẹp với đầy những lựa chọn có ý nghĩa và hậu quả tác động. Trong The Witcher, bạn vào vai thợ săn quái vật chuyên nghiệp Geralt of Rivia với nhiệm vụ tìm kiếm đứa con của lời tiên tri trong một thế giới mở rộng lớn giàu có với các thành phố buôn bán, đảo cướp biển, đèo nguy hiểm và hang động bị lãng quên để khám phá.', '/images/Game-covers/tw3.jpg', 'GT003', 'C01', '2021-05-01 14:38:15', '2021-05-01 16:52:14'),
('G003', 'NieR:Automata™ Game of the YoRHa Edition', NULL, '833000', 200, 'NieR: Automata kể về câu chuyện của các android 2B, 9S và A2 và cuộc chiến của họ để giành lại sự tàn phá của loạn thị do máy điều khiển bởi những cỗ máy mạnh mẽ.\r\n\r\nNhân loại đã bị đẩy khỏi Trái đất bởi những sinh vật máy móc từ thế giới khác. Trong nỗ lực cuối cùng để lấy lại hành tinh, cuộc kháng chiến của con người đã gửi một lực lượng lính android để tiêu diệt những kẻ xâm lược. Giờ đây, một cuộc chiến giữa máy móc và người máy diễn ra ác liệt ... Một cuộc chiến có thể sớm tiết lộ sự thật bị lãng quên từ lâu của thế giới.', '/images/Game-covers/nier_automata.jpg', 'GT001', 'C01', '2021-05-01 14:38:15', '2021-05-01 16:51:09'),
('G004', 'Sekiro™: Shadows Die Twice - GOTY Edition', NULL, '1290000', 100, 'Trong Sekiro ™: Shadows Die Twice bạn là \'con sói một tay\', một chiến binh thất sủng và biến dạng được cứu thoát khỏi bờ vực của cái chết. Bị ràng buộc để bảo vệ một lãnh chúa trẻ tuổi là hậu duệ của dòng máu cổ xưa, bạn trở thành mục tiêu của nhiều kẻ thù hung ác, bao gồm cả tộc Ashina nguy hiểm. Khi vị lãnh chúa trẻ tuổi bị bắt, không có gì có thể ngăn cản bạn trong một nhiệm vụ nguy hiểm để lấy lại danh dự của mình, thậm chí không phải cái chết.\r\n\r\nKhám phá Sengoku Nhật Bản vào cuối những năm 1500, một thời kỳ tàn khốc của cuộc xung đột sinh tử triền miên, khi bạn đối mặt với những kẻ thù lớn hơn cả sự sống trong một thế giới tối tăm và xoắn xuýt. Giải phóng kho vũ khí gồm các công cụ giả chết người và khả năng ninja mạnh mẽ trong khi bạn kết hợp giữa tàng hình, xuyên dọc và nội tạng để chiến đấu trực diện trong một cuộc đối đầu đẫm máu.\r\n\r\nTrả thù. Khôi phục danh dự của bạn. Giết một cách tài tình.', '/images/Game-covers/sekiro.jpg', 'GT001', 'C01', '2021-05-01 14:38:15', '2021-05-01 16:50:26'),
('G005', 'FINAL FANTASY XV WINDOWS EDITION', NULL, '1135000', 200, 'Hãy sẵn sàng để trở thành trung tâm của cuộc phiêu lưu giả tưởng cuối cùng, bây giờ dành cho Windows PC.\r\n\r\nĐược tham gia bởi những người bạn thân nhất của bạn trên con đường của cuộc đời qua một thế giới mở ngoạn mục, chứng kiến những cảnh quan tuyệt đẹp và chạm trán với những con thú lớn hơn cuộc sống trên hành trình giành lại quê hương của bạn từ một kẻ thù không thể tưởng tượng được.\r\n\r\nTrong một hệ thống chiến đấu đầy hành động, hãy truyền sức mạnh của tổ tiên bạn dễ dàng vượt qua không trung trong các trận chiến gay cấn và cùng với đồng đội của bạn nắm vững các kỹ năng về vũ khí, phép thuật và các cuộc tấn công theo nhóm.\r\n\r\nGiờ đây, đã hiện thực hóa sức mạnh của công nghệ tiên tiến dành cho PC Windows, bao gồm hỗ trợ màn hình độ phân giải cao và HDR10, bạn có thể khám phá trải nghiệm tuyệt đẹp và được trau chuốt cẩn thận của FINAL FANTASY XV chưa từng có.', '/images/Game-covers/ffxv.jpg', 'GT003', 'C01', '2021-05-01 14:38:15', '2021-05-01 16:48:47'),
('G006', 'Fallout 4: Game of the Year Edition', NULL, '480000', 300, 'Bethesda Game Studios, những người sáng tạo từng đoạt giải thưởng của Fallout 3 và The Elder Scrolls V: Skyrim, chào mừng bạn đến với thế giới của Fallout 4 - trò chơi tham vọng nhất của họ từ trước đến nay và thế hệ trò chơi thế giới mở tiếp theo.\r\n\r\nLà người sống sót duy nhất của Vault 111, bạn bước vào một thế giới bị phá hủy bởi chiến tranh hạt nhân. Mỗi giây là một cuộc chiến sinh tồn, và mọi lựa chọn là của bạn. Chỉ có bạn mới có thể xây dựng lại và quyết định số phận của Wasteland. Chào mừng bạn về nhà.', '/images/Game-covers/fallout4.jpg', 'GT003', 'C02', '2021-05-01 14:38:15', '2021-05-01 17:05:47'),
('G007', 'Grand Theft Auto V: Premium Edition', NULL, '455000', 400, 'Khi một thanh niên hối hả trên đường phố, một tên cướp ngân hàng đã nghỉ hưu và một kẻ tâm thần đáng sợ thấy mình bị vướng vào một số yếu tố đáng sợ và loạn trí nhất của thế giới ngầm tội phạm, chính phủ Hoa Kỳ và ngành công nghiệp giải trí, họ phải thực hiện hàng loạt vụ trộm nguy hiểm để tồn tại trong một thành phố tàn nhẫn mà họ không thể tin tưởng ai, ít nhất là lẫn nhau.\r\n\r\nGrand Theft Auto V cho PC cung cấp cho người chơi tùy chọn khám phá thế giới từng đoạt giải thưởng của Los Santos và Quận Blaine ở độ phân giải lên đến 4k và hơn thế nữa, cũng như cơ hội trải nghiệm trò chơi chạy ở tốc độ 60 khung hình / giây.\r\n\r\nTrò chơi cung cấp cho người chơi một loạt các tùy chọn tùy chỉnh dành riêng cho PC, bao gồm hơn 25 cài đặt có thể cấu hình riêng biệt cho chất lượng kết cấu, đổ bóng, tessellation, khử răng cưa và hơn thế nữa, cũng như hỗ trợ và tùy chỉnh mở rộng cho các điều khiển chuột và bàn phím. Các tùy chọn bổ sung bao gồm thanh trượt mật độ dân số để kiểm soát lưu lượng xe hơi và người đi bộ, cũng như hỗ trợ màn hình kép và ba, khả năng tương thích 3D và hỗ trợ bộ điều khiển plug-and-play.\r\n\r\nGrand Theft Auto V cho PC cũng bao gồm Grand Theft Auto Online, với sự hỗ trợ cho 30 người chơi và hai khán giả. Grand Theft Auto Online cho PC sẽ bao gồm tất cả các nâng cấp lối chơi hiện có và nội dung do Rockstar tạo được phát hành kể từ khi ra mắt Grand Theft Auto Online, bao gồm cả chế độ Heists và Adversary.\r\n\r\nPhiên bản PC của Grand Theft Auto V và Grand Theft Auto Online có Chế độ góc nhìn thứ nhất, mang đến cho người chơi cơ hội khám phá thế giới vô cùng chi tiết của Los Santos và Quận Blaine theo một cách hoàn toàn mới.', '/images/Game-covers/gta_v.jpg', 'GT001', 'C02', '2021-05-01 14:38:15', '2021-05-01 16:53:55'),
('G008', 'The Elder Scrolls V: Skyrim Special Edition', NULL, '900000', 500, 'Chiến thắng hơn 200 giải thưởng Trò chơi của năm, Skyrim Special Edition mang đến những tưởng tượng sử thi sống động đến từng chi tiết tuyệt đẹp. Phiên bản Đặc biệt bao gồm trò chơi được giới phê bình đánh giá cao và các tiện ích bổ sung với các tính năng hoàn toàn mới như hiệu ứng và nghệ thuật làm lại, tia thần tích, độ sâu trường ảnh động, phản xạ không gian màn hình, v.v. Skyrim Special Edition cũng mang toàn bộ sức mạnh của mod lên PC và hệ máy console. Nhiệm vụ, môi trường, nhân vật, đối thoại, áo giáp, vũ khí mới và hơn thế nữa - với Mod, không có giới hạn nào đối với những gì bạn có thể trải nghiệm.', '/images/Game-covers/skyrim.jpg', 'GT003', 'C02', '2021-05-01 14:38:15', '2021-05-01 17:06:38'),
('G009', 'Assassin\'s Creed® Unity', NULL, '495000', 250, 'Assassin’s Creed® Unity là một trò chơi hành động / phiêu lưu lấy bối cảnh thành phố Paris trong một trong những giờ đen tối nhất của nó, Cách mạng Pháp. Làm chủ câu chuyện bằng cách tùy chỉnh trang bị của Arno để tạo ra trải nghiệm độc nhất cho bạn, cả về mặt hình ảnh lẫn máy móc. Ngoài trải nghiệm chơi đơn hoành tráng, Assassin’s Creed Unity mang đến cảm giác phấn khích khi chơi với tối đa ba người bạn thông qua lối chơi hợp tác trực tuyến trong các nhiệm vụ cụ thể. Xuyên suốt trò chơi, hãy tham gia vào một trong những thời khắc quan trọng nhất của lịch sử Pháp trong một cốt truyện hấp dẫn và một sân chơi hấp dẫn đã mang đến cho bạn thành phố ánh sáng của ngày hôm nay.', '/images/Game-covers/ac_unity.jpg', 'GT001', 'C00', '2021-05-01 14:38:15', '2021-05-01 17:18:48'),
('G010', 'Persona 4 Golden - Digital Deluxe Edition', NULL, '480000', 700, 'Inaba — một thị trấn yên tĩnh ở vùng nông thôn Nhật Bản là bối cảnh cho tuổi mới lớn trong Persona 4 Golden.\r\n\r\nMột câu chuyện về tuổi mới lớn đặt nhân vật chính và những người bạn của anh ta vào một cuộc hành trình bắt đầu bởi một chuỗi các vụ giết người hàng loạt. Khám phá việc gặp gỡ những tinh thần tốt bụng, cảm giác thân thuộc và thậm chí đối mặt với những mặt tối trong bản thân của một người.\r\n\r\nPersona 4 Golden hứa hẹn sự gắn kết ý nghĩa và chia sẻ kinh nghiệm cùng bạn bè.\r\n\r\nVới điểm Metacritic tổng thể là 93 và vô số giải thưởng, Persona 4 Golden được người hâm mộ yêu thích là một trong những game nhập vai hay nhất từng được sản xuất, mang đến lối kể chuyện lôi cuốn và lối chơi Persona tinh túy.', '/images/Game-covers/p4g.jpg', 'GT002', 'C03', '2021-05-01 14:38:15', '2021-05-01 17:16:46'),
('G011', 'Horizon Zero Dawn™ Complete Edition', NULL, '390000', 80, 'TRÁI ĐẤT KHÔNG CÒN LÀ CỦA CHÚNG TA NỮA\r\n\r\nTrải nghiệm toàn bộ nhiệm vụ huyền thoại của Aloy để làm sáng tỏ những bí ẩn của một thế giới được cai trị bởi những cỗ máy chết chóc.\r\n\r\nBị ruồng bỏ khỏi bộ tộc của cô, người thợ săn trẻ tuổi chiến đấu để khám phá quá khứ của cô, khám phá số phận của cô ... và ngăn chặn một mối đe dọa thảm khốc cho tương lai.\r\n\r\nTung ra các cuộc tấn công tàn khốc, chiến thuật chống lại những cỗ máy độc nhất vô nhị và các bộ lạc đối thủ khi bạn khám phá một thế giới mở đầy động vật hoang dã và nguy hiểm.\r\n\r\nHorizon Zero Dawn ™ là một trò chơi nhập vai hành động từng đoạt nhiều giải thưởng - và Phiên bản Hoàn chỉnh này dành cho PC bao gồm bản mở rộng khổng lồ The Frozen Wilds, có các vùng đất mới, kỹ năng, vũ khí và Máy móc.', '/images/Game-covers/hzd.jpg', 'GT003', 'C03', '2021-05-01 14:38:15', '2021-05-01 17:10:32'),
('G012', 'The Legend of Zelda™: Breath of the Wild', NULL, '1300000', 800, 'Quên tất cả mọi thứ bạn biết về trò chơi The Legend of Zelda. Bước vào thế giới khám phá, khám phá và phiêu lưu trong The Legend of Zelda: Breath of the Wild, một trò chơi mới phá vỡ ranh giới trong sê-ri nổi tiếng. Đi qua những cánh đồng rộng lớn, qua những khu rừng và đến những đỉnh núi khi bạn khám phá những gì đã trở thành của vương quốc Hyrule trong Cuộc phiêu lưu ngoài trời tuyệt đẹp này. Giờ đây, trên Nintendo Switch, hành trình của bạn tự do và cởi mở hơn bao giờ hết. Đưa hệ thống của bạn đi bất cứ đâu và phiêu lưu dưới dạng Liên kết theo bất kỳ cách nào bạn muốn.', '/images/Game-covers/zelda_botw.jpg', 'GT003', 'C02', '2021-05-01 14:38:15', '2021-05-01 17:08:31'),
('G013', 'Don\'t Starve Together', NULL, '165000', 160, 'Don\'t Starve Together là bản mở rộng nhiều người chơi độc lập của trò chơi sinh tồn trong vùng hoang dã không khoan nhượng, Don\'t Starve.\r\n\r\nBước vào một thế giới kỳ lạ và chưa được khám phá đầy rẫy những sinh vật kỳ lạ, nguy hiểm và bất ngờ. Thu thập tài nguyên để chế tạo các vật phẩm và cấu trúc phù hợp với phong cách sinh tồn của bạn. Chơi theo cách của bạn khi bạn làm sáng tỏ những bí ẩn của vùng đất kỳ lạ này.\r\n\r\nHợp tác với bạn bè của bạn trong một trò chơi riêng tư hoặc tận dụng cơ hội của bạn với những người lạ trực tuyến. Làm việc với những người chơi khác để tồn tại trong môi trường khắc nghiệt hoặc tự mình tấn công.\r\n\r\nLàm bất cứ điều gì cần thiết, nhưng quan trọng nhất, Đừng chết đói.', '/images/Game-covers/dst.jpg', 'GT006', 'C00', '2021-05-01 14:38:15', '2021-05-01 17:19:32'),
('G014', 'Battlefield ™ V Definitive Edition', NULL, '1400000', 140, 'Đây là trải nghiệm Battlefield V cuối cùng. Bước vào cuộc xung đột lớn nhất của nhân loại trên đất liền, trên không và trên biển với tất cả nội dung trò chơi được mở khóa ngay từ đầu. Chọn từ kho vũ khí, phương tiện và tiện ích đầy đủ, và đắm mình trong những trận chiến cam go của Thế chiến thứ hai. Nổi bật trên chiến trường với danh sách đầy đủ các Elites và nội dung tùy chỉnh tốt nhất của Năm 1 và Năm 2.\r\n\r\nBattlefield V Definitive Edition chứa trò chơi cơ bản Battlefield V và bộ sưu tập nội dung hoàn chỉnh:\r\n- Tất cả nội dung trò chơi (vũ khí, phương tiện và tiện ích) từ khi ra mắt, Năm 1 và Năm 2\r\n- Tất cả người ưu tú\r\n- 84 biến thể trang phục nhập vai cho quân đội Anh và Đức để nâng cao hộp cát của Thế chiến II\r\n- 8 bộ trang phục lính của Năm 2\r\n- 2 skin vũ khí từ Năm 2, áp dụng cho 10 và 4 vũ khí tương ứng\r\n- 3 băng xe\r\n- 33 Chương Phần thưởng vật phẩm từ Năm 1', '/images/Game-covers/bf_v.jpg', 'GT004', 'C00', '2021-05-01 14:38:15', '2021-05-01 17:21:03'),
('G015', 'Street Fighter V', NULL, '276000', 100, 'Trải nghiệm cường độ của trận chiến đối đầu với Street Fighter® V! Chọn từ 16 nhân vật mang tính biểu tượng, mỗi nhân vật có câu chuyện cá nhân của riêng họ và những thử thách đào tạo độc đáo, sau đó chiến đấu với bạn bè trực tuyến hoặc ngoại tuyến với nhiều tùy chọn trận đấu phong phú.\r\n\r\nKiếm tiền trong các trận đấu xếp hạng, chơi giải trí trong các trận đấu thông thường hoặc mời bạn bè vào Battle Lounge và xem ai đứng đầu! Người chơi PlayStation 4 và Steam cũng có thể chơi với nhau nhờ khả năng tương thích chơi chéo!\r\n\r\nPhiên bản Street Fighter V này hiển thị màn hình tiêu đề “Phiên bản Arcade” và bao gồm Chế độ Arcade, Chế độ Đấu đội và Chế độ Chiến đấu Phụ được kích hoạt trực tuyến, nơi bạn có thể kiếm phần thưởng, XP và Tiền chiến đấu! Tiền Chiến đấu có thể được sử dụng để mua thêm nhân vật, trang phục, màn chơi và hơn thế nữa!\r\n\r\nTải xuống câu chuyện điện ảnh “A Shadow Falls” ngay hôm nay MIỄN PHÍ! M. Bison triển khai bảy Mặt trăng đen vào quỹ đạo, ban cho anh ta sức mạnh không thể tưởng tượng được khi trái đất chìm vào bóng tối.\r\n\r\nStreet Fighter V: Champion Edition là gói cuối cùng bao gồm tất cả nội dung (trừ trang phục Fighting Chance, trang phục hợp tác thương hiệu và Capcom Pro Tour DLC) từ cả bản phát hành gốc và Street Fighter V: Arcade Edition. Nó cũng bao gồm từng nhân vật, giai đoạn và trang phục được phát hành sau Arcade Edition. Điều đó có nghĩa là 40 nhân vật, 34 màn chơi và hơn 200 bộ trang phục!\r\n\r\nV-Trigger 1 và 2\r\nGiải phóng các kỹ thuật mạnh mẽ và các chiêu thức độc quyền bằng cách kích hoạt V-Trigger 1 hoặc 2 với nhân vật bạn chọn! Gây ra những đợt sát thương lớn hoặc làm cho cuộc lội ngược dòng cần thiết đó giành chiến thắng bằng cách nhấn mạnh cú đấm và cú đá mạnh đồng thời trong khi V-Gauge của bạn được tích trữ đầy đủ.', '/images/Game-covers/sf_v.jpg', 'GT007', 'C00', '2021-05-01 14:38:15', '2021-05-01 17:22:24'),
('G016', 'Super Mega Baseball 3', NULL, '350000', 100, 'Super Mega Baseball 3 cải tiến công thức của sê-ri với mô phỏng tại hiện trường sâu sắc nhất, chơi trực tuyến và ngoại tuyến toàn diện bao gồm chế độ Nhượng quyền thương mại và chế độ Giải đấu trực tuyến mới được bổ sung và đồ họa được cải thiện đáng kể. Nội dung mới bao gồm giao diện người dùng được cải tiến cùng với vô số âm thanh mới, nội dung đội / nhân vật và sân vận động có điều kiện ánh sáng thay đổi.', '/images/Game-covers/smb_3.jpg', 'GT005', 'C03', '2021-05-01 14:38:15', '2021-05-01 17:09:10'),
('G017', 'Sid Meier’s Civilization® VI', NULL, '999000', 60, 'Ban đầu được tạo ra bởi nhà thiết kế trò chơi huyền thoại Sid Meier, Civilization là một trò chơi chiến lược theo lượt trong đó bạn cố gắng xây dựng một đế chế để đứng vững trước thử thách của thời gian. Trở thành Người cai trị Thế giới bằng cách thiết lập và lãnh đạo một nền văn minh từ Thời kỳ Đồ đá đến Thời đại Thông tin. Chiến tranh tiền lương, tiến hành ngoại giao, nâng cao nền văn hóa của bạn và đối đầu với các nhà lãnh đạo vĩ đại nhất trong lịch sử khi bạn cố gắng xây dựng nền văn minh vĩ đại nhất mà thế giới từng biết đến.\r\n\r\nCivilization VI mang đến những cách thức mới để tương tác với thế giới của bạn: các thành phố giờ đây mở rộng về mặt vật lý trên bản đồ, nghiên cứu tích cực về công nghệ và văn hóa mở ra tiềm năng mới và các nhà lãnh đạo cạnh tranh sẽ theo đuổi chương trình nghị sự của riêng họ dựa trên đặc điểm lịch sử của họ khi bạn chạy đua theo một trong năm cách để đạt được chiến thắng trong trò chơi.\r\n\r\nNHÂN VIÊN MỞ RỘNG:\r\nXem những kỳ quan của đế chế của bạn trải rộng trên bản đồ hơn bao giờ hết. Mỗi thành phố trải dài nhiều ô nên bạn có thể tùy chỉnh xây dựng các thành phố của mình để tận dụng tối đa địa hình địa phương.\r\n\r\nNGHIÊN CỨU CHỦ ĐỘNG:\r\nMở khóa các phần mềm thúc đẩy tăng tốc độ phát triển của nền văn minh của bạn trong suốt lịch sử. Để thăng tiến nhanh hơn, hãy sử dụng các đơn vị của bạn để chủ động khám phá, phát triển môi trường của bạn và khám phá các nền văn hóa mới.\r\n\r\nDIPLOMACY NĂNG ĐỘNG:\r\nTương tác với các nền văn minh khác thay đổi trong suốt quá trình trò chơi, từ những tương tác ban đầu ban đầu nơi xung đột là một thực tế của cuộc sống, đến các liên minh và đàm phán cuối game.\r\n\r\nARMS KẾT HỢP:\r\nMở rộng trên thiết kế \"một đơn vị trên mỗi ô\", các đơn vị hỗ trợ giờ đây có thể được nhúng với các đơn vị khác, như hỗ trợ chống tăng với bộ binh hoặc một chiến binh với quân định cư. Các đơn vị tương tự cũng có thể được kết hợp để tạo thành các đơn vị “Quân đoàn” mạnh mẽ.\r\n\r\nNÂNG CAO ĐA PHƯƠNG TIỆN:\r\nNgoài các chế độ nhiều người chơi truyền thống, hãy hợp tác và cạnh tranh với bạn bè của bạn trong nhiều tình huống khác nhau, tất cả đều được thiết kế để dễ dàng hoàn thành trong một phiên duy nhất.\r\n\r\nMỘT CIV CHO TẤT CẢ NGƯỜI CHƠI:\r\nCivilization VI cung cấp cho những người chơi kỳ cựu những cách thức mới để xây dựng và điều chỉnh nền văn minh của họ để có cơ hội thành công lớn nhất. Hệ thống hướng dẫn mới giới thiệu cho người chơi mới những khái niệm cơ bản để họ có thể dễ dàng bắt đầu.', '/images/Game-covers/civ_vi.jpg', 'GT008', 'C00', '2021-05-01 14:38:15', '2021-05-01 17:23:14'),
('G018', 'DRAGON BALL Z: KAKAROT', NULL, '800000', 180, 'HÃY LÀ NIỀM HY VỌNG CỦA VŨ TRỤ\r\n\r\n• Trải nghiệm câu chuyện của DRAGON BALL Z từ các sự kiện hoành tráng đến các nhiệm vụ phụ nhẹ nhàng, bao gồm cả những khoảnh khắc câu chuyện chưa từng thấy để lần đầu tiên trả lời một số câu hỏi nóng bỏng của truyền thuyết DRAGON BALL!\r\n\r\n• Chơi qua các trận chiến DRAGON BALL Z mang tính biểu tượng trên một quy mô không giống bất kỳ trận đấu nào khác. Chiến đấu trên khắp các chiến trường rộng lớn với môi trường có thể hủy diệt và trải nghiệm những trận đánh trùm hoành tráng chống lại những kẻ thù mang tính biểu tượng nhất (Raditz, Frieza, Cell, v.v.). Tăng mức sức mạnh của bạn thông qua cơ chế RPG và vượt lên thử thách!\r\n\r\n• Đừng chỉ chiến đấu với tư cách là Z Fighters. Hãy sống như họ! Câu cá, bay, ăn, huấn luyện và chiến đấu theo cách của bạn thông qua DRAGON BALL Z sagas, kết bạn và xây dựng mối quan hệ với một dàn nhân vật DRAGON BALL khổng lồ.\r\n\r\nHồi tưởng lại câu chuyện của Goku và các chiến binh Z khác trong DRAGON BALL Z: KAKAROT! Ngoài những trận chiến hoành tráng, hãy trải nghiệm cuộc sống trong thế giới DRAGON BALL Z khi bạn chiến đấu, câu cá, ăn uống và huấn luyện với Goku, Gohan, Vegeta và những người khác. Khám phá các khu vực và cuộc phiêu lưu mới khi bạn tiếp tục câu chuyện và hình thành mối liên kết mạnh mẽ với các anh hùng khác từ vũ trụ DRAGON BALL Z.', '/images/Game-covers/dbz_kakarot.jpg', 'GT001', 'C03', '2021-05-01 14:38:15', '2021-05-01 17:18:14'),
('G019', 'Banished', NULL, '188000', 180, 'Trong trò chơi chiến lược xây dựng thành phố này, bạn điều khiển một nhóm du khách lưu vong quyết định bắt đầu lại cuộc sống của họ ở một vùng đất mới. Họ chỉ có bộ quần áo trên lưng và một chiếc xe đẩy chất đầy đồ dùng từ quê hương của họ.\r\n\r\nNgười dân thị trấn Banished là nguồn lực chính của bạn. Họ sinh ra, lớn lên, làm việc, có con cái của riêng mình, và cuối cùng là chết. Giữ cho chúng khỏe mạnh, vui vẻ và được ăn uống đầy đủ là điều cần thiết để làm cho thị trấn của bạn phát triển. Xây nhà mới thôi là chưa đủ — phải có đủ người dọn đến và có gia đình của riêng họ.\r\n\r\nBanished không có cây kỹ năng. Bất kỳ cấu trúc nào cũng có thể được xây dựng bất cứ lúc nào, với điều kiện là người của bạn đã thu thập các nguồn lực để làm việc đó. Không có tiền. Thay vào đó, các nguồn lực khó kiếm được của bạn có thể bị đánh đổi khi có sự xuất hiện của các tàu thương mại. Những thương nhân này là chìa khóa để thêm gia súc và cây hàng năm vào chế độ ăn của người dân thị trấn; tuy nhiên, con đường buôn bán kéo dài của họ đi kèm với nguy cơ mang bệnh tật từ nước ngoài.\r\n\r\nCó hai mươi nghề khác nhau mà người dân trong thành phố có thể thực hiện từ trồng trọt, săn bắn, rèn đến khai thác mỏ, dạy học và chữa bệnh. Không có chiến lược duy nhất sẽ thành công cho mọi thị trấn. Một số tài nguyên có thể khan hiếm hơn từ bản đồ này sang bản đồ khác. Người chơi có thể chọn trồng lại rừng, khai thác sắt và khai thác đá, nhưng tất cả những lựa chọn này đều yêu cầu dành ra một khoảng không gian mà bạn không thể mở rộng.\r\n\r\nThành công hay thất bại của một thị trấn phụ thuộc vào việc quản lý rủi ro và nguồn lực phù hợp.', '/images/Game-covers/banished.jpg', 'GT008', 'C00', '2021-05-01 14:38:15', '2021-05-01 17:23:40'),
('G020', 'Yakuza 0', NULL, '342000', 900, 'Sự hào nhoáng, quyến rũ và sự suy đồi không thể kiềm chế của những năm 80 đã trở lại trong Yakuza 0.\r\n\r\nChiến đấu như địa ngục qua Tokyo và Osaka với nhân vật chính Kazuma Kiryu và loạt phim Goro Majima thông thường. Vào vai Kazuma Kiryu và khám phá cách anh ta thấy mình trong một thế giới đầy rắc rối khi một vụ đòi nợ đơn giản gặp trục trặc và dấu vết của anh ta bị sát hại. Sau đó, bước vào đôi giày mũi bạc của Goro Majima và khám phá cuộc sống “bình thường” của anh ấy với tư cách là chủ sở hữu của một câu lạc bộ tạp kỹ.\r\n\r\nChuyển đổi giữa ba phong cách chiến đấu khác nhau ngay lập tức và đánh bại tất cả các cách thức của goons, côn đồ, lưu manh và kẻ thấp. Hãy chiến đấu lên một tầm cao bằng cách sử dụng các vật thể trong môi trường như xe đạp, cột biển báo và cửa ô tô để tạo ra các đòn kết hợp xương và hạ gục dã man.\r\n\r\nĐánh nhau không phải là cách duy nhất để giết thời gian ở Nhật Bản năm 1988: từ vũ trường và câu lạc bộ tiếp viên cho đến những cung đường cổ điển của SEGA, có vô số điều phiền nhiễu để theo đuổi trong thế giới ánh đèn neon, chi tiết và phong phú.\r\n\r\nTương tác với những cư dân đầy màu sắc ở khu đèn đỏ: giúp một người thống trị S&M mới chớm nở học nghề của cô ấy hoặc đảm bảo một nghệ sĩ biểu diễn đường phố có thể đến phòng tắm kịp thời - có 100 câu chuyện đáng kinh ngạc để khám phá.', '/images/Game-covers/yakuza_0.jpg', 'GT001', 'C02', '2021-05-01 14:38:15', '2021-05-01 17:01:45'),
('G021', 'Yakuza Kiwami', NULL, '342000', 500, '“Kiwami” có nghĩa là cực đoan.\r\n\r\n1995, Kamurocho… Kazuma Kiryu, Rồng của Dojima, rơi vào tội giết một tên trùm tội phạm để bảo vệ người anh đã thề của mình, Akira Nishikiyama, và người bạn thời thơ ấu của anh, Yumi.\r\n\r\n2005… Akira Nishikiyama đã trở thành một người đàn ông thay đổi. Yumi không ở đâu được tìm thấy. Mười tỷ yên đã biến mất khỏi kho bạc của Gia tộc Tojo, đặt tổ chức này vào bờ vực của cuộc nội chiến. Và Kazuma Kiryu được ra tù đến một thế giới mà anh không còn nhận ra.\r\n\r\nVới lối chơi nâng cao, một câu chuyện điện ảnh mở rộng, sự trở lại của các phong cách chiến đấu từ Yakuza 0, nhiều điểm giải trí về đêm hơn và âm thanh được ghi lại bởi dàn diễn viên trong series, Yakuza Kiwami là phiên bản cuối cùng và “cực đoan” nhất của tầm nhìn ban đầu của , hiện được tối ưu hóa cho PC với độ phân giải 4K, tốc độ khung hình không giới hạn, điều khiển có thể tùy chỉnh và hỗ trợ màn hình siêu rộng.', '/images/Game-covers/yakuza_k1.jpg', 'GT001', 'C00', '2021-05-01 14:38:15', '2021-05-01 17:24:20'),
('G022', 'Yakuza Kiwami 2', NULL, '520000', 800, 'Kazuma Kiryu nghĩ rằng những ngày ở Gia tộc Tojo của anh đã ở phía sau anh. Anh và cô gái trẻ được anh chăm sóc, Haruka Sawamura, đã xây dựng một cuộc sống yên bình từ đống tro tàn của cuộc xung đột. Tất cả những gì chỉ cần một phát súng để phá tan sự yên bình đó. Yukio Terada, Chủ tịch thứ năm của Gia tộc Tojo, đã bị ám sát. Với chiến tranh đang diễn ra, Con rồng huyền thoại của Dojima bị kéo trở lại thế giới mà anh ta muốn bỏ lại phía sau.\r\n\r\nKiryu phải đến Sotenbori, Osaka trong một nỗ lực nhằm tạo hòa bình giữa các gia tộc đối địch, nhưng Ryuji Goda, được gọi là Rồng của Kansai, sẽ không dừng lại ở đó để có được cuộc chiến của mình. Trên thế giới này, chỉ có thể có một con rồng.\r\n\r\nĐược xây dựng lại từ đầu, Yakuza Kiwami 2 sử dụng Dragon Engine để cập nhật một trong những tựa game nổi bật của series thành cổ điển hiện đại. Phiên bản PC bao gồm tất cả các tính năng mà bạn đam mê mong đợi: độ phân giải 4K, tốc độ khung hình đã mở khóa, điều khiển có thể tùy chỉnh và các tùy chọn đồ họa mạnh mẽ.\r\n\r\nChơi các trò chơi nhỏ yêu thích của người hâm mộ bao gồm các phiên bản cập nhật của trình mô phỏng Cabaret Club và Clan Creator, hoặc xem tất cả các phần bổ sung mới như chơi gôn bingo và Toylets.\r\n\r\nMột tính năng mới đối với Kiwami 2 là \'Majima Saga\' có sự góp mặt của Goro Majima trong cuộc phiêu lưu có thể chơi được của riêng anh ấy, tiết lộ các sự kiện xảy ra trước trò chơi.', '/images/Game-covers/yakuza_k2.jpg', 'GT001', 'C00', '2021-05-01 14:38:15', '2021-05-01 17:24:58'),
('G023', 'Yakuza 6: The Song of Life', NULL, '398000', 800, 'Trong Yakuza 6, Kazuma Kiryu sẽ tìm ra chính xác mức độ mà mọi người sẵn sàng hy sinh cho gia đình - đó là những mối quan hệ huyết thống hay ràng buộc - khi anh điều tra một loạt các sự kiện mờ ám liên quan đến những người anh yêu gần gũi nhất trong trái tim mình. Vừa mới mãn hạn tù ba năm, một Kiryu lớn tuổi và phong độ đến phát hiện ra rằng con gái thay thế của anh, Haruka, đã mất tích trong trại trẻ mồ côi mà anh chăm sóc. Con đường mòn dẫn anh đến căn cứ cũ của anh ở Kamurocho, nơi anh phát hiện ra rằng cô đã bị một chiếc xe đâm và hiện đang nằm trong tình trạng hôn mê. Để làm cho vấn đề tồi tệ hơn, Kiryu biết rằng Haruka hiện có một đứa con trai mà anh ấy phải chăm sóc. Với đứa con trong tay, Kiryu hành trình đến thị trấn ven biển Onomichi, Hiroshima để làm sáng tỏ sự thật về Haruka, con trai cô, và một bí mật thâm độc mà yakuza Hiroshima đang che giấu.\r\n\r\nTừ chủ nghĩa hiện thực vô song của bối cảnh mới của Onomichi, một thị trấn cảng xinh đẹp, buồn ngủ ở tỉnh Hiroshima, đến sự phát triển mới nhất của Kamurocho, khu đèn đỏ lớn nhất ở Tokyo, Yakuza 6 là sự lặp lại cuối cùng của trò chơi pha trộn giữa câu chuyện tội ác nghiệt ngã , chiến đấu siêu bùng nổ, và tất cả những tệ nạn và phiền nhiễu mà các địa phương đó phải cung cấp.\r\n\r\nVào “Dragon Engine” - Khám phá thế giới Yakuza hơn bao giờ hết. Yakuza 6 là tựa Yakuza thế hệ hiện tại đầu tiên được phát triển từ đầu cho phần cứng thế hệ hiện tại, giới thiệu thế giới ngầm Nhật Bản đầy sức sống với hình ảnh chi tiết, hình ảnh động như thật, công cụ vật lý mới, mặt tiền cửa hàng tương tác, chuyển tiếp liền mạch và hơn thế nữa.\r\n\r\nKhám phá Kamurocho Reborn và Cảnh đẹp của Onomichi - Những ánh sáng thôi miên, những cư dân cơ hội và những trò tiêu khiển theo chủ nghĩa khoái lạc của Kamurocho trông đẹp hơn bao giờ hết. Các trò chơi nhỏ được cải tiến như karaoke, lồng đánh bóng, phi tiêu, nữ tiếp viên và trò chơi điện tử SEGA đã được sắp xếp hợp lý để mang lại cảm giác sảng khoái tối đa và những bổ sung mới như RIZAP Gym, Cat Café và Clan Creator là những trò tiêu khiển hoàn hảo sau một đêm dài vùi đầu! Nhưng cũng đã đến lúc bạn nên rời xa nhịp sống hối hả và nhộn nhịp của cuộc sống thành phố để đến chơi du lịch ở Onomichi xinh đẹp. Cộng đồng ven biển yên tĩnh này là nơi có rất nhiều hoạt động địa phương như đánh cá trong quán bar, bắn cá (nghĩ rằng game bắn súng đường sắt hành động… với cá), và hơn thế nữa!\r\n\r\nLet the Bodies Hit the Floor - Yakuza 6 Kiryu là một badass được chứng nhận 100%, điều đó có nghĩa là anh ta là một cựu chiến binh thiện chiến khi nói đến nghệ thuật chiến đấu đường phố. Mặc dù lần này anh ta sử dụng một phong cách chiến đấu, nhưng bạn nên tin rằng Kiryu đánh như một chiếc xe tải. Các combo tàn phá và các Hành động Nhiệt tàn phá xương sẽ quay trở lại, nhưng giờ đây Rồng của Dojima có thể lấp đầy một mét để tham gia Chế độ Nhiệt độ Cực hạn. Khi được kích hoạt, Kiryu phát sáng màu xanh lam và tung ra các đòn kết hợp sát thương nặng bằng nắm đấm của mình hoặc bất kỳ “công cụ” nào ở gần trong tầm tay.\r\n\r\nÂm thanh tiếng Nhật hoàn toàn được lồng tiếng - Lần đầu tiên trong lịch sử loạt phim, mọi câu thoại và đoạn hội thoại đều được lồng tiếng hoàn toàn bằng tiếng Nhật. Hãy để câu chuyện kịch tính và hài hước vô lý của bộ truyện diễn ra như một trải nghiệm phim tương tác nước ngoài.', '/images/Game-covers/yakuza_6.jpg', 'GT001', 'C03', '2021-05-01 14:38:15', '2021-05-01 17:14:18');

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `MSKH` char(5) NOT NULL,
  `HoTenKH` varchar(40) DEFAULT NULL,
  `DiaChi` varchar(50) DEFAULT NULL,
  `SoDienThoai` varchar(12) DEFAULT NULL,
  `Email` text DEFAULT NULL,
  `MatKhau` char(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`MSKH`, `HoTenKH`, `DiaChi`, `SoDienThoai`, `Email`, `MatKhau`) VALUES
('123', 'Tôn Trọng Lương123', 'TP.Bạc Liêu', '0913245842', 'ttluong48691@gmail.com', '$2y$10$49Bl9VlRmyh0xlXhFros8.9KcdUFFTT7cGr9P2Dk5VBDskzhtN/A2'),
('abc', 'Tôn Trọng Lương', 'TP.Bạc Liêu', '0913245842', 'ttluong48639@gmail.com', '$2y$10$lvE4jjuwXeAcMzZoiY.1Ke/YrXgkU/X5ewsmG86tdwZ3pdb.w0SvG'),
('gnoul', 'Lương', 'TP.Bạc Liêu', '0913245842', 'ttluong4869@gmail.com', '$2y$10$/xrmG8Pnw6xTlVAB8CTd9eTRJ0D.grHR7VqwGxkaScBjB9fD3LOg6'),
('xyz', 'xyz', 'TP.Bạc Liêu', '0913245842', 'ttluong48269@gmail.com', '$2y$10$Lk86FsdQ1WIBO2h.wnwUP.WYzu6Nq1UasCeBgqd.PQ5wOzc40Yy7a');

-- --------------------------------------------------------

--
-- Table structure for table `loaihanghoa`
--

CREATE TABLE `loaihanghoa` (
  `MaLoaiHang` char(5) NOT NULL,
  `TenLoaiHang` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loaihanghoa`
--

INSERT INTO `loaihanghoa` (`MaLoaiHang`, `TenLoaiHang`) VALUES
('GT001', 'Hành động'),
('GT002', 'Nhập vai'),
('GT003', 'Phiêu lưu'),
('GT004', 'Bắn súng'),
('GT005', 'Thể thao'),
('GT006', 'Sinh tồn'),
('GT007', 'Đối kháng'),
('GT008', 'Chiến thuật');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MSNV` char(5) NOT NULL,
  `HoTenNV` varchar(40) DEFAULT NULL,
  `ChucVu` varchar(40) DEFAULT NULL,
  `DiaChi` varchar(50) DEFAULT NULL,
  `SoDienThoai` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`MSNV`, `HoTenNV`, `ChucVu`, `DiaChi`, `SoDienThoai`) VALUES
('gnoul', 'Tôn Trọng Lương', 'Giám Đốc', 'TP.Bạc Liêu', '0913245842');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`code_category`);

--
-- Indexes for table `chitietdathang`
--
ALTER TABLE `chitietdathang`
  ADD PRIMARY KEY (`SoDonDH`,`MSHH`),
  ADD KEY `MSHH` (`MSHH`);

--
-- Indexes for table `dathang`
--
ALTER TABLE `dathang`
  ADD PRIMARY KEY (`SoDonDH`),
  ADD KEY `MSKH` (`MSKH`);

--
-- Indexes for table `diachikh`
--
ALTER TABLE `diachikh`
  ADD PRIMARY KEY (`MaDC`),
  ADD KEY `MSKH` (`MSKH`);

--
-- Indexes for table `hanghoa`
--
ALTER TABLE `hanghoa`
  ADD PRIMARY KEY (`MSHH`),
  ADD KEY `MaLoaiHang` (`MaLoaiHang`),
  ADD KEY `code_category` (`code_category`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MSKH`);

--
-- Indexes for table `loaihanghoa`
--
ALTER TABLE `loaihanghoa`
  ADD PRIMARY KEY (`MaLoaiHang`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MSNV`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitietdathang`
--
ALTER TABLE `chitietdathang`
  ADD CONSTRAINT `chitietdathang_ibfk_1` FOREIGN KEY (`SoDonDH`) REFERENCES `dathang` (`SoDonDH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chitietdathang_ibfk_2` FOREIGN KEY (`MSHH`) REFERENCES `hanghoa` (`MSHH`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dathang`
--
ALTER TABLE `dathang`
  ADD CONSTRAINT `dathang_ibfk_1` FOREIGN KEY (`MSKH`) REFERENCES `khachhang` (`MSKH`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `diachikh`
--
ALTER TABLE `diachikh`
  ADD CONSTRAINT `diachikh_ibfk_1` FOREIGN KEY (`MSKH`) REFERENCES `khachhang` (`MSKH`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hanghoa`
--
ALTER TABLE `hanghoa`
  ADD CONSTRAINT `hanghoa_ibfk_1` FOREIGN KEY (`MaLoaiHang`) REFERENCES `loaihanghoa` (`MaLoaiHang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hanghoa_ibfk_2` FOREIGN KEY (`code_category`) REFERENCES `category` (`code_category`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

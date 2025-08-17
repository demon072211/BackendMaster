<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['game_match'] =
	array(
		"Audition" => "Slot Đua xe",
		"BENLEY" => "Slot Bitcoin",
		"BaCay" => "Game bài ba cây",
		"BauCua" => "Bầu cua",
		"CANDY" => "Slot pokemon",
		"CaoThap" => "Cao thấp",
		"Exchange" => "Đổi tiền",
		"MAYBACH" => "Slot thể thao",
		"MiniPoker" => "Minipoker",
		"Spartan" => "Slot Thần tài",
		"TAMHUNG" => "Slot chim điên",
		"TaiXiu" => "Tài xỉu",
		"Tlmn" => "Tiến lên miền nam",
		"XocDia" => "Xóc đĩa",
		"ag" => "Game AG",
		"ibc" => "Game IBC",
		"cmd" => "Game CMD",
		"wm" => "Game WM",
		"CHIEMTINH" => "Game chiêm tinh",
		"TAI_XIU_ST" => "Tài xỉu siêu tốc",
		"ROLL_ROYE" => "Thần bài",
		"BIKINI" => "Bikini",
		"GALAXY" => "Galaxy",
		"RANGE_ROVER" => "RANGE_ROVER",
		"FISH" => "Bắn cá",
		"ebet" => "Ebet",
		"sbo" => "Sbo",
	);

$config['game_name'] = array(
    "wm" => 'VM',
    "ibc" => 'IBC',
    "ag" => 'AG',
    "bacay" => 'Ba cây',
    "xocdia" => 'Xóc đĩa',
    "minipoker" => 'Mini Pocker',
    "slot_pokemon" => 'Slot Pokemon',
    "baucua" => 'Bầu cua',
    "taixiu" => 'Tài xỉu',
    "caothap" => 'Cao thấp',
    "slot_bitcoin" => 'Slot bitcoin',
    "slot_angrybird" => 'Slot angry bird',
    "slot_thantai" => 'Slot thần tài',
    "slot_thethao" => 'Slot thể thao',
);

$config['game_bai_uri_return'] = array(
    "BaiCao" => 'loggamebai/sam',
    "BaCay" => 'loggamebai/bacay',
    "XocDia" => 'loggamebai/binh',
    "Tlmn" => 'loggamebai/tlmn',
);
$config['agent_uri_return'] = array(
    "listAgency" => 'agency/listAgency',
    "listAgencyWithCount" => 'agency/listAgencyWithCount',
);
$config['tai_xiu_uri_return'] = array(
    "history" => 'logminigame',
    "detail" => 'logminigame/accounttaixiu',
);
$config['role_map'] = array(
    "W" => 'SYS',
    "LM" => 'MKT_LEADER',
    "M" => 'MKT',
    "S" => 'CSKH',
    "LS" => 'CSKH_LEADER',
    "L" => null, // lanh dao
    "D" => null, // cham soc dai ly
    "Q" => null, // quan ly chung
    "K" => 'PAY',
    "C" => null, // Developer
    "A" => 'ADM',
);
$config['event_gift_code'] = array(
    "1" => 'Sự kiện +58k',
    "2" => 'Sự kiện +78k',
    "3" => 'Sự kiện 3',
    "4" => 'Sự kiện 4',
    "5" => '5',
    "6" => '6',
    "7" => '7',
    "8" => '8',
    "9" => '9',
    "10" => '10',
);
$config['default_code'] = 'referral_code_default';
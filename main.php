<?php

/**
 * @file
 * ブラックジャックのメイン処理.
 */

namespace BlackJack;

require_once dirname(__FILE__) . '/src/Deck.php';
require_once dirname(__FILE__) . '/src/Player.php';


function puts($message = '') {
  $color_codes = [
    'reset' => '0;0',
    'black' => '0;30',
    'red' => '0;31',
    'green' => '0;32',
    'brown' => '0;33',
    'blue' => '0;34',
    'purple' => '0;35',
    'cyan' => '0;36',
    'yellow' => '1;33',
    'white' => '1;37',
  ];

  $patterns = array_map(function ($color) {
    return "/<{$color}>/";
  }, array_keys($color_codes));

  $replacements = array_map(function ($code) {
    return "\033[{$code}m";
  }, array_values($color_codes));

  $message = preg_replace($patterns, $replacements, $message);
  echo "{$message}\033[0;0m\n";
}

puts('<green>★☆★☆★☆★☆ ブラックジャックへようこそ ☆★☆★☆★☆★');
puts('ゲームを開始します');
puts();

// 山札の生成.
$deck = new Deck();

// プレイヤー、ディーラーの生成.
$player = new Player('あなた', $deck);
$dealer = new Player('ディーラー', $deck);

// プレイヤーの初期カードを引く.
for ($i = 0; $i < 2; $i++) {
  puts("<cyan>{$player->choiseCard()}");
}

puts();

// ディーラーの初期カードを引く.
for ($i = 0; $i < 2; $i++) {
  puts("<purple>{$dealer->choiseCard($i == 1)}");
}

puts();

// プレイヤーの入力に基づきカードを引く.
do {
  $player_total = $player->getCardsScore();
  puts("{$player->getName()}の現在の得点は<red>${player_total}<reset>です");
  if ($player->isBurst()) {
    break;
  }
  puts('カードを引きますか？引く場合は<cyan>Y<reset>を、引かない場合は<cyan>N<reset>を入力してください。');

  $stdin = mb_strtolower(trim(fgets(STDIN)));
  switch ($stdin) {
    case 'y':
      puts("<cyan>{$player->choiseCard()}");
      break;

    case 'n':
      break;

    default:
      puts("<red>'Y' または 'N' を入力してください。");
  }
} while ($stdin != 'n');

puts();

// ディーラーが2枚目に引いたカード情報及び得点を表示.
puts("<purple>{$dealer->getSelectedCard(2)}");
$dealer_total = $dealer->getCardsScore();
puts("{$dealer->getName()}の現在の得点は<red>${dealer_total}<reset>です");

// ディーラーのカードを引く.
while ($dealer_total <= 17 && !$player->isBurst()) {
  puts("<purple>{$dealer->choiseCard()}");
  $dealer_total = $dealer->getCardsScore();
}

puts();

puts("{$player->getName()}の得点は<red>${player_total}<reset>です");
puts("{$dealer->getName()}の得点は<red>${dealer_total}<reset>です");

puts();

// 勝敗判定.
puts("<red>{$player->printVictoryOrDefeat($dealer)}");

puts('ブラックジャック終了。また遊んでね');

<?php

/**
 * @file
 * ブラックジャックのメイン処理.
 */

namespace BlackJack;

require_once dirname(__FILE__) . '/src/Deck.php';
require_once dirname(__FILE__) . '/src/Player.php';

/**
 * 標準出力に引数で指定したメッセージを出力する.
 *
 * @param string $message
 *   メッセージ.
 */
function puts($message = '') {
  // 色変換を行う対比表.
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
  // preg_replace用のパターンに変換.
  $patterns = array_map(function ($color) {
    return "/<{$color}>/";
  }, array_keys($color_codes));
  // 標準出力に出力するカラーコードに変換.
  $replacements = array_map(function ($code) {
    return "\033[{$code}m";
  }, array_values($color_codes));
  // 色変換を行い、改行コードを追加し出力.
  $message = preg_replace($patterns, $replacements, $message);
  echo "{$message}\033[0;0m\n";
}

/**
 * 引数で指定したプレイヤーのカード・得点を出力.
 *
 * @param Player $player
 *   プレイヤークラス.
 */
function print_cards_and_score(Player $player) {
  puts("========== {$player->getName()} の全カード ==========");
  puts($player->printAllCards());

  puts("========== {$player->getName()} の得点 ==========");
  puts($player->printCardScore());

  puts();
}

// ブラックジャックスタート.
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
  puts($player->printCardScore());
  if ($player->isBust()) {
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
puts($dealer->printCardScore());

// ディーラーのカードを引く.
while ($dealer_total <= 17) {
  puts("<purple>{$dealer->choiseCard()}");
  $dealer_total = $dealer->getCardsScore();
}

puts();

// プレイヤー及びディーラーの全カード・得点を出力.
print_cards_and_score($player);
print_cards_and_score($dealer);

// 勝敗判定.
puts("<red>{$player->printVictoryOrDefeat($dealer)}");

puts('ブラックジャック終了。また遊んでね');

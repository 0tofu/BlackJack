<?php

/**
 * @file
 * ブラックジャックのメイン処理.
 */

namespace BlackJack;

require_once dirname(__FILE__) . '/src/Deck.php';
require_once dirname(__FILE__) . '/src/Player.php';

echo "★☆★☆★☆★☆ ブラックジャックへようこそ ☆★☆★☆★☆★\n";
echo "ゲームを開始します\n";

$deck = new Deck();

$player = new Player($deck);
$dealer = new Player($deck);

for ($i = 0; $i < 2; $i++) {
  $card = $player->choiseCard();
  echo "あなたの引いたカードは${card}です\n";
}

for ($i = 0; $i < 2; $i++) {
  $card = $dealer->choiseCard();
  if ($i == 0) {
    echo "ディーラーの引いたカードは${card}です\n";
  }
  else {
    echo "ディーラーの2枚目のカードはわかりません\n";
  }
}

echo "\n";

do {
  $player_total = $player->getCardsSum();
  echo "あなたの現在の得点は${player_total}です\n";
  if ($player->isBurst()) {
    break;
  }
  echo "カードを引きますか？引く場合はYを、引かない場合はNを入力してください。\n";

  $stdin = trim(fgets(STDIN));
  switch ($stdin) {
    case 'y':
    case 'Y':
      $card = $player->choiseCard();
      echo "あなたの引いたカードは${card}です\n";
      break;

    case 'n':
    case 'N':
      $stdin = 'n';
      break;

    default:
      echo "'Y' または 'N' を入力してください。";
  }
} while ($stdin != 'n');

echo "\n";

$dealer_card = $dealer->getSelectedCard(2);
echo "ディーラーの2枚目のカードは${dealer_card}です\n";

$dealer_total = $dealer->getCardsSum();
echo "ディーラーの現在の得点は${dealer_total}です\n";

while ($dealer_total <= 17 && !$player->isBurst()) {
  $card = $dealer->choiseCard();
  echo "ディーラーの引いたカードは${card}です\n";
  $dealer_total = $dealer->getCardsSum();
}

echo "\n";

echo "あなたの得点は${player_total}です\n";
echo "ディーラーの得点は${dealer_total}です\n";

if ($player->isBurst() && $dealer->isBurst()) {
  echo "引き分けです\n";
} elseif ($player_total == $dealer_total) {
  echo "引き分けです\n";
} elseif (($player_total > $dealer_total && !$player->isBurst()) || $dealer->isBurst()) {
  echo "あなたの勝ちです\n";
} else {
  echo "ディーラーの勝ちです\n";
}

echo "ブラックジャック終了。また遊んでね\n";

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

$player = new Player('あなた', $deck);
$dealer = new Player('ディーラー', $deck);

for ($i = 0; $i < 2; $i++) {
  echo $player->choiseCard();
}

for ($i = 0; $i < 2; $i++) {
  echo $dealer->choiseCard($i == 1);
}

echo "\n";

do {
  $player_total = $player->getCardsScore();
  echo "{$player->getName()}の現在の得点は${player_total}です\n";
  if ($player->isBurst()) {
    break;
  }
  echo "カードを引きますか？引く場合はYを、引かない場合はNを入力してください。\n";

  $stdin = mb_strtolower(trim(fgets(STDIN)));
  switch ($stdin) {
    case 'y':
      echo $player->choiseCard();
      break;

    case 'n':
      break;

    default:
      echo "'Y' または 'N' を入力してください。";
  }
} while ($stdin != 'n');

echo "\n";

echo $dealer->getSelectedCard(2);

$dealer_total = $dealer->getCardsScore();
echo "{$dealer->getName()}の現在の得点は${dealer_total}です\n";

while ($dealer_total <= 17 && !$player->isBurst()) {
  echo $dealer->choiseCard();
  $dealer_total = $dealer->getCardsScore();
}

echo "\n";

echo "{$player->getName()}の得点は${player_total}です\n";
echo "{$dealer->getName()}の得点は${dealer_total}です\n";

if ($player->isBurst() || (!$dealer->isBurst() && $dealer_total > $player_total)) {
  echo "{$dealer->getName()}の勝ちです。";
}
elseif ($dealer->isBurst() || $player_total > $dealer_total) {
  echo "{$player->getName()}の勝ちです。";
}
else {
  echo "引き分けです。";
}

echo "ブラックジャック終了。また遊んでね\n";

<?php

namespace BlackJack;

require_once './Player.php';

echo "★☆★☆★☆★☆ ブラックジャックへようこそ ☆★☆★☆★☆★\n";
echo "ゲームを開始します\n";

$player = new Player();
$dealer = new Player();

for ($i = 0; $i < 2; $i++) {
  $card = join('の', $player->choiseCard());
  echo "あなたの引いたカードは${card}です\n";
}

for ($i = 0; $i < 2; $i++) {
  $card = join('の', $dealer->choiseCard());
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
  if ($player_total >= 21) {
    break;
  }
  echo "カードを引きますか？引く場合はYを、引かない場合はNを入力してください。\n";

  $stdin = trim(fgets(STDIN));
  switch ($stdin) {
    case 'y':
    case 'Y':
      $card = implode('の', $player->choiseCard());
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

$dealer_card = implode('の', $dealer->getSelectedCard(2));
echo "ディーラーの2枚目のカードは${dealer_card}です\n";

$dealer_total = $dealer->getCardsSum();
echo "ディーラーの現在の得点は${dealer_total}です\n";

while ($dealer_total <= 17 && $player_total <= 21) {
  $card = implode('の', $dealer->choiseCard());
  echo "ディーラーの引いたカードは${card}です\n";
  $dealer_total = $dealer->getCardsSum();
}

echo "あなたの得点は${player_total}です\n";
echo "ディーラーの得点は${dealer_total}です\n";

if ($player_total > 21 && $dealer_total > 21) {
  echo "引き分けです\n";
} elseif ($player_total == $dealer_total) {
  echo "引き分けです\n";
} elseif ($player_total > $dealer_total || $dealer_total > 21) {
  echo "あなたの勝ちです\n";
} else {
  echo "ディーラーの勝ちです\n";
}

echo "ブラックジャック終了。また遊んでね\n";

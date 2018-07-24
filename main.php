<?php

/**
 * @file
 * ブラックジャックのメイン処理.
 */

namespace BlackJack;

require_once dirname(__FILE__) . '/src/Deck.php';
require_once dirname(__FILE__) . '/src/Player.php';
require_once dirname(__FILE__) . '/src/Dealer.php';
require_once dirname(__FILE__) . '/src/Utils.php';

// ブラックジャックスタート.
Utils::puts('<green>★☆★☆★☆★☆ ブラックジャックへようこそ ☆★☆★☆★☆★');
Utils::puts('ゲームを開始します');
Utils::puts();

// 山札の生成.
$deck = new Deck();

// プレイヤー、ディーラーの生成.
$players = [
  new Player('あなた', $deck),
  new Dealer('ディーラー', $deck),
];

// プレイヤー、ディーラーの初回のカードを引く.
foreach ($players as $player) {
  $player->giveOutCards();
}

// プレイヤー、ディーラーの以降のカードを引く.
foreach ($players as $player) {
  $player->confirmCard();
}

// プレイヤー及びディーラーの全カード・得点を出力.
foreach ($players as $player) {
  Utils::puts($player->printAllCardsAndScore());
}

// 勝敗判定.
Utils::puts("<red>{$players[0]->printVictoryOrDefeat($players[1])}");

Utils::puts('ブラックジャック終了。また遊んでね');

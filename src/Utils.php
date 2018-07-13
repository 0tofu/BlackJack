<?php

namespace BlackJack;

/**
 * Class Utils.
 *
 * @package BlackJack
 */
class Utils {

  /**
   * 標準出力に引数で指定したメッセージを出力する.
   *
   * @param string $message
   *   メッセージ.
   */
  public static function puts($message = '') {
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

}

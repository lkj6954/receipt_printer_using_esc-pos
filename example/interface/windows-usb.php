<?php
/* Change to the correct path if you copy this example! */
require __DIR__ . '/../../vendor/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


/**
 * Install the printer using USB printing support, and the "Generic / Text Only" driver,
 * then share it (you can use a firewall so that it can only be seen locally).
 *
 * Use a WindowsPrintConnector with the share name to print.
 *
 * Troubleshooting: Fire up a command prompt, and ensure that (if your printer is shared as
 * "Receipt Printer), the following commands work:
 *
 *  echo "Hello World" > testfile
 *  copy testfile "\\%COMPUTERNAME%\Receipt Printer"
 *  del testfile
 */
try {
    // Enter the share name for your USB printer here
    // $connector = null;
    $connector = new WindowsPrintConnector("SAM4S GIANT-100");

    /* Print a "Hello world" receipt" */
    $printer = new Printer($connector);

    $printer->text(iconv("UTF-8", "CP949", "주문일시 : 22.03.12") . "\n");
    $printer->text(iconv("UTF-8", "CP949", "5번 테이블") . "\n");
    $printer->text(iconv("UTF-8", "CP949", "메뉴명 개수 유저닉네임") . "\n");
    $printer->text(iconv("UTF-8", "CP949", "추천멘트") . "\n");
    $printer->cut();

    /* Close printer */
    $printer->close();
} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
}

function title(Printer $printer, $str)
{
    $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
    $printer->text($str);
    $printer->selectPrintMode();
}